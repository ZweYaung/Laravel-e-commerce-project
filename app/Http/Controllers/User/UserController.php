<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\Contact;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function home(){
        // $this->saveURLImage();

       $newArrivals = Product::orderBy("created_at","desc")->take(6)->get();
        return view('user.home.main',compact("newArrivals"));
    }

    //direct to about page
    public function about(){
        return view ("user.layouts.about");
    }

    //direct to contact page
    public function contact(){
        return view("user.layouts.contact");
    }

    //send contact
    public function createContact(Request $request){
        $this->checkContactValidation($request);

        Contact::create([
            'user_id' => Auth::user()->id,
            'subject' => $request->subject,
            'message' => $request->message
        ]);

        return to_route("user#contact")->with("success","Your message has been sent!");
    }

    //contact validation check
    private function checkContactValidation($request){
        $request->validate([
            'subject' => 'required|max:50',
            'message' => 'required'
        ]);
    }
}
