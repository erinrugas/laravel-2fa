<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    /**
     * Reset Password Form
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        $resetPassword = DB::table('password_resets')->where('email', $request->email)->first();

        if (is_null($resetPassword)) {
            abort(404);
        }

        if (! Hash::check($request->route('token'), $resetPassword->token) || 
            now()->format('Y-m-d H:i') > 
                Carbon::parse($resetPassword->created_at)
                ->addMinutes(60)
                ->format('Y-m-d H:i')
        ) {
            abort(419);
        }

        return view('auth.reset-password');
    }

    /**
     * Update Password
     *
     * @param Request $request
     * @return void
     */
    public function update(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8'
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        return $status == Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withInput($request->only('email'))
            ->withErrors(['password' => __($status)]);
    }
}
