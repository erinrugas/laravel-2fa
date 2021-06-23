<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ValidateForgotPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /**
     * Forgot Password Form
     *
     * @return void
     */
    public function index()
    {
        return view('auth.forgot-password');
    }

    /**
     * Search for email and send reset link
     *
     * @param ValidateForgotPassword $request
     * @return void
     */
    public function search(ValidateForgotPassword $request)
    {
        $sendLinkStatus = $request->sendLink();

        return $sendLinkStatus == Password::RESET_LINK_SENT
                ? back()->with('status', __($sendLinkStatus))
                : back()->withInput($request->only('email'))
                        ->withErrors(['email' => __($sendLinkStatus)]);
    }
}
