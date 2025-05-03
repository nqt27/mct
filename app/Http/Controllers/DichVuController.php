<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\MenuDichVu;
use App\Models\DichVu;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DichVuController extends Controller
{
    public function index()
    {
        $menu = MenuDichVu::all();
        $selectmenu = MenuDichVu::with('submenu') // Lấy menu cha
            ->whereNull('parent_id') // Lấy luôn menu con
            ->orderBy('position') // Sắp xếp theo vị trí
            ->get();
        $dichvu = DichVu::orderBy('order')->get();
        return view('admin.dichvu',  ['dichvu' => $dichvu, 'menu' => $menu, 'selectmenu' => $selectmenu]);
    }
    public function add()
    {
        $menu = MenuDichVu::with('submenu') // Lấy menu cha
            ->whereNull('parent_id') // Lấy luôn menu con
            ->orderBy('position') // Sắp xếp theo vị trí
            ->get();

        return view('admin.add-dichvu', ['menu' => $menu]);
    }
    public function store(Request $request)
    {
        // Kiểm tra dữ liệu đầu vào
        $validatedData = $request->validate([
            'slug' => 'nullable|string|max:255',
            'tieude' => 'nullable|string|max:255',
            'noidung' => 'nullable|string',
            'menu_id' => 'required|integer|exists:menu_dichvu,id',
            'menu_id2' => 'nullable|integer|exists:menu_dichvu,id',
            'keyword_focus' => 'nullable|string|max:255',
            'seo_title' => 'nullable|string|max:255',
            'seo_keywords' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string',
            'display' => 'boolean',
            'is_new' => 'boolean',
            'image' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        // Tạo sản phẩm mới
        $dichvu = new DichVu();


        // Lưu các dữ liệu cơ bản
        if ($request->hasFile('image')) {
            // Store the new image
            $image = $request->file('image');
            $avatarName = $image->getClientOriginalName();
            $image->move(public_path('images'), $avatarName);

            $dichvu->image = $avatarName;
        }

        $dichvu->slug = $request->input('slug');
        $dichvu->tieude = $request->input('tieude');
        $dichvu->noidung = $request->input('noidung');
        $dichvu->menu_id = $request->input('menu_id3') ?: $request->input('menu_id2') ?: $request->input('menu_id');
        
        $dichvu->keyword_focus = $request->input('keyword_focus');
        $dichvu->seo_title = $request->input('seo_title');
        $dichvu->seo_keywords = $request->input('seo_keywords');
        $dichvu->seo_description = $request->input('seo_description');
        $dichvu->display = $request->boolean('display');
        $dichvu->moi = $request->boolean('moi');



        // Lưu sản phẩm vào database
        $dichvu->save();

        return response()->json(['message' => 'Sản phẩm đã được thêm thành công']);
    }
    public function deleteAll(Request $request)
    { // Lấy danh sách các ID từ yêu cầu
        $ids = $request->input('ids');

        // Kiểm tra nếu có ID nào được chọn
        if (is_array($ids) && count($ids) > 0) {
            // Xóa các mục theo ID
            DichVu::whereIn('id', $ids)->delete();

            return response()->json(['success' => 'Đã xóa thành công các mục đã chọn!']);
        }

        return response()->json(['error' => 'Không có mục nào được chọn.'], 400);
    }


    public function destroy($id)
    {
        // Tìm sản phẩm bằng ID
        $dichvu = DichVu::where('id', $id)->first();
        // Xóa sản phẩm
        $dichvu->delete();

        // Redirect lại trang danh sách sản phẩm với thông báo thành công
        return redirect()->route('dichvu.index')->with('success', 'dichvu deleted successfully.');
    }
    public function show($id)
    {
        $dichvu = DichVu::where('id', $id)->first();

        if (!$dichvu) {
            return redirect()->back()->with('error', 'dichvu not found.');
        }

        return view('home-page.dichvu-detail', ['dichvu' => $dichvu, 'dichvu' => DichVu::take(4)->get()]);
    }
    public function show_update($id)
    {
        $dichvu = DichVu::where('id', $id)->first();

        // Lấy menu con đã chọn
        $selectedMenu = MenuDichVu::find($dichvu->menu_id);
        $menuLevel1 = null;
        $menuLevel2 = null;
        $menuLevel3 = null;

        if ($selectedMenu) {
            $parent = $selectedMenu->parent_id ? MenuDichVu::find($selectedMenu->parent_id) : null;
            $grandparent = $parent && $parent->parent_id ? MenuDichVu::find($parent->parent_id) : null;

            $menuLevel3 = $grandparent ? $selectedMenu : null; // It's level 3 only if grandparent exists
            $menuLevel2 = $parent ? ($grandparent ? $parent : $selectedMenu) : null; // It's level 2 if parent exists (either the parent itself or the selected one if no grandparent)
            $menuLevel1 = $grandparent ? $grandparent : ($parent ? $parent : $selectedMenu); // It's level 1 (grandparent, parent, or the selected one if no parents)
        }

        // Lấy menu cha và các menu con liên quan
        $menu = MenuDichVu::with('submenu') // Lấy menu cha
            ->whereNull('parent_id') // Lấy luôn menu con
            ->orderBy('position') // Sắp xếp theo vị trí
            ->get();


        return view('admin.show-update-dichvu', ['dichvu' => $dichvu, 'menu' => $menu, 'selectedMenu' => $selectedMenu, 'menuLevel1' => $menuLevel1, 'menuLevel2' => $menuLevel2, 'menuLevel3'=> $menuLevel3]);
    }
    public function update(Request $request, $id)
    { // Kiểm tra dữ liệu đầu vào
        $validatedData = $request->validate([
            'slug' => 'nullable|string|max:255',
            'tieude' => 'nullable|string|max:255',
            'noidung' => 'nullable|string',
            'menu_id' => 'required|integer|exists:menu_dichvu,id',
            'menu_id2' => 'nullable|integer|exists:menu_dichvu,id',
            'keyword_focus' => 'nullable|string|max:255',
            'seo_title' => 'nullable|string|max:255',
            'seo_keywords' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string',
            'display' => 'boolean',
            'is_new' => 'boolean',
            'image' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        // Tạo sản phẩm mới
        $dichvu = DichVu::findOrFail($id);


        // Lưu các dữ liệu cơ bản
        if ($request->hasFile('image')) {
            // Store the new image
            $image = $request->file('image');
            $avatarName = $image->getClientOriginalName();
            $image->move(public_path('images'), $avatarName);

            $dichvu->image = $avatarName;
        }

        $dichvu->slug = $request->input('slug');
        $dichvu->tieude = $request->input('tieude');
        $dichvu->noidung = $request->input('noidung');
        $dichvu->menu_id = $request->input('menu_id3') ?: $request->input('menu_id2') ?: $request->input('menu_id');

        $dichvu->keyword_focus = $request->input('keyword_focus');
        $dichvu->seo_title = $request->input('seo_title');
        $dichvu->seo_keywords = $request->input('seo_keywords');
        $dichvu->seo_description = $request->input('seo_description');
        $dichvu->display = $request->boolean('display');
        $dichvu->moi = $request->boolean('moi');



        // Lưu sản phẩm vào database
        $dichvu->save();

        return redirect()->route('dichvu.index')->with('success', 'dichvu updated successfully.');
    }
    public function update_status(Request $request, $id)
    {
        $request->validate([
            'display' => 'nullable|boolean',
            'is_new' => 'nullable|boolean',
        ]);

        $dichvu = DichVu::findOrFail($id);

        // Cập nhật các trạng thái
        $dichvu->display = $request->input('display');
        $dichvu->new = $request->input('is_new');

        $dichvu->save();

        return response()->json(['success' => 'dichvu status updated successfully!']);
    }
    public function updateOrder(Request $request)
    {
        $id = $request->input('id');
        $newOrder = (int) $request->input('order');

        $currentBlog = DichVu::find($id);
        if (!$currentBlog) {
            return response()->json(['success' => false, 'message' => 'Bài viết không tồn tại']);
        }

        $oldOrder = $currentBlog->order;

        // Nếu không thay đổi thì khỏi làm gì
        if ($newOrder == $oldOrder) {
            return response()->json(['success' => true, 'message' => 'Không có gì thay đổi']);
        }

        // Tìm bài viết đang giữ vị trí $newOrder
        $otherBlog = DichVu::where('order', $newOrder)->first();

        // Cập nhật order cho current blog
        $currentBlog->order = $newOrder;
        $currentBlog->save();

        // Nếu có bài trùng thì đổi vị trí
        if ($otherBlog && $otherBlog->id != $id) {
            $otherBlog->order = $oldOrder;
            $otherBlog->save();
        }

        return response()->json(['success' => true]);
    }
    //     public function search(Request $request)
    //     {
    //         $query = $request->input('kw');
    //         $menu = Menu::all();
    //         $dichvu = dichvu::where('title', 'LIKE', "%{$query}%")->get();
    //         if (!$dichvu) {
    //             return redirect()->back()->with('error', 'dichvu not found.');
    //         }

    //         return view('home-page.dichvu', [
    //             'categories' => $categories,
    //             'dichvus' => $dichvu
    //         ]);
    //     }
}
