<?php

namespace App\Http\Controllers;

use App\Models\Audio;
use App\Models\DichVu;
use App\Models\Logo;
use App\Models\MenuDichVu;
use App\Models\MenuReview;
use App\Models\Review;
use App\Models\Slide;
use App\Models\TheLoai;
use App\Models\User;
use App\Notifications\FormSubmitted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class ReviewController extends Controller
{
    public function index()
    {
        
        $review = Review::take(6)->get(); // Nếu `new` lưu là số 1

        return view('review', ['review' => $review]);
    }
    public function phanloai($slug)
    {
        // Lấy thể loại cha theo slug
        $theloaiCha = MenuReview::where('slug', $slug)->first();

        if (!$theloaiCha) {
            abort(404); // Không tìm thấy thể loại
        }

        // Lấy tất cả thể loại con của thể loại cha
        $theloaiCon = MenuReview::where('parent_id', $theloaiCha->id)->pluck('id')->toArray();

        // Gộp id cha + id các con lại
        $theloaiIds = array_merge([$theloaiCha->id], $theloaiCon);

        // Lấy tất cả audio thuộc các thể loại đó
        $review = Review::where('display', 1)
            ->whereIn('menu_id', $theloaiIds)
            ->get();

        return view('review', ['review' => $review]);
    }
    public function detail($slug)
    {
        $review = Review::where('slug', $slug)->first();

        return view('review-detail', ['review' => $review]);
    }
}
