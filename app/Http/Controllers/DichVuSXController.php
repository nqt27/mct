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

class DichVuSXController extends Controller
{
    public function index()
    {
        $logo = Logo::first();
        $hot_audio = Audio::where('nghenhieu', 1)->take(6)->get(); // Nếu `new` lưu là số 1
        $new_audio = Audio::where('moi', 1)->take(6)->get(); // Nếu `new` lưu là số 1
        $menu = TheLoai::whereNull('parent_id') // Chỉ lấy menu cha
            ->with('submenu')
            ->orderBy('position') // Sắp xếp theo vị trí
            ->get();
        $slide = Slide::where('display', 1)->get();
        $dichvu = DichVu::take(6)->orderBy('order')->get(); // Nếu `new` lưu là số 1

        return view('dvsx', ['logo' => $logo, 'hot_audio' => $hot_audio, 'new_audio' => $new_audio, 'menu' => $menu, 'dichvu' => $dichvu, 'slide' => $slide]);
    }
    public function phanloai($slug)
    {
        // Lấy thể loại cha theo slug
        $theloaiCha = MenuDichVu::where('slug', $slug)->first();

        if (!$theloaiCha) {
            abort(404); // Không tìm thấy thể loại
        }
 
        // Function to get all descendant IDs recursively
        function getAllDescendantIds($categoryId) {
            $children = MenuDichVu::where('parent_id', $categoryId)->pluck('id');
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
        $dichvu = DichVu::where('display', 1)
            ->whereIn('menu_id', $theloaiIds)
            ->orderBy('order')
            ->get();
 
        // Pass the category name to the view as well, if needed for display
        return view('dvsx', ['dichvu' => $dichvu, 'categoryName' => $theloaiCha->name]);
    }
    public function detail($slug)
    {
        $dichvu = DichVu::where('slug', $slug)->first();

        return view('detail-dichvu', ['dichvu' => $dichvu]);
    }
}
