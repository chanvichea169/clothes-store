<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;


class SocialAuthController extends Controller
{
    /**
     * Google login
     */
    public function googlelogin()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Google authentication
     */
    public function googleAuthentication()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Check if user already exists
            $userData = User::where('email', $googleUser->email)->first();

            if ($userData) {

                Auth::login($userData, true);
                return redirect('/'); // Log in the user if they exist

            } else {
                $userData = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'password' => Hash::make('password@123'),
                    'mobile' => '0986555666',
                    'google_id' => $googleUser->id,
                ]);

                if ($userData) {
                    Auth::login($userData, true);
                    return redirect('/');
                } else {
                    return redirect('/login')->with('error', 'User registration failed');
                }
            }

        } catch (Exception $e) {
            return redirect('/login')->with('error', 'Google authentication failed');
        }
    }

}
