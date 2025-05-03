<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\MenuBlog;
use App\Models\Blog;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminBlogController extends Controller
{
    public function index()
    {
        $menu = MenuBlog::all();
        $selectmenu = MenuBlog::with('submenu') // Lấy menu cha
            ->whereNull('parent_id') // Lấy luôn menu con
            ->orderBy('position') // Sắp xếp theo vị trí
            ->get();
        $blog = Blog::orderBy('order')->get();
        return view('admin.blog',  ['blog' => $blog, 'menu' => $menu, 'selectmenu' => $selectmenu]);
    }
    public function add()
    {
        $menu = MenuBlog::with('submenu') // Lấy menu cha
            ->whereNull('parent_id') // Lấy luôn menu con
            ->orderBy('position') // Sắp xếp theo vị trí
            ->get();

        return view('admin.add-blog', ['menu' => $menu]);
    }
    public function store(Request $request)
    {
        // Kiểm tra dữ liệu đầu vào
        $validatedData = $request->validate([
            'slug' => 'nullable|string|max:255',
            'tieude' => 'nullable|string|max:255',
            'noidung' => 'nullable|string',
            'menu_id' => 'required|integer|exists:menu_blog,id',
            'menu_id2' => 'nullable|integer|exists:menu_blog,id',
            'keyword_focus' => 'nullable|string|max:255',
            'seo_title' => 'nullable|string|max:255',
            'seo_keywords' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string',
            'display' => 'boolean',
            'is_new' => 'boolean',
            'image' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        // Tạo sản phẩm mới
        $blog = new Blog();


        // Lưu các dữ liệu cơ bản
        if ($request->hasFile('image')) {
            // Store the new image
            $image = $request->file('image');
            $avatarName = $image->getClientOriginalName();
            $image->move(public_path('images'), $avatarName);

            $blog->image = $avatarName;
        }

        $blog->slug = $request->input('slug');
        $blog->tieude = $request->input('tieude');
        $blog->noidung = $request->input('noidung');
        $blog->menu_id = $request->input('menu_id3') ?: $request->input('menu_id2') ?: $request->input('menu_id');
        $blog->keyword_focus = $request->input('keyword_focus');
        $blog->seo_title = $request->input('seo_title');
        $blog->seo_keywords = $request->input('seo_keywords');
        $blog->seo_description = $request->input('seo_description');
        $blog->display = $request->boolean('display');
        $blog->moi = $request->boolean('moi');



        // Lưu sản phẩm vào database
        $blog->save();

        return response()->json(['message' => 'Sản phẩm đã được thêm thành công']);
    }
    public function deleteAll(Request $request)
    { // Lấy danh sách các ID từ yêu cầu
        $ids = $request->input('ids');

        // Kiểm tra nếu có ID nào được chọn
        if (is_array($ids) && count($ids) > 0) {
            // Xóa các mục theo ID
            Blog::whereIn('id', $ids)->delete();

            return response()->json(['success' => 'Đã xóa thành công các mục đã chọn!']);
        }

        return response()->json(['error' => 'Không có mục nào được chọn.'], 400);
    }


    public function destroy($id)
    {
        // Tìm sản phẩm bằng ID
        $blog = Blog::where('id', $id)->first();
        // Xóa sản phẩm
        $blog->delete();

        // Redirect lại trang danh sách sản phẩm với thông báo thành công
        return redirect()->route('admin_blog.index')->with('success', 'Blog deleted successfully.');
    }
    public function show($id)
    {
        $blog = Blog::where('id', $id)->first();

        if (!$blog) {
            return redirect()->back()->with('error', 'Blog not found.');
        }

        return view('home-page.blog-detail', ['blog' => $blog, 'blog' => blog::take(4)->get()]);
    }
    public function show_update($id)
    {
        $blog = Blog::where('id', $id)->first();

        // Lấy menu con đã chọn
        $selectedMenu = MenuBlog::find($blog->menu_id);
        $menuLevel1 = null;
        $menuLevel2 = null;
        $menuLevel3 = null;

        if ($selectedMenu) {
            $parent = $selectedMenu->parent_id ? MenuBlog::find($selectedMenu->parent_id) : null;
            $grandparent = $parent && $parent->parent_id ? MenuBlog::find($parent->parent_id) : null;

            $menuLevel3 = $grandparent ? $selectedMenu : null; // It's level 3 only if grandparent exists
            $menuLevel2 = $parent ? ($grandparent ? $parent : $selectedMenu) : null; // It's level 2 if parent exists (either the parent itself or the selected one if no grandparent)
            $menuLevel1 = $grandparent ? $grandparent : ($parent ? $parent : $selectedMenu); // It's level 1 (grandparent, parent, or the selected one if no parents)
        }

        // Lấy menu cha và các menu con liên quan
        $menu = MenuBlog::with('submenu') // Lấy menu cha
            ->whereNull('parent_id') // Lấy luôn menu con
            ->orderBy('position') // Sắp xếp theo vị trí
            ->get();


        return view('admin.show-update-blog', ['blog' => $blog, 'menu' => $menu, 'selectedMenu' => $selectedMenu, 'menuLevel1' => $menuLevel1, 'menuLevel2' => $menuLevel2, 'menuLevel3' => $menuLevel3]);
    }
    public function update(Request $request, $id)
    { // Kiểm tra dữ liệu đầu vào
        $validatedData = $request->validate([
            'slug' => 'nullable|string|max:255',
            'tieude' => 'nullable|string|max:255',
            'noidung' => 'nullable|string',
            'menu_id' => 'required|integer|exists:menu_blog,id',
            'menu_id2' => 'nullable|integer|exists:menu_blog,id',
            'keyword_focus' => 'nullable|string|max:255',
            'seo_title' => 'nullable|string|max:255',
            'seo_keywords' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string',
            'display' => 'boolean',
            'is_new' => 'boolean',
            'image' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        // Tạo sản phẩm mới
        $blog = Blog::findOrFail($id);


        // Lưu các dữ liệu cơ bản
        if ($request->hasFile('image')) {
            // Store the new image
            $image = $request->file('image');
            $avatarName = $image->getClientOriginalName();
            $image->move(public_path('images'), $avatarName);

            $blog->image = $avatarName;
        }

        $blog->slug = $request->input('slug');
        $blog->tieude = $request->input('tieude');
        $blog->noidung = $request->input('noidung');
        $blog->menu_id = $request->input('menu_id3') ?: $request->input('menu_id2') ?: $request->input('menu_id');

        $blog->keyword_focus = $request->input('keyword_focus');
        $blog->seo_title = $request->input('seo_title');
        $blog->seo_keywords = $request->input('seo_keywords');
        $blog->seo_description = $request->input('seo_description');
        $blog->display = $request->boolean('display');
        $blog->moi = $request->boolean('moi');



        // Lưu sản phẩm vào database
        $blog->save();

        return redirect()->route('admin_blog.index')->with('success', 'Blog updated successfully.');
    }
    public function update_status(Request $request, $id)
    {
        $request->validate([
            'display' => 'nullable|boolean',
            'is_new' => 'nullable|boolean',
        ]);

        $blog = Blog::findOrFail($id);

        // Cập nhật các trạng thái
        $blog->display = $request->input('display');
        $blog->new = $request->input('is_new');

        $blog->save();

        return response()->json(['success' => 'Blog status updated successfully!']);
    }
    public function updateOrder(Request $request)
    {
        $id = $request->input('id');
        $newOrder = (int) $request->input('order');

        $currentBlog = Blog::find($id);
        if (!$currentBlog) {
            return response()->json(['success' => false, 'message' => 'Bài viết không tồn tại']);
        }

        $oldOrder = $currentBlog->order;

        // Nếu không thay đổi thì khỏi làm gì
        if ($newOrder == $oldOrder) {
            return response()->json(['success' => true, 'message' => 'Không có gì thay đổi']);
        }

        // Tìm bài viết đang giữ vị trí $newOrder
        $otherBlog = Blog::where('order', $newOrder)->first();

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
    //         $Blog = Blog::where('title', 'LIKE', "%{$query}%")->get();
    //         if (!$Blog) {
    //             return redirect()->back()->with('error', 'Blog not found.');
    //         }

    //         return view('home-page.Blog', [
    //             'categories' => $categories,
    //             'Blogs' => $Blog
    //         ]);
    //     }
}
