<?php

namespace App\Http\Controllers;

use App\Models\Audio;
use App\Models\Logo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use App\Models\Products;

class LogoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.logo');
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
        if ($request->hasFile('logo')) {
            // Kiểm tra và xóa logo cũ nếu tồn tại
            $logoPath = public_path('uploads/images/logo.png');
            if (File::exists($logoPath)) {
                File::delete($logoPath);
            }
            $image = $request->file('logo');

            // Đặt tên file luôn là logo.png
            $avatarName = 'logo.png';
            $destinationPath = public_path('uploads/images/' . $avatarName);

            // Resize ảnh và lưu dưới dạng PNG
            $resizedImage = Image::make($image)
                ->encode('png', 90) // Chuyển thành PNG với chất lượng 90
                ->save($destinationPath);

            // Lưu tên file vào database
            $imageUpload = new Logo();
            $imageUpload->filename = $avatarName;
            $imageUpload->save();
            // Lấy danh sách tất cả hình ảnh sản phẩm
            $products = Audio::all(); // Thay `Products` bằng model tương ứng

            foreach ($products as $product) {
                // Lấy đường dẫn hình ảnh chính
                $imagePath = public_path('uploads/images/' . $product->image);

                if (File::exists($imagePath)) {
                    // Mở ảnh gốc
                    $img = Image::make($imagePath);
                    $logo = Image::make($resizedImage)
                        ->resize(100, 100, function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        });

                    // Resize ảnh (nếu cần) và đóng dấu logo mới
                    $img->resize(600, 600, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })
                        ->insert($logo, 'top-right', 10, 10) // Thay logo
                        ->save($imagePath); // Lưu lại ảnh
                }
            }

            return response()->json(['success' => $avatarName]);
        }

        return response()->json(['error' => 'Không có file nào được tải lên'], 400);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Logo  $logo
     * @return \Illuminate\Http\Response
     */
    public function show(Logo $logo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Logo  $logo
     * @return \Illuminate\Http\Response
     */
    public function edit(Logo $logo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Logo  $logo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Logo $logo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Logo  $logo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Logo $logo)
    {
        //
    }
}
