<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminProfileController extends Controller
{
    //direct to change password page
    public function changePasswordPage(){
        return view('admin.profile.changePassword');
    }

    //change password
    public function changePassword(Request $request){
        $dbPassword = Auth::user()->password; //hash value from database

        if(Hash::check($request->currentPassword,$dbPassword)){
            $this->checkPasswordValidation($request);

            User::where('id',Auth::user()->id)->update([
                'password' => Hash::make($request->newPassword)
            ]);

                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect('/');
        }else{
            if($request->currentPassword != null){
                return back()->with('invalid-currentPassword','Invalid Password!');
            }else{
                $this->checkPasswordValidation($request);
            }
        }
    }

    //direct to admin profile
    public function profile(){
        return view("admin.profile.profile");
    }

    //direct to profile edit page
    public function edit(){
        return view("admin.profile.edit");
    }

    //profile update
    public function update(Request $request){
        $this->checkProfileValidation($request);
        $data = $this->getUpdateData($request);
        $currentImage = Auth::user()->image;

        if($request->hasFile("newImage")){
            if($currentImage != null){
                if(file_exists(public_path("profile_pic/".$currentImage))){
                    unlink(public_path("profile_pic/".$currentImage));
                }
            }

            $fileName = uniqid().$request->file('newImage')->getClientOriginalName();
            $request->file("newImage")->move(public_path()."/profile_pic/",$fileName);
            $data['image'] = $fileName;

        }else{
            $data['image'] = $currentImage;
        }

        User::where('id',Auth::user()->id)->update($data);
        return back()->with('update','Account information updated successfully!');
    }

    //get profile update data
    private function getUpdateData($request){
        return [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone
        ];
    }

    //remove profile pic
    public function removePhoto()
    {
        if(file_exists(public_path("profile_pic/".Auth::user()->image))){
            unlink(public_path("profile_pic/".Auth::user()->image));
        }

        User::where("id", Auth::id())->update(['image' => null]);
        return back()->with('remove','Profile picture removed successfully!');
    }

    //check password validation
    private function checkPasswordValidation($request){
        $request->validate([
            'currentPassword' => 'required',
            'newPassword' => 'required|min:8',
            'confirmPassword' => 'required|same:newPassword'
        ]);
    }

    //check profile validation
    private function checkProfileValidation($request){
        $request->validate([
            'name' => 'required|unique:users,name,'.Auth::user()->id,
            'email' => 'required|unique:users,email,'.Auth::user()->id,
            'phone' => $request->phone != null ? 'numeric|digits_between:7,13' : ''
        ]);
    }
}
