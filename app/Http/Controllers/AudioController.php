<?php

namespace App\Http\Controllers;

use App\Models\Audio;
use App\Models\Chapter;
use App\Models\TheLoai;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
        $menu = TheLoai::with('submenu')
            ->whereNull('parent_id')
            ->orderBy('position')
            ->get();
        return view('admin.add-audio', compact('menu'));
    }

    public function store(Request $request)
    {
        try {
            // Validate the request
            $validated = $request->validate([
                'ten' => 'required|string|max:255',
                'slug' => 'required|string|unique:audio,slug',
                'tacgia' => 'required|string',
                'tomtat' => 'nullable|string',
                'menu_id' => 'required|exists:theloai,id',
                'menu_id2' => 'nullable|exists:theloai,id',
                'image' => 'required|image',
                'audio_file' => $request->boolean('is_series') ? 'nullable' : 'required',
                'chapter_files.*' => $request->boolean('is_series') ? 'required' : 'nullable',
                'chapter_titles.*' => $request->boolean('is_series') ? 'required|string' : 'nullable',
                'is_series' => 'required|in:0,1,true,false', // Accept more formats
                'keyword_focus' => 'nullable|string',
                'seo_title' => 'nullable|string',
                'seo_keywords' => 'nullable|string',
                'seo_description' => 'nullable|string',
                'display' => 'boolean',
                'moi' => 'boolean',
                'nghenhieu' => 'boolean'
            ], [
                'ten.required' => 'Tên audio là bắt buộc',
                'slug.required' => 'Slug là bắt buộc',
                'slug.unique' => 'Slug đã tồn tại',
                'tacgia.required' => 'Tác giả là bắt buộc',
                'menu_id.required' => 'Danh mục là bắt buộc',
                'image.required' => 'Ảnh là bắt buộc',
                'audio_file.required' => 'File audio là bắt buộc cho audio đơn',
                'chapter_files.*.required' => 'File audio là bắt buộc cho mỗi chapter',
                'chapter_titles.*.required' => 'Tên chapter là bắt buộc'
            ]);

            // Create new audio record
            $audio = new Audio();

            // Basic info
            $audio->fill([
                'ten' => $request->ten,
                'slug' => $request->slug,
                'tacgia' => $request->tacgia,
                'tomtat' => $request->tomtat,
                'theloai_id' => $request->menu_id2 ?? $request->menu_id,
                'is_series' => $request->boolean('is_series'),
                'keyword_focus' => $request->keyword_focus,
                'seo_title' => $request->seo_title,
                'seo_keywords' => $request->seo_keywords,
                'seo_description' => $request->seo_description,
                'display' => $request->boolean('display'),
                'moi' => $request->boolean('moi'),
                'nghenhieu' => $request->boolean('nghenhieu'),
                'luot_nghe' => 0
            ]);

            // Handle main image
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = 'main_' . time() . '.' . $image->getClientOriginalExtension();

                // Add watermark
                $img = Image::make($image);
                $watermark = Image::make(public_path('uploads/images/logo.png'));
                $watermark->resize(100, null, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $img->resize(600, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                    ->insert($watermark, 'bottom-right', 10, 10)
                    ->save(public_path('uploads/images/' . $imageName));

                $audio->image = $imageName;
            }



            // Handle single episode audio
            if (!$request->boolean('is_series') && $request->hasFile('audio_file')) {
                $audioFile = $request->file('audio_file');
                $audioName = time() . '_' . Str::slug($request->ten) . '.' . $audioFile->getClientOriginalExtension();
                $audioFile->storeAs('public/audios', $audioName);
                $audio->audio_path = $audioName;
            }

            $audio->save();

            // Handle series chapters
            if ($request->boolean('is_series') && $request->hasFile('chapter_files')) {
                foreach ($request->file('chapter_files') as $index => $file) {
                    $chapterNumber = $index + 1;
                    $chapterTitle = $request->input('chapter_titles')[$index] ?? "Chapter {$chapterNumber}";
                    $audioName = time() . '_chapter_' . $chapterNumber . '_' . Str::slug($chapterTitle) . '.' . $file->getClientOriginalExtension();

                    $file->storeAs('public/audios/chapters', $audioName);

                    $audio->chapters()->create([
                        'chapter_number' => $chapterNumber,
                        'title' => $chapterTitle,
                        'audio_path' => $audioName,
                        'status' => true
                    ]);
                }

                $audio->update(['total_chapters' => count($request->file('chapter_files'))]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Audio đã được thêm thành công'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi validation',
                'errors' => $e->errors(),
                'request_data' => $request->all() // Add this to see what data was sent
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi: ' . $e->getMessage()
            ], 500);
        }
    }

    public function edit($id)
    {
        $audio = Audio::with(['chapters', 'theloai'])->findOrFail($id);
        $menu = TheLoai::with('submenu')
            ->whereNull('parent_id')
            ->orderBy('position')
            ->get();
        return view('admin.edit-audio', compact('audio', 'menu'));
    }

    public function update(Request $request, $id)
    {
        // Similar validation and logic as store method
        // But handle existing files differently
    }

    public function destroy($id)
    {
        try {
            $audio = Audio::findOrFail($id);

            // Delete main image
            if ($audio->image) {
                Storage::delete('public/uploads/images/' . $audio->image);
            }

            // Delete additional images
            if ($audio->images) {
                foreach ($audio->images as $image) {
                    Storage::delete('public/uploads/images/' . $image);
                }
            }

            // Delete audio files
            if ($audio->is_series) {
                foreach ($audio->chapters as $chapter) {
                    Storage::delete('public/audios/chapters/' . $chapter->audio_path);
                }
            } else {
                Storage::delete('public/audios/' . $audio->audio_path);
            }

            $audio->delete();

            return response()->json([
                'success' => true,
                'message' => 'Audio đã được xóa thành công'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi: ' . $e->getMessage()
            ], 500);
        }
    }
}
