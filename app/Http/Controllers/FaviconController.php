<?php

namespace App\Http\Controllers;

use App\Models\Favicon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use App\Models\Products;

class FaviconController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.favicon');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        // Kiểm tra xem có file được tải lên không
        if ($request->hasFile('favicon')) {
            // Kiểm tra và xóa favicon cũ nếu tồn tại
            $faviconPath = public_path('uploads/images/favicon.png');
            if (File::exists($faviconPath)) {
                File::delete($faviconPath);
            }
            $image = $request->file('favicon');

            // Đặt tên file luôn là favicon.png
            $avatarName = 'favicon.png';
            $destinationPath = public_path('uploads/images/' . $avatarName);

            $resizedImage = Image::make($image)
                ->resize(100, 100) // Resize trước nếu cần
                ->encode('png', 90);

            // Tạo mặt nạ hình tròn
            $mask = Image::canvas($resizedImage->width(), $resizedImage->height());

            $mask->circle(
                $resizedImage->width(), // đường kính
                $resizedImage->width() / 2, // tâm X
                $resizedImage->height() / 2, // tâm Y
                function ($draw) {
                    $draw->background('#fff'); // mặt nạ màu trắng
                }
            );

            // Áp mặt nạ vào ảnh để bo tròn
            $resizedImage->mask($mask, false);

            // Lưu ảnh đã bo tròn
            $resizedImage->save($destinationPath);

            // Lưu tên file vào database
            $imageUpload = new Favicon();
            $imageUpload->filename = $avatarName;
            $imageUpload->save();
            // // Lấy danh sách tất cả hình ảnh sản phẩm
            // $products = Products::all(); // Thay `Products` bằng model tương ứng

            // foreach ($products as $product) {
            //     // Lấy đường dẫn hình ảnh chính
            //     $imagePath = public_path('uploads/images/' . $product->image);

            //     if (File::exists($imagePath)) {
            //         // Mở ảnh gốc
            //         $img = Image::make($imagePath);
            //         $favicon = Image::make($resizedImage)
            //             ->resize(100, 100, function ($constraint) {
            //                 $constraint->aspectRatio();
            //                 $constraint->upsize();
            //             });

            //         // Resize ảnh (nếu cần) và đóng dấu favicon mới
            //         $img->resize(600, 600, function ($constraint) {
            //             $constraint->aspectRatio();
            //             $constraint->upsize();
            //         })
            //             ->insert($favicon, 'top-right', 10, 10) // Thay favicon
            //             ->save($imagePath); // Lưu lại ảnh
            //     }
            // }

            return response()->json(['success' => $avatarName]);
        }

        return response()->json(['error' => 'Không có file nào được tải lên'], 400);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Favicon  $favicon
     * @return \Illuminate\Http\Response
     */
    public function show(favicon $favicon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Favicon  $favicon
     * @return \Illuminate\Http\Response
     */
    public function edit(favicon $favicon)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Favicon  $favicon
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, favicon $favicon)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Favicon  $favicon
     * @return \Illuminate\Http\Response
     */
    public function destroy(favicon $favicon)
    {
        //
    }
}
