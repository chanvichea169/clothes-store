<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChangePasswordController extends Controller
{
    public function showChangePasswordForm()
    {
        return view('auth.change-password');
    }

    public function updatePassword(Request $request)
    {
        $user = auth()->Auth::user();

        if (!$user) {
            return redirect()->route('user.change.password')->with('message', 'You must be logged in to change your password.');
        }

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6',
        ]);

        if (!password_verify($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->password = bcrypt($request->new_password);
        $user->save();

        return redirect()->route('home.index')->with('message', 'Password changed successfully! Please log in with your new password.');

    }
}