<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    private function saveURLImage()
    {
        $user = Auth::user();

        if (!$user || empty($user->image)) {
            return;
        }

        // Only process if the image field contains a valid external URL
        if (filter_var($user->image, FILTER_VALIDATE_URL)) {
            try {
                $response = Http::timeout(5)->get($user->image);

                if ($response->successful()) {
                    $fileName = uniqid() . '_profilePic.jpg';
                    Storage::disk('public')->put("profile_pic/{$fileName}", $response->body());
                    $user->update(['image' => $fileName]);
                }
            } catch (\Exception $e) {
                // Optionally log the exception if download fails
            }
        }
    }

    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        $loginData = Socialite::driver($provider)->user();

        $existingUser = User::where('provider_id', $loginData->id)->first();

        // Preserve existing user profile picture if one is already set
        $imageValue = $existingUser && $existingUser->image
            ? $existingUser->image
            : $loginData->avatar;

        $user = User::updateOrCreate(
            ['provider_id' => $loginData->id],
            [
                'name'           => $loginData->name ?? $loginData->nickname,
                'nickname'       => $loginData->nickname,
                'email'          => $loginData->email,
                'image'          => $imageValue,
                'role'           => 'user',
                'provider'       => $provider,
                'provider_token' => $loginData->token,
            ]
        );

        Auth::login($user);

        $this->saveURLImage();

        return to_route('user#home');
    }
}
