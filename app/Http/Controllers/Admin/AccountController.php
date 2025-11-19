<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AccountController extends Controller
{
    //direct to user list
    public function userList(){
        $user = User::where('role','user')
        ->when(request('searchKey'),function($query){
            $query->whereAny(['name','email','phone','provider'], 'like' , '%'.request('searchKey').'%' );
        })
        ->paginate(5);
        return view("admin.account.userList",compact("user"));
    }

    //direct to admin list
    public function adminList(){
        $admin = User::where('role','admin')
        ->when(request('searchKey'),function($query){
            $query->whereAny(['name','email','phone'], 'like' , '%'.request('searchKey').'%' );
        })
        ->paginate(5);
        return view("admin.account.adminList",compact("admin"));
    }

    //direct to create admin page
    public function createAdminPage(){
        return view("admin.account.adminCreate");
    }

    //create new admin
    public function createAdmin(Request $request){
        $request->validate([
            'name' => 'required|unique:users,name|min:3|max:50',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:8',
            'confirmPassword' => 'required|same:password'
        ]);

        User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => $request->password,
            "role" => "admin",

        ]);

        return back()->with('create','Admin account created successfully!');
    }

    //delete admin
    public function deleteAdmin($id,$image){
        if($image != 0){
            if(file_exists(public_path('profile_pic/'.$image))){
                 unlink(public_path('profile_pic/'.$image));
            }
        }

        User::where('id',$id)->delete();
        return back()->with("delete","Admin deleted successfully!");
    }

    //direct to admin edit page
    public function editAdmin($id,$image){
        $admin = User::where('id',$id)->first();
        return view("admin.account.edit",compact('admin'));
    }

    //update admin account
    public function updateAdmin(Request $request,$id){
        $this->checkValidation($request);
        $data = $this->getUpdateData($request);

        if($request->hasFile("newImage")){
            if($request->oldImage != null){
                if(file_exists(public_path("profile_pic/".$request->oldImage))){
                    unlink(public_path("profile_pic/".$request->oldImage));
                }
            }

            $fileName = uniqid().$request->file('newImage')->getClientOriginalName();
            $request->file("newImage")->move(public_path()."/profile_pic/",$fileName);
            $data['image'] = $fileName;

        }else{
            $data['image'] = $request->oldImage;
        }

        User::where('id',$id)->update($data);
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

    //check validation
    private function checkValidation($request){
        $request->validate([
            'name' => 'required|unique:users,name,'.$request->id,
            'email' => 'required|unique:users,email,'.$request->id,
            'phone' => $request->phone != null ? 'numeric|digits_between:7,13' : ''
        ]);
    }

    //remove profile picture
    public function removePhoto($id,$image)
    {
        if(file_exists(public_path("profile_pic/".$image))){
            unlink(public_path("profile_pic/".$image));
        }

        User::where("id",$id)->update(['image' => null]);
        return back()->with('remove','Profile picture removed successfully!');
    }
}
