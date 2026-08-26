<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserProfileController extends Controller
{
    public function changePasswordPage()
    {
        return view("user.profile.changePassword");
    }

    public function changePassword(Request $request)
    {
        // 1. Always validate input first
        $this->checkPasswordValidation($request);

        $user = Auth::user();

        // 2. Check current password match
        if (!Hash::check($request->currentPassword, $user->password)) {
            return back()->with('invalid-currentPassword', 'Invalid Password!');
        }

        // 3. Update password and revoke session
        User::where('id', $user->id)->update([
            'password' => Hash::make($request->newPassword)
        ]);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function edit()
    {
        return view("user.profile.edit");
    }

    public function update(Request $request)
    {
        $this->checkProfileValidation($request);
        $data = $this->getUpdateData($request);
        $user = Auth::user();
        $currentImage = $user->image;

        if ($request->hasFile('newImage')) {
            // Delete existing stored file if available
            if ($currentImage && Storage::disk('public')->exists("profile_pic/{$currentImage}")) {
                Storage::disk('public')->delete("profile_pic/{$currentImage}");
            }

            // Generate safe filename using hashName
            $file = $request->file('newImage');
            $fileName = uniqid() . '_' . $file->hashName();
            $file->storeAs('profile_pic', $fileName, 'public');

            $data['image'] = $fileName;
        } else {
            $data['image'] = $currentImage;
        }

        User::where('id', $user->id)->update($data);
        return back()->with('update', 'Account information updated successfully!');
    }

    public function removePhoto()
    {
        $user = Auth::user();
        $currentImage = $user->image;

        if ($currentImage && Storage::disk('public')->exists("profile_pic/{$currentImage}")) {
            Storage::disk('public')->delete("profile_pic/{$currentImage}");
        }

        User::where('id', $user->id)->update(['image' => null]);
        return back()->with('remove', 'Profile picture removed successfully!');
    }

    private function getUpdateData($request)
    {
        return [
            'name'  => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ];
    }

    private function checkProfileValidation($request)
    {
        $userId = Auth::id();

        $request->validate([
            'name'     => ['required', 'string', 'max:255', Rule::unique('users', 'name')->ignore($userId)],
            'email'    => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($userId)],
            'phone'    => ['nullable', 'numeric', 'digits_between:7,13'],
            'newImage' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);
    }

    private function checkPasswordValidation($request)
    {
        $request->validate([
            'currentPassword' => ['required'],
            'newPassword'     => ['required', 'min:8'],
            'confirmPassword' => ['required', 'same:newPassword'],
        ]);
    }
}
