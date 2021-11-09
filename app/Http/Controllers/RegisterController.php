<?php
// this class is from Adding authentication.docx - available in Week 5 practical

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function create()
    {
        return view('auth.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => ['required', 'unique:users', 'min:3', 'max:15'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:6']
        ]);

        $registerData = [
            'username' => $request->username,
            'password' => Hash::make($request->input('password')),
            'admin_role' => '0',
            'email' => $request->email,
            'avatar_path' => 'path/to/image.jpg',
            'description' => 'Some description here.',
            'email_verified_at' => now(),
            'code_2fa' => Str::random(5),
            'remember_token' => Str::random(20)
        ];

        $user = User::create($registerData);
        if ($user) {
            return redirect()->intended('/')->with('success', 'Your account has been registered. You can now login.');
        }
    }
}
