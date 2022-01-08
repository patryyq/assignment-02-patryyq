<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Token;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

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
            Token::updateOrCreate(['user_id' => $user->id], ['user_id' => $user->id, 'token' => $token, 'token_updated_at' => now()]);
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
        $user = User::where('email', $email)->first();
        $tkn = Token::where(['user_id' => $user->id, 'token' => $token])
            ->where('token_updated_at', '>=', Carbon::now()->subDays(1)->toDateTimeString())->first();
        if ($tkn && strlen($token) > 15) {
            $status = '2';
            return view('auth.forgot', ['email' => $email, 'token' => $token, 'status' => $status]);
        } else {
            $message = 'Link invalid. Generate a new one.';
            $status = '0';
            return redirect('/forgot-password')->with('status', ['status' => $status, 'message' => $message]);
        }
    }

    public function resetPassword(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        $token = Token::where(['user_id' => $user->id, 'token' => $request->token])->first();

        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        if ($token && strlen($request->token) > 15) {
            $resetToken = NULL;
            $user->update(['password' => Hash::make($request->password)]);
            $token->update(['token' => $resetToken, 'token_updated_at' => now()]);
            $message = 'Password changed successfully.';
            $status = '3';
            return redirect('/login')->with('status', ['status' => $status, 'message' => $message]);
        } else {
            return redirect('/');
        }
    }
}
