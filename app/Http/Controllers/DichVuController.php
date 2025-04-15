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
        $dichvu = DichVu::all();
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
        $dichvu->menu_id = $request->input('menu_id2') ? $request->input('menu_id2') : $request->input('menu_id');
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

        // Lấy menu cha và các menu con liên quan
        $menu = MenuDichVu::with('submenu') // Lấy menu cha
            ->whereNull('parent_id') // Lấy luôn menu con
            ->orderBy('position') // Sắp xếp theo vị trí
            ->get();


        return view('admin.show-update-dichvu', ['dichvu' => $dichvu, 'menu' => $menu, 'selectedMenu' => $selectedMenu]);
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
        $dichvu->menu_id = $request->input('menu_id2') ? $request->input('menu_id2') : $request->input('menu_id');
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
