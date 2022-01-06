<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{
    public function forgot()
    {
        return view('auth.forgot');
    }

    public function sendLinkWithToken(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email']
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            $token = Str::random(40);
            $user->update(['remember_token' => $token]);
            $message = 'reset-password/' . $request->email . '/' . $token;
            $status = '1';
        } else {
            $message = 'Given email does not exist in our database.';
            $status = '0';
        }
        return redirect('/forgot-password')->with('status', ['status' => $status, 'message' => $message]);
    }

    public function verifyToken($email, $token)
    {
        $user = User::where(['email' => $email, 'remember_token' => $token])->first();

        if ($user) {
            $status = '2';
            return view('auth.forgot', ['email' => $email, 'token' => $token, 'status' => $status]);
        } else {
            return redirect('/');
        }
    }

    public function resetPassword(Request $request)
    {
        $user = User::where(['email' => $request->email, 'remember_token' => $request->token])->first();

        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        if ($user) {
            $token = NULL;
            $user->update(['remember_token' => $token, 'password' => Hash::make($request->password)]);
            $message = 'Password changed successfully.';
            $status = '3';
            return redirect('/login')->with('status', ['status' => $status, 'message' => $message]);
        } else {
            return redirect('/');
        }
    }
}
