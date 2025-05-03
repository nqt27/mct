<?php

namespace App\Http\Controllers;

use App\Models\Audio;
use App\Models\Menu;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\TheLoai;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use App\Models\Chapter;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AudioController extends Controller
{
    public function index()
    {
        $menu = TheLoai::all();
        $selectmenu = TheLoai::with('submenu') // Lấy menu cha
            ->whereNull('parent_id') // Lấy luôn menu con
            ->orderBy('position') // Sắp xếp theo vị trí
            ->get();
        $audio = Audio::orderBy('order')->get();
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

    // Create base audio directory helper function
    private function createAudioDirectory($path)
    {
        $fullPath = public_path('uploads/audio/' . $path);
        if (!File::exists($fullPath)) {
            File::makeDirectory($fullPath, 0755, true);
        }
        return $fullPath;
    }

    public function store(Request $request)
    {
        // Validate with audio file
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
            'image' => 'nullable|file',
            'images.*' => 'nullable|file',
            'audio_file' => 'nullable|file', // 50MB max
            'is_series' => 'boolean',
        ]);

        $audio = new Audio();

        // Handle single audio file
        if (!$request->boolean('is_series') && $request->hasFile('audio_file')) {
            $file = $request->file('audio_file');
            $audioName = time() . '_' . Str::slug($request->input('ten')) . '.' . $file->getClientOriginalExtension();

            // Create directory and move file
            $audioPath = $this->createAudioDirectory('singles');
            $file->move($audioPath, $audioName);
            $audio->audio_path = 'singles/' . $audioName;
        }

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
        $audio->theloai_id = $request->input('menu_id3') ?: $request->input('menu_id2') ?: $request->input('menu_id');
        $audio->is_series = $request->boolean('is_series');
        $audio->keyword_focus = $request->input('keyword_focus');
        $audio->seo_title = $request->input('seo_title');
        $audio->seo_keywords = $request->input('seo_keywords');
        $audio->seo_description = $request->input('seo_description');
        $audio->display = $request->boolean('display');
        $audio->nghenhieu = $request->boolean('nghenhieu');
        $audio->moi = $request->boolean('moi');

        $audio->save();

        // Handle chapters if this is a series
        if ($request->boolean('is_series') && $request->has('chapter_titles')) {
            $this->createAudioDirectory('chapters');

            foreach ($request->chapter_titles as $key => $title) {
                if ($request->hasFile("chapter_files.{$key}")) {
                    $file = $request->file("chapter_files.{$key}");
                    $audioName = time() . '_chapter_' . ($key + 1) . '_' .
                        Str::slug($title) . '.' . $file->getClientOriginalExtension();

                    // Move chapter file
                    $file->move(public_path('uploads/audio/chapters'), $audioName);

                    // Create chapter
                    $audio->chapters()->create([
                        'chapter_number' => $key + 1,
                        'title' => $title,
                        'audio_path' => 'chapters/' . $audioName,
                        'status' => true
                    ]);
                }
            }

            // Update total chapters
            $audio->update(['total_chapters' => $audio->chapters()->count()]);
        }

        return response()->json(['message' => 'Audio đã được thêm thành công']);
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
        $audio = Audio::findOrFail($id);

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
        // Get audio with relationships
        $audio = Audio::with(['chapters'])->findOrFail($id);

        // Determine the selected category and its hierarchy
        $selectedMenu = TheLoai::find($audio->theloai_id);
        $menuLevel1 = null;
        $menuLevel2 = null;
        $menuLevel3 = null;

        if ($selectedMenu) {
            $parent = $selectedMenu->parent_id ? TheLoai::find($selectedMenu->parent_id) : null;
            $grandparent = $parent && $parent->parent_id ? TheLoai::find($parent->parent_id) : null;

            $menuLevel3 = $grandparent ? $selectedMenu : null; // It's level 3 only if grandparent exists
            $menuLevel2 = $parent ? ($grandparent ? $parent : $selectedMenu) : null; // It's level 2 if parent exists (either the parent itself or the selected one if no grandparent)
            $menuLevel1 = $grandparent ? $grandparent : ($parent ? $parent : $selectedMenu); // It's level 1 (grandparent, parent, or the selected one if no parents)
        }
        // Lấy menu con đã chọn

        // Lấy menu cha và các menu con liên quan
        $menu = TheLoai::whereNull('parent_id')
            ->with('submenu')
            ->get();
        // Get parent categories only


        // Get current category and its parent

        return view('admin.show-update', [
            'audio' => $audio,
            'menu' => $menu,
            'selectedMenu' => $selectedMenu,
            'menuLevel1' => $menuLevel1,
            'menuLevel2' => $menuLevel2,
            'menuLevel3' => $menuLevel3
        ]);
    }
    public function update(Request $request, $id)
    {
        // Find existing audio
        $audio = Audio::findOrFail($id);

        // Validate request
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
            'image' => 'nullable|file',
            'images.*' => 'nullable|file',
            'audio_file' => 'nullable|file', // 50MB max
            'is_series' => 'boolean',
        ]);

        // Delete old single audio file if exists and switching type or updating file
        if (
            $audio->audio_path &&
            (!$request->boolean('is_series') || $request->hasFile('audio_file'))
        ) {
            File::delete(public_path('uploads/audio/' . $audio->audio_path));
            $audio->audio_path = null;
        }

        // Handle single audio file
        if (!$request->boolean('is_series') && $request->hasFile('audio_file')) {
            $file = $request->file('audio_file');
            $audioName = time() . '_' . Str::slug($request->input('ten')) . '.' .
                $file->getClientOriginalExtension();

            // Create directory and move file
            $audioPath = $this->createAudioDirectory('singles');
            $file->move($audioPath, $audioName);
            $audio->audio_path = 'singles/' . $audioName;
        }
        $logoPath = public_path('uploads/images/logo.png');
        $logo = Image::make($logoPath)
            ->resize(100, 100, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

        // Delete old main image if updating
        if ($request->hasFile('image') && $audio->image) {
            File::delete(public_path('uploads/images/' . $audio->image));
            $audio->image = null;
        }

        // Handle new main image
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

        // Delete old additional images if updating
        if ($request->hasFile('images') && $audio->filenames) {
            $oldImages = json_decode($audio->filenames, true);
            foreach ($oldImages as $oldImage) {
                File::delete(public_path('uploads/images/' . $oldImage));
            }
            $audio->filenames = null;
        }

        // Handle new additional images
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

        // Update basic info
        $audio->slug = $request->input('slug');
        $audio->ten = $request->input('ten');
        $audio->tacgia = $request->input('tacgia');
        $audio->tomtat = $request->input('tomtat');
        $audio->theloai_id = $request->input('menu_id3') ?: $request->input('menu_id2') ?: $request->input('menu_id');
        $audio->is_series = $request->boolean('is_series');
        $audio->keyword_focus = $request->input('keyword_focus');
        $audio->seo_title = $request->input('seo_title');
        $audio->seo_keywords = $request->input('seo_keywords');
        $audio->seo_description = $request->input('seo_description');
        $audio->display = $request->boolean('display');
        $audio->nghenhieu = $request->boolean('nghenhieu');
        $audio->moi = $request->boolean('moi');

        $audio->save();

        // Handle chapters
        if ($request->boolean('is_series')) {
            // Delete old chapters that are not in the update
            $keepChapterIds = array_filter($request->input('chapter_ids', []));
            foreach ($audio->chapters as $chapter) {
                if (!in_array($chapter->id, $keepChapterIds)) {
                    File::delete(public_path('uploads/audio/' . $chapter->audio_path));
                    $chapter->delete();
                }
            }

            // Update/Create chapters
            if ($request->has('chapter_titles')) {
                foreach ($request->chapter_titles as $key => $title) {
                    $chapterId = $request->input("chapter_ids.$key");

                    if ($chapterId) {
                        // Update existing chapter
                        $chapter = Chapter::find($chapterId);
                        if ($chapter) {
                            $chapter->title = $title;

                            if ($request->hasFile("chapter_files.$key")) {
                                // Delete old file
                                File::delete(public_path('uploads/audio/' . $chapter->audio_path));

                                // Upload new file
                                $file = $request->file("chapter_files.$key");
                                $audioName = time() . '_chapter_' . ($key + 1) . '_' .
                                    Str::slug($title) . '.' . $file->getClientOriginalExtension();

                                $file->move(public_path('uploads/audio/chapters'), $audioName);
                                $chapter->audio_path = 'chapters/' . $audioName;
                            }

                            $chapter->save();
                        }
                    } else if ($request->hasFile("chapter_files.$key")) {
                        // Create new chapter
                        $file = $request->file("chapter_files.$key");
                        $audioName = time() . '_chapter_' . ($key + 1) . '_' .
                            Str::slug($title) . '.' . $file->getClientOriginalExtension();

                        $file->move(public_path('uploads/audio/chapters'), $audioName);

                        $audio->chapters()->create([
                            'chapter_number' => $key + 1,
                            'title' => $title,
                            'audio_path' => 'chapters/' . $audioName,
                            'status' => true
                        ]);
                    }
                }
            }

            // Update total chapters
            $audio->update(['total_chapters' => $audio->chapters()->count()]);
        } else {
            // Delete all chapters if switching from series to single
            foreach ($audio->chapters as $chapter) {
                File::delete(public_path('uploads/audio/' . $chapter->audio_path));
                $chapter->delete();
            }
            $audio->update(['total_chapters' => 0]);
        }

        return response()->json(['message' => 'Audio đã được cập nhật thành công']);
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
    public function getSubcategories($parentId)
    {
        $subcategories = TheLoai::where('parent_id', $parentId)->get();
        return response()->json(['subcategories' => $subcategories]);
    }

    public function storeChapter(Request $request, $audioId)
    {
        try {
            $audio = Audio::findOrFail($audioId);

            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'audio_file' => 'required|file|mimes:mp3,wav|max:51200'
            ]);

            $chapterNumber = $audio->chapters()->count() + 1;
            $file = $request->file('audio_file');
            $audioName = time() . '_chapter_' . $chapterNumber . '_' . Str::slug($request->title) . '.' . $file->getClientOriginalExtension();

            $file->storeAs('public/audios/chapters', $audioName);

            $chapter = $audio->chapters()->create([
                'chapter_number' => $chapterNumber,
                'title' => $request->title,
                'audio_path' => $audioName,
                'status' => true
            ]);

            $audio->update(['total_chapters' => $chapterNumber]);

            return response()->json([
                'success' => true,
                'message' => 'Chapter added successfully',
                'chapter' => $chapter
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateChapter(Request $request, $chapterId)
    {
        try {
            $chapter = Chapter::findOrFail($chapterId);

            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'audio_file' => 'nullable|file|mimes:mp3,wav|max:51200'
            ]);

            if ($request->hasFile('audio_file')) {
                // Delete old file
                Storage::delete('public/audios/chapters/' . $chapter->audio_path);

                $file = $request->file('audio_file');
                $audioName = time() . '_chapter_' . $chapter->chapter_number . '_' .
                    Str::slug($request->title) . '.' . $file->getClientOriginalExtension();

                $file->storeAs('public/audios/chapters', $audioName);
                $chapter->audio_path = $audioName;
            }

            $chapter->title = $request->title;
            $chapter->save();

            return response()->json([
                'success' => true,
                'message' => 'Chapter updated successfully',
                'chapter' => $chapter
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function deleteChapter($chapterId)
    {
        try {
            $chapter = Chapter::findOrFail($chapterId);
            $audio = $chapter->audio;

            // Delete audio file
            Storage::delete('public/audios/chapters/' . $chapter->audio_path);

            // Delete chapter
            $chapter->delete();

            // Reorder remaining chapters
            $audio->chapters()
                ->where('chapter_number', '>', $chapter->chapter_number)
                ->decrement('chapter_number');

            // Update total chapters
            $audio->update(['total_chapters' => $audio->chapters()->count()]);

            return response()->json([
                'success' => true,
                'message' => 'Chapter deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function reorderChapters(Request $request, $audioId)
    {
        try {
            $audio = Audio::findOrFail($audioId);

            $validatedData = $request->validate([
                'chapters' => 'required|array',
                'chapters.*' => 'required|integer|exists:chapters,id'
            ]);

            foreach ($request->chapters as $index => $chapterId) {
                Chapter::where('id', $chapterId)
                    ->update(['chapter_number' => $index + 1]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Chapters reordered successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
    public function updateOrder(Request $request)
    {
        $id = $request->input('id');
        $newOrder = (int) $request->input('order');

        $currentBlog = Audio::find($id);
        if (!$currentBlog) {
            return response()->json(['success' => false, 'message' => 'Bài viết không tồn tại']);
        }

        $oldOrder = $currentBlog->order;

        // Nếu không thay đổi thì khỏi làm gì
        if ($newOrder == $oldOrder) {
            return response()->json(['success' => true, 'message' => 'Không có gì thay đổi']);
        }

        // Tìm bài viết đang giữ vị trí $newOrder
        $otherBlog = Audio::where('order', $newOrder)->first();

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
}
