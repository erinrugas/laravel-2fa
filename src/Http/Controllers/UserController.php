<?php

namespace App\Http\Controllers;

use App\Models\User;
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
     * Update Personal Information
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
                'unique:users,email,'.$request->user()->id
            ],
        ]);

        $user = User::where('id', $request->user()->id)->first();
        $user->name = $request->name;
        $user->email = strtolower($request->email);
        $user->save();

        return redirect()->route('profile')->with('success', 'Successfully update profile');
    }

}
