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

        $audio = Audio::where('display', 1)->orderBy('order')->get();


        return view('allTMa', ['audio' => $audio]);
    }
    public function phanloai($slug = null)
    {
        // Mặc định query audio có display = 1
        $query = Audio::where('display', 1);

       

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
        $audio = $query->orderBy('order')->get();

        return view('allTMa', ['audio' => $audio]);
    }
}
