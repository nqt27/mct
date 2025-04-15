<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;

class SignupController extends Controller
{
    public function index()
    {
        return view('auth.sign-up');
    }
    public function store(Request $request)
    {
        // Validate dữ liệu
        $request->validate([
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|confirmed',
            'email' => 'required|unique:users',
        ]);
        $user = new User;
        $user->username = $request->input('username');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->role = 'admin';
        $user->save();
        // Redirect về trang chủ hoặc trang danh sách sản phẩm
        return redirect()->route('login')->with('success', 'Product added successfully.');
    }
}
