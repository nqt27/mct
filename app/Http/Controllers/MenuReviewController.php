<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\MenuReview;
use Illuminate\Http\Request;

class MenuReviewController extends Controller
{
    // Hiển thị danh sách menu
    public function index()
    {
        // Lấy tất cả menu cùng với menu con (nếu có)
        // $menu = Menu::with('submenu')->whereNull('parent_id')->orderBy('position')->get();
        $menu = MenuReview::whereNull('parent_id') // Chỉ lấy menu cha
            ->orderBy('position') // Sắp xếp theo vị trí
            ->get();
        return view('admin.menu-review',  ['menu' => $menu]);
    }
    public function submenu($id)
    {
        $menu = MenuReview::with('submenu')->where('id', $id)->first();
        // Lấy tất cả menu cùng với menu con (nếu có)
        $submenu = MenuReview::with('submenu')
            ->where('parent_id', $id)
            ->orderBy('position')
            ->get();
        return view('admin.submenu-review',  ['menu' => $menu, 'submenu' => $submenu]);
    }
    public function store(Request $request)
    {
        // Validate dữ liệu
        $request->validate([
            'ten' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
        ]);
        // Lấy vị trí lớn nhất hiện có
        $maxPosition = MenuReview::max('position');
        // Tạo sản phẩm mới
        $menu = new MenuReview;
        $menu->name = $request->input('ten');
        $menu->slug = $request->input('slug');

        $menu->position = $maxPosition + 1;
        $menu->save();
        // Redirect về trang chủ hoặc trang danh sách sản phẩm
        try {
            // Chuyển hướng về trang danh sách với thông báo thành công
            return redirect()->route('menu-review.index')->with('success', 'Menu đã được thêm thành công!');
        } catch (\Exception $e) {
            // Xử lý lỗi và chuyển hướng về trang danh sách với thông báo thất bại
            return redirect()->route('menu-review.index')->with('error', 'Có lỗi xảy ra khi thêm menu.');
        }
    }
    public function destroy($id)
    {
        // Tìm sản phẩm bằng ID
        $menu = MenuReview::where('id', $id)->first();
        // Xóa sản phẩm
        $menu->delete();

        // Redirect lại trang danh sách sản phẩm với thông báo thành công
        return redirect()->route('menu-review.index')->with('success', 'Product deleted successfully.');
    }
    public function addSub(Request $request)
    {
        $request->validate([
            'ten' => 'required|string|max:255',
            'slug' => 'required|string|max:255',

        ]);



        $maxPosition = MenuReview::max('position');
        $submenu = new MenuReview();
        $submenu->name = $request->input('ten');
        $submenu->slug = $request->input('slug');
        $submenu->position = $maxPosition + 1;
        $submenu->parent_id = $request->input('parent_id');
        // Cập nhật các trường khác nếu cần

        $submenu->save();

        return redirect()->route('menu-review.index')->with('success', 'Product updated successfully.');
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'ten' => 'required|string|max:255',
            'slug' => 'required|string|max:255',

        ]);


        $menu = MenuReview::findOrFail($id);

        $menu->name = $request->input('ten');
        $menu->slug = $request->input('slug'); // Thêm 1 vào vị trí lớn nhất
        // Cập nhật các trường khác nếu cần

        $menu->save();

        return redirect()->route('menu-review.index')->with('success', 'Product updated successfully.');
    }
    // Cập nhật thứ tự của menu
    public function updateOrder(Request $request)
    {
        // Kiểm tra xem có dữ liệu 'order' được gửi trong request không
        $orderData = $request->input('order');
        if (!$orderData) {
            return response()->json(['error' => 'Không có dữ liệu thứ tự'], 400);
        }
        // $menuItem = Menu::find($item['id']);
        // Hàm đệ quy để cập nhật vị trí và cấp độ lồng nhau
        $this->updateOrderRecursive($orderData);

        return response()->json(['success' => 'Thứ tự đã được cập nhật thành công']);
    }

    private function updateOrderRecursive($items)
    {
        foreach ($items as $index => $item) {
            // Tìm mục trong cơ sở dữ liệu và cập nhật vị trí, parent_id
            $menuItem = MenuReview::find($item); // Chỉ lấy menu cha
            if ($menuItem) {
                $menuItem->position = $index;
                $menuItem->save();
            }
        }
    }
}
