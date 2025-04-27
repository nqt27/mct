<?php

namespace App\Http\Controllers;

use App\Mail\AdminContactNotificationMail;
use App\Models\Audio;
use App\Models\Blog;
use App\Models\DichVu;
use App\Models\Logo;
use App\Models\MenuDichVu;
use App\Models\Slide;
use App\Models\TheLoai;
use App\Models\User;
use App\Notifications\FormSubmitted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    public function index()
    {
        $logo = Logo::first();
        $hot_audio = Audio::where('nghenhieu', 1)->take(6)->get(); // Nếu `new` lưu là số 1
        $new_audio = Audio::where('moi', 1)->take(6)->get(); // Nếu `new` lưu là số 1

        $slide = Slide::where('display', 1)->get();
        $blog = Blog::take(6)->get(); // Nếu `new` lưu là số 1
        $dichvu = DichVu::take(3)->get();

        return view('home', ['logo' => $logo, 'hot_audio' => $hot_audio, 'new_audio' => $new_audio, 'dichvu' => $dichvu, 'blog' => $blog, 'slide' => $slide]);
    }
    public function detail($slug)
    {
        $dichvu = DichVu::where('slug', $slug)->first();
        if ($dichvu) {
            $logo = Logo::first();
            // $hot_audio = DichVu::where('nghenhieu', 1)->take(6)->get(); // Nếu `new` lưu là số 1
            // $new_audio = DichVu::where('moi', 1)->take(6)->get(); // Nếu `new` lưu là số 1
            $dichvu = DichVu::where('slug', $slug)->first(); // Nếu `new` lưu là số 1
            $menu = MenuDichVu::whereNull('parent_id') // Chỉ lấy menu cha
                ->orderBy('position') // Sắp xếp theo vị trí
                ->get();
            $slide = Slide::where('display', 1)->get();
            // $dichvu = Audio::take(6)->get(); // Nếu `new` lưu là số 1

            return view('detail-dichvu', ['logo' => $logo, 'dichvu' => $dichvu, 'menu' => $menu, 'slide' => $slide]);
        }
        $audio = Audio::where('slug', $slug)->first();
        if ($audio) {
            $logo = Logo::first();
            $hot_audio = Audio::where('nghenhieu', 1)->take(6)->get(); // Nếu `new` lưu là số 1
            $new_audio = Audio::where('moi', 1)->take(6)->get(); // Nếu `new` lưu là số 1
            $audio = Audio::where('slug', $slug)->first(); // Nếu `new` lưu là số 1
            $menu = TheLoai::whereNull('parent_id') // Chỉ lấy menu cha
                ->orderBy('position') // Sắp xếp theo vị trí
                ->get();
            $slide = Slide::where('display', 1)->get();
            $dichvu = Audio::take(6)->get(); // Nếu `new` lưu là số 1

            return view('detail', ['logo' => $logo, 'audio' => $audio, 'hot_audio' => $hot_audio, 'new_audio' => $new_audio, 'menu' => $menu, 'dichvu' => $dichvu, 'slide' => $slide]);
        }
    }

    public function handleForm(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|email',
        ]);

        $data = [
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
        ];
        // Gửi thông báo đến tất cả các admin
        $admins = User::all();  // Lấy tất cả các admin từ cơ sở dữ liệu
        foreach ($admins as $admin) {
            $admin->notify(new FormSubmitted($data)); // Gửi thông báo cho từng admin
        }
        // Gửi email đến admin
        Mail::send('emails.notify-admin', $data, function ($message) {
            $message->to('nqt271@gmail.com')
                ->subject('Liên hệ tư vấn')
                ->from('spamnt27@gmail.com',  'SnakeTeam');
        });

        return back()->with('success', 'Form submitted successfully!');
    }
    public function sendContactMail(Request $request)
    {
        $admin = User::first();
        $data = $request->all(); // Bao gồm thông tin người dùng + cart



        if ($admin) {
            Mail::to($admin->email)->send(new AdminContactNotificationMail($data));
        }
        if ($admin) {
            $admin->notify(new FormSubmitted($data));
        }
        return response()->json(['success' => true]);
    }
}
