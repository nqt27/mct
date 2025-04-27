<?php

namespace App\Http\Controllers;

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

class BlogDetailController extends Controller
{

    public function index($slug)
    {
        $blog = Blog::where('slug', $slug)->first();

        return view('blogdetail', ['blog' => $blog]);
    }
}
