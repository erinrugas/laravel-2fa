<?php

namespace App\Http\Controllers;

use App\Models\User;
use ErinRugas\Laravel2fa\Actions\DisableTwoFactorAuth;
use ErinRugas\Laravel2fa\Actions\EnableTwoFactorAuth;
use ErinRugas\Laravel2fa\Actions\GenerateTwoFactorAuth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Profile Page
     *
     * @return void
     */
    public function index()
    {
        return view('users.profile');
    }

    /**
     * Update Profile
     *
     * @param Request $request
     * @return void
     */
    public function update(Request $request)
    {
        $request->validate([
            'name'  => 'required|max:255',
            'email'  => [
                'required',
                'email',
                'unique:users,email,' . $request->user()->id
            ],
        ]);

        $user = User::where('id', $request->user()->id)->first();
        $user->name = $request->name;
        $user->email = strtolower($request->email);
        $user->save();

        return redirect()->route('profile')->with('success', 'Successfully update profile');
    }

    /**
     * Enable Two Factor Auth
     *
     * @param Request $request
     * @param EnableTwoFactorAuth $enableTwoFactorAuth
     * @return void
     */
    public function enableTwoFactorAuth(Request $request, EnableTwoFactorAuth $enableTwoFactorAuth)
    {
        $enableTwoFactorAuth($request->user());

        return redirect()->route('profile')->with('enable_two_factor', 'Enable Two Factor Authentication');
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function showRecoveryCode()
    {
        return redirect()->route('profile')->with('show_two_factor', 'Show Two Factor Authentication');
    }

    /**
     * Generate New Recovery Code
     *
     * @param Request $request
     * @param GenerateTwoFactorAuth $generateTwoFactorAuth
     * @return void
     */
    public function generateRecoveryCode(Request $request, GenerateTwoFactorAuth $generateTwoFactorAuth)
    {
        $generateTwoFactorAuth($request->user());

        return redirect()->route('profile')->with('show_two_factor', 'Generate Two Factor Authentication');
    }

    /**
     * Disable Two Factor Auth
     *
     * @param Request $request
     * @param DisableTwoFactorAuth $disableTwoFactorAuth
     * @return void
     */
    public function disableTwoFactorAuth(Request $request, DisableTwoFactorAuth $disableTwoFactorAuth)
    {
        $disableTwoFactorAuth($request->user());

        return redirect()->route('profile')->with('enable_two_factor', 'Enable Two Factor Authentication');
    }
}
