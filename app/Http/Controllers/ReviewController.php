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
        
        $review = Review::orderBy('order')->take(6)->get(); // Nếu `new` lưu là số 1

        return view('review', ['review' => $review]);
    }
    public function phanloai($slug)
    {
       // Lấy thể loại cha theo slug
       $theloaiCha = MenuReview::where('slug', $slug)->first();

       if (!$theloaiCha) {
           abort(404); // Không tìm thấy thể loại
       }

       // Function to get all descendant IDs recursively
       function getAllDescendantIds($categoryId) {
           $children = MenuReview::where('parent_id', $categoryId)->pluck('id');
           $allIds = $children->toArray();
           foreach ($children as $childId) {
               $allIds = array_merge($allIds, getAllDescendantIds($childId));
           }
           return $allIds;
       }

       // Get IDs of the parent category and all its descendants
       $descendantIds = getAllDescendantIds($theloaiCha->id);
       $theloaiIds = array_merge([$theloaiCha->id], $descendantIds);

       // Lấy tất cả dichvu thuộc các thể loại đó
       $review = Review::where('display', 1)
           ->whereIn('menu_id', $theloaiIds)
           ->get();

       // Pass the category name to the view as well, if needed for display
       return view('review', ['review' => $review, 'categoryName' => $theloaiCha->name]);
    }
    
    public function detail($slug)
    {
        $review = Review::where('slug', $slug)->first();

        return view('review-detail', ['review' => $review]);
    }
}
