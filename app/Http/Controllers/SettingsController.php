<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Settings;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Settings::first();
        return view('admin.website-settings', compact('settings'));
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'content' => 'nullable|string',
                'analytics_code' => [
                    'nullable',
                    'regex:/^G-[A-Z0-9]{10}$/',
                    function ($attribute, $value, $fail) {
                        if (!empty($value) && !$this->validateAnalyticsCode($value)) {
                            $fail('Mã Google Analytics không hợp lệ hoặc không thể kết nối');
                        }
                    },
                ],
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Dữ liệu không hợp lệ',
                    'errors' => $validator->errors()
                ], 422);
            }

            $settings = Settings::firstOrNew();
            $settings->fill($request->only([
                'content',
                'analytics_code'
            ]));

            // Auto-generate analytics script if code is provided
            if ($request->filled('analytics_code')) {
                $settings->analytics_script = $settings->getAnalyticsScript();
            }

            $settings->updated_by = Auth::id();
            $settings->save();

            Cache::forget('website_settings');
            Cache::forget('analytics_code');

            return response()->json([
                'success' => true,
                'message' => 'Cài đặt Google Analytics đã được cập nhật'
            ]);
        } catch (\Exception $e) {
            Log::error('Analytics update error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi cập nhật Google Analytics'
            ], 500);
        }
    }

    protected function validateAnalyticsCode($code)
    {
        try {
            $url = "https://www.google-analytics.com/analytics.js";
            $headers = get_headers($url);
            return stripos($headers[0], "200 OK") !== false;
        } catch (\Exception $e) {
            return false;
        }
    }
}
