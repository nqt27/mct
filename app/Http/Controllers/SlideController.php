<?php

namespace App\Http\Controllers;

use App\Models\Slide;
use Illuminate\Http\Request;

class SlideController extends Controller
{
    // Hiển thị danh sách menu
    public function index()
    {
        $slide = Slide::orderBy('position') // Sắp xếp theo vị trí
            ->get();
        return view('admin.slide',  ['slide' => $slide]);
    }
    public function add()
    {
        return view('admin.add-slide');
    }
    public function store(Request $request)
    {
        // Kiểm tra dữ liệu đầu vào
        $validatedData = $request->validate([
            'title' => 'nullable|string|max:255',
            'link' => 'nullable|string|max:255',
            'display' => 'boolean',
            'image' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        // Tạo sản phẩm mới
        $slide = new Slide();


        // Lưu các dữ liệu cơ bản
        if ($request->hasFile('image')) {
            // Store the new image
            $image = $request->file('image');
            $imgName = $image->getClientOriginalName();
            $image->move(public_path('uploads/images'), $imgName);

            $slide->filename = $imgName;
        }

        $slide->title = $request->input('title');
        $slide->link = $request->input('link');
        $slide->display = $request->input('display');



        // Lưu sản phẩm vào database
        $slide->save();

        return response()->json(['message' => 'Sản phẩm đã được thêm thành công']);
    }
    public function update_status(Request $request, $id)
    {
        $request->validate([
            'display' => 'nullable|boolean',
        ]);

        $slide = Slide::findOrFail($id);

        // Cập nhật các trạng thái
        $slide->display = $request->input('display');

        $slide->save();

        return response()->json(['success' => 'Product status updated successfully!']);
    }
    public function destroy($id)
    {
        // Tìm sản phẩm bằng ID
        $slide = Slide::where('id', $id)->first();
        // Xóa sản phẩm
        $slide->delete();

        // Redirect lại trang danh sách sản phẩm với thông báo thành công
        return redirect()->route('product.index')->with('success', 'Product deleted successfully.');
    }
}
