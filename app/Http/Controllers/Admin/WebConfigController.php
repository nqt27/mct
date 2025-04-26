<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WebConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WebConfigController extends Controller
{
    public function index()
    {
        $config = WebConfig::firstOrNew();
        return view('admin.web-config', compact('config'));
    }

    public function store(Request $request)
    {
        try {
            // Validate request
            

            // Get or create web config
            $config = WebConfig::firstOrNew();

            // Update all fields
            $config->fill($request->only([
                'facebook',
                'youtube',
                'instagram',
                'shopee',
                'tiktok',
                'phone',
                'email',
                'address',
                'zalo',
                'google_maps_iframe',
                'payment_info'
            ]));

            $config->save();

            // Clear cache if you're caching settings
            // Cache::forget('web_config');

            return response()->json([
                'status' => 'success',
                'message' => 'Cập nhật cấu hình thành công',
                'data' => $config
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getConfig()
    {
        try {
            $config = WebConfig::firstOrFail();
            return response()->json([
                'status' => 'success',
                'data' => $config
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Không tìm thấy cấu hình'
            ], 404);
        }
    }
}
