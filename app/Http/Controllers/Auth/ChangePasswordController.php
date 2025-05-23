<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    public function showChangePasswordForm()
    {
        return view('auth.change-password');
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'You must be logged in to change your password.');
        }

        $request->validate([
            'email' => 'required|email|in:'.$user->email,
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
            'new_password_confirmation' => 'required'
        ], [
            'email.in' => 'The email does not match your account.',
            'new_password.confirmed' => 'New password confirmation does not match.',
            'new_password.min' => 'New password must be at least 8 characters.'
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('home.index')->with('message', 'Password changed successfully!');
    }
}
