<?php

namespace App\Http\Controllers;

use App\Models\Audio;
use App\Models\Menu;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\TheLoai;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

class AudioController extends Controller
{
    public function index()
    {
        $menu = TheLoai::all();
        $selectmenu = TheLoai::with('submenu') // Lấy menu cha
            ->whereNull('parent_id') // Lấy luôn menu con
            ->orderBy('position') // Sắp xếp theo vị trí
            ->get();
        $audio = Audio::all();
        return view('admin.audio',  ['audio' => $audio, 'menu' => $menu, 'selectmenu' => $selectmenu]);
    }
    public function add()
    {
        $menu = TheLoai::with('submenu') // Lấy menu cha
            ->whereNull('parent_id') // Lấy luôn menu con
            ->orderBy('position') // Sắp xếp theo vị trí
            ->get();

        return view('admin.add-audio', ['menu' => $menu]);
    }
    public function store(Request $request)
    {
        // Kiểm tra dữ liệu đầu vào
        $validatedData = $request->validate([
            'slug' => 'nullable|string|max:255',
            'ten' => 'nullable|string|max:255',
            'tacgia' => 'nullable|string|max:255',
            'tomtat' => 'nullable|string',
            'menu_id' => 'required|integer|exists:theloai,id',
            'menu_id2' => 'nullable|integer|exists:theloai,id',
            'keyword_focus' => 'nullable|string|max:255',
            'seo_title' => 'nullable|string|max:255',
            'seo_keywords' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string',
            'display' => 'boolean',
            'moi' => 'boolean',
            'nghenhieu' => 'boolean',
            'image' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:2048',
            'images.*' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Tạo sản phẩm mới
        $audio = new Audio();

        // Đường dẫn logo watermark
        $logoPath = public_path('uploads/images/logo.png');
        $logo = Image::make($logoPath)
            ->resize(100, 100, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

        // Xử lý ảnh chính nếu có
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = 'main_' . time() . '.' . $image->getClientOriginalExtension();
            $imagePath = public_path('uploads/images/' . $imageName);

            // Resize và đóng dấu logo
            $img = Image::make($image)
                ->resize(600, 600, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->insert($logo, 'top-right', 20, 20)
                ->save($imagePath);

            $audio->image = $imageName;
        }

        // Xử lý nhiều ảnh (images[]) nếu có
        $imagesArray = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $imageName = 'sub_' . time() . '_' . $file->getClientOriginalName();
                $imagePath = public_path('uploads/images/' . $imageName);

                // Resize và đóng dấu logo
                $img = Image::make($file)
                    ->resize(600, 600, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })
                    ->insert($logo, 'top-right', 10, 10)
                    ->save($imagePath);

                $imagesArray[] = $imageName;
            }

            $audio->filenames = $imagesArray; // Lưu dưới dạng JSON
        }

        // Lưu các dữ liệu khác
        $audio->slug = $request->input('slug');
        $audio->ten = $request->input('ten');
        $audio->tacgia = $request->input('tacgia');
        $audio->tomtat = $request->input('tomtat');
        $audio->theloai_id = $request->input('menu_id2') ? $request->input('menu_id2') : $request->input('menu_id');
        $audio->keyword_focus = $request->input('keyword_focus');
        $audio->seo_title = $request->input('seo_title');
        $audio->seo_keywords = $request->input('seo_keywords');
        $audio->seo_description = $request->input('seo_description');
        $audio->display = $request->boolean('display');
        $audio->nghenhieu = $request->boolean('nghenhieu');
        $audio->moi = $request->boolean('moi');

        // Lưu sản phẩm vào database
        $audio->save();

        return response()->json(['message' => 'Sản phẩm đã được thêm thành công']);
    }
    public function deleteAll(Request $request)
    {
        // Lấy danh sách các ID từ yêu cầu
        $ids = $request->input('ids');

        // Kiểm tra nếu có ID nào được chọn
        if (is_array($ids) && count($ids) > 0) {
            // Lấy danh sách sản phẩm theo ID
            $audio = Audio::whereIn('id', $ids)->get();

            foreach ($audio as $audio) {
                // Xóa ảnh chính nếu có
                if ($audio->image) {
                    $imagePath = public_path('uploads/images/' . $audio->image);
                    if (File::exists($imagePath)) {
                        File::delete($imagePath);
                    }
                }

                // Xóa ảnh phụ nếu có
                if ($audio->images) {
                    $images = json_decode($audio->images, true);
                    if (is_array($images)) {
                        foreach ($images as $image) {
                            $imagePath = public_path('uploads/images/' . $image);
                            if (File::exists($imagePath)) {
                                File::delete($imagePath);
                            }
                        }
                    }
                }
            }

            // Xóa sản phẩm khỏi cơ sở dữ liệu
            Audio::whereIn('id', $ids)->delete();

            return response()->json(['success' => 'Đã xóa thành công các mục đã chọn!']);
        }

        return response()->json(['error' => 'Không có mục nào được chọn.'], 400);
    }


    public function destroy($id)
    {
        // Tìm sản phẩm bằng ID
        $audio = Audio::where('id', $id)->first();
        if (!$audio) {
            return response()->json(['message' => 'Sản phẩm không tồn tại'], 404);
        }

        // Xóa ảnh chính nếu có
        if ($audio->image) {
            $imagePath = public_path('uploads/images/' . $audio->image);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }

        // Xóa các ảnh khác nếu có
        if ($audio->images) {
            $images = json_decode($audio->images, true); // Parse chuỗi JSON
            if (is_array($images)) {
                foreach ($images as $image) {
                    $imagePath = public_path('uploads/images/' . $image);
                    if (File::exists($imagePath)) {
                        File::delete($imagePath);
                    }
                }
            }
        }

        // Xóa sản phẩm
        $audio->delete();

        // Redirect lại trang danh sách sản phẩm với thông báo thành công
        return redirect()->route('audio.index')->with('success', 'audio deleted successfully.');
    }
    public function show($id)
    {
        $audio = Audio::where('id', $id)->first();

        if (!$audio) {
            return redirect()->back()->with('error', 'audio not found.');
        }

        return view('home-page.audio-detail', ['mois' => $audio, 'audio' => Audio::take(4)->get()]);
    }
    public function show_update($id)
    {
        $audio = Audio::where('id', $id)->first();

        // Lấy menu con đã chọn
        $selectedMenu = TheLoai::find($audio->menu_id);

        // Lấy menu cha và các menu con liên quan
        $menu = TheLoai::whereNull('parent_id')
            ->with('submenu')
            ->get();


        return view('admin.show-update', ['audio' => $audio, 'menu' => $menu, 'selectedMenu' => $selectedMenu]);
    }
    public function update(Request $request, $id)
    { // Kiểm tra dữ liệu đầu vào
        $validatedData = $request->validate([
            'slug' => 'nullable|string|max:255',
            'ten' => 'nullable|string|max:255',
            'tacgia' => 'nullable|string|max:255',
            'tomtat' => 'nullable|string',
            'menu_id' => 'required|integer|exists:theloai,id',
            'menu_id2' => 'nullable|integer|exists:theloai,id',
            'keyword_focus' => 'nullable|string|max:255',
            'seo_title' => 'nullable|string|max:255',
            'seo_keywords' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string',
            'display' => 'boolean',
            'moi' => 'boolean',
            'nghenhieu' => 'boolean',
            'image' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:2048',
            'images.*' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        // Tạo sản phẩm mới
        $audio = Audio::findOrFail($id);
        // Đường dẫn logo watermark
        $logoPath = public_path('uploads/images/logo.png');
        $logo = Image::make($logoPath)
            ->resize(100, 100, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
        // Xóa dữ liệu cũ trong cột `images`
        // Xử lý nhiều ảnh (images[]) nếu có
        $imagesArray = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $imageName = 'sub_' . time() . '_' . $file->getClientOriginalName();
                $imagePath = public_path('uploads/images/' . $imageName);
                // Resize và đóng dấu logo
                $img = Image::make($file)
                    ->resize(600, 600, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })
                    ->insert($logo, 'top-right', 10, 10)
                    ->save($imagePath);
                $imagesArray[] = $imageName;
            }

            $audio->images = $imagesArray;
        }

        // Lưu các dữ liệu cơ bản
        if ($request->hasFile('image')) {
            // Store the moi image
            $image = $request->file('image');
            $imageName = 'main_' . time() . '.' . $image->getClientOriginalExtension();
            $imagePath = public_path('uploads/images/' . $imageName);
            // Resize và đóng dấu logo
            $img = Image::make($file)
                ->resize(600, 600, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->insert($logo, 'top-right', 10, 10)
                ->save($imagePath);

            $audio->image = $imageName;
        }

        $audio->slug = $request->input('slug');
        $audio->ten = $request->input('ten');
        $audio->tacgia = $request->input('tacgia');
        $audio->tomtat = $request->input('tomtat');
        $audio->theloai_id = $request->input('menu_id2') ? $request->input('menu_id2') : $request->input('menu_id');
        $audio->keyword_focus = $request->input('keyword_focus');
        $audio->seo_title = $request->input('seo_title');
        $audio->seo_keywords = $request->input('seo_keywords');
        $audio->seo_description = $request->input('seo_description');
        $audio->display = $request->boolean('display');
        $audio->nghenhieu = $request->boolean('nghenhieu');
        $audio->moi = $request->boolean('moi');



        // Lưu sản phẩm vào database
        $audio->save();

        return redirect()->route('audio.index')->with('success', 'audio updated successfully.');
    }
    public function update_status(Request $request, $id)
    {
        $request->validate([
            'display' => 'nullable|boolean',
            'nghenhieu' => 'nullable|boolean',
            'moi' => 'nullable|boolean',
        ]);

        $audio = Audio::findOrFail($id);

        // Cập nhật các trạng thái
        $audio->display = $request->input('display');
        $audio->nghenhieu = $request->input('nghenhieu');
        $audio->moi = $request->input('moi');

        $audio->save();

        return response()->json(['success' => 'audio status updated successfully!']);
    }
    public function playAudio($id)
    {
        $audio = Audio::findOrFail($id);
        $audio->increment('luot_nghe'); // Tăng lượt nghe lên 1
        return response()->json(['success' => true, 'luot_nghe' => $audio->luot_nghe]);
    }
    //     public function search(Request $request)
    //     {
    //         $query = $request->input('kw');
    //         $menu = Menu::all();
    //         $mois = mois::where('title', 'LIKE', "%{$query}%")->get();
    //         if (!$mois) {
    //             return redirect()->back()->with('error', 'audio not found.');
    //         }

    //         return view('home-page.mois', [
    //             'categories' => $categories,
    //             'audio' => $audio
    //         ]);
    //     }

}
