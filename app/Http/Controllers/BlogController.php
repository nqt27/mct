<?php

namespace App\Http\Controllers;

use App\Models\Audio;
use App\Models\Blog;
use App\Models\DichVu;
use App\Models\Logo;
use App\Models\MenuBlog;
use App\Models\MenuDichVu;
use App\Models\Slide;
use App\Models\TheLoai;
use App\Models\User;
use App\Notifications\FormSubmitted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class BlogController extends Controller
{
    public function index()
    {
        $blog = Blog::where('display', 1)->get();
        return view('blogTMa', ['blog' => $blog]);
    }
    public function phanloai($slug)
    {
        // Lấy thể loại cha theo slug
        $theloaiCha = MenuBlog::where('slug', $slug)->first();

        if (!$theloaiCha) {
            abort(404); // Không tìm thấy thể loại
        }

        // Lấy tất cả thể loại con của thể loại cha
        $theloaiCon = MenuBlog::where('parent_id', $theloaiCha->id)->pluck('id')->toArray();

        // Gộp id cha + id các con lại
        $theloaiIds = array_merge([$theloaiCha->id], $theloaiCon);

        // Lấy tất cả audio thuộc các thể loại đó
        $blog = Blog::where('display', 1)
            ->whereIn('menu_id', $theloaiIds)
            ->get();

        return view('blogTMa', ['blog' => $blog]);
    }
}
