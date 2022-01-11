<?php
// this class is from Adding authentication.docx - available in Week 5 practical

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Token;
use App\Models\User;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user != null && Hash::check($request->password, $user->password)) {
            $cred = ['password' => $request->password, 'email' => $request->email];
            $code = Str::random(6);
            Token::updateOrCreate(['user_id' => $user->id], ['user_id' => $user->id, 'code_2fa' => $code, 'code_2fa_updated_at' => now()]);

            return redirect('/login')->with('status', ['code' => $code, 'status' => 1, 'req' => $cred]);
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.'
        ]);
    }

    public function twoFactorAuthenticaton(Request $request)
    {
        $request->validate([
            'twofa' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        $user = User::where('email', $request->email)->first();
        $code = Token::where(['user_id' => $user->id, 'code_2fa' => $request->twofa])->where('code_2fa_updated_at', '>=', Carbon::now()->subHours(1))->first();

        if (
            $code &&
            strlen($request->twofa) > 3 &&
            Auth::attempt([
                'email' => $request->email,
                'password' => $request->password
            ])
        ) {
            $request->session()->regenerate();
            $resetCode = NULL;
            $code->update(['code_2fa' => $resetCode, 'code_2fa_updated_at' => now()]);

            return redirect()->intended('/')->with('success', 'Logged in successfully.');
        }

        $message = "2FA code doesn't match or expired, try again.";
        $status = '0';
        return redirect('/login')->with('status', ['status' => $status, 'message' => $message]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();

        return redirect()->intended('/')->with('success', 'Logged out successfully.');
    }
}
