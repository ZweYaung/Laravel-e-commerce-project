<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    private function saveURLImage(){
        $user = Auth::user();

        // Check if user image file does NOT exist locally
        if (!file_exists(public_path("profile_pic/" . $user->image))) {

        // If the DB image is an external URL
        if (filter_var($user->image, FILTER_VALIDATE_URL)) {

            // Download the image from URL
            $imageContent = file_get_contents($user->image);

            // Create a unique filename
            $fileName = uniqid() . "_profilePic.jpg";

            // Save it to public/profile_pic folder
            file_put_contents(public_path("profile_pic/" . $fileName), $imageContent);

            // Update the DB with new filename
            $user->update(['image' => $fileName]);
            }
        }

    }

    // social login
    public function redirect($provider){
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
