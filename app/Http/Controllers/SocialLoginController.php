<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    private function saveURLImage()
    {
        $user = Auth::user();

        // Check if image file exists in the public storage disk
        if (!Storage::disk('public')->exists("profile_pic/" . $user->image)) {

            // If the DB image is an external URL
            if (filter_var($user->image, FILTER_VALIDATE_URL)) {

                // Download image content
                $imageContent = file_get_contents($user->image);

                // Generate unique filename
                $fileName = uniqid() . "_profilePic.jpg";

                // Store using Laravel Storage facade (creates folder automatically with right permissions)
                Storage::disk('public')->put("profile_pic/{$fileName}", $imageContent);

                // Update database
                $user->update(['image' => $fileName]);
            }
        }
    }

    // social login
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        $loginData = Socialite::driver($provider)->user();

        $existingUser = User::where('provider_id', $loginData->id)->first();

        $imageValue = $loginData->avatar;
        if ($existingUser && !filter_var($existingUser->image, FILTER_VALIDATE_URL)) {
            $imageValue = $existingUser->image;
        }

        // Create or update user
        $user = User::updateOrCreate(
            ['provider_id' => $loginData->id],
            [
                'name' => $loginData->name,
                'nickname' => $loginData->nickname,
                'email' => $loginData->email,
                'image' => $imageValue,
                'role' => 'user',
                'provider' => $provider,
                'provider_id' => $loginData->id,
                'provider_token' => $loginData->token,
            ]
        );

        Auth::login($user);

        $this->saveURLImage();

        return to_route('user#home');
    }
}
