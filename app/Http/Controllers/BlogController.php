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
        $blog = Blog::where('display', 1)->orderBy('order')->get();
        return view('blogTMa', ['blog' => $blog]);
    }
    public function phanloai($slug)
    {
       // Lấy thể loại cha theo slug
       $theloaiCha = MenuBlog::where('slug', $slug)->first();

       if (!$theloaiCha) {
           abort(404); // Không tìm thấy thể loại
       }

       // Function to get all descendant IDs recursively
       function getAllDescendantIds($categoryId) {
           $children = MenuBlog::where('parent_id', $categoryId)->pluck('id');
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
       $blog = Blog::where('display', 1)
           ->whereIn('menu_id', $theloaiIds)
           ->orderBy('order') 
           ->get();

       // Pass the category name to the view as well, if needed for display
       return view('blogTMa', ['blog' => $blog, 'categoryName' => $theloaiCha->name]);
    }
}
