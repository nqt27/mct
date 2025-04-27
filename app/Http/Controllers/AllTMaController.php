<?php

namespace App\Http\Controllers;

use App\Models\Audio;
use App\Models\DichVu;
use App\Models\Logo;
use App\Models\MenuDichVu;
use App\Models\Slide;
use App\Models\TheLoai;
use App\Models\User;
use App\Notifications\FormSubmitted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class AllTMaController extends Controller
{
    public function index()
    {

        $audio = Audio::where('display', 1)->get();


        return view('allTMa', ['audio' => $audio]);
    }
    public function phanloai($loai, $slug = null)
    {
        // Mặc định query audio có display = 1
        $query = Audio::where('display', 1);

        // Kiểm tra loại: truyen-ngan hay truyen-dai
        if ($loai == 'truyen-ngan') {
            $query->where('is_series', 0); // 0 là ngắn
        } elseif ($loai == 'truyen-dai') {
            $query->where('is_series', 1); // 1 là dài
        } else {
            abort(404); // Loại không hợp lệ thì cho 404
        }

        // Nếu có slug thể loại con
        if ($slug) {
            // Tìm thể loại cha hoặc con theo slug
            $theloaiCha = TheLoai::where('slug', $slug)->first();
            if (!$theloaiCha) {
                abort(404);
            }

            // Lấy id của chính nó và con nó (nếu có)
            $theloaiCon = TheLoai::where('parent_id', $theloaiCha->id)->pluck('id')->toArray();
            $theloaiIds = array_merge([$theloaiCha->id], $theloaiCon);

            $query->whereIn('theloai_id', $theloaiIds);
        }

        // Cuối cùng lấy dữ liệu
        $audio = $query->get();

        return view('allTMa', ['audio' => $audio]);
    }
}
