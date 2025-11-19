<?php

namespace App\Http\Controllers\User;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class WishListController extends Controller
{
    //add item to wishlist
    public function addWishlist($id){
        $product = Product::where('id',$id)->first();

        Wishlist::where('id',$id)->create([
            'product_id' => $id,
            'user_id' => Auth::user()->id
        ]);

        return back();
    }

    //remove item from wishlist
    public function removeWishlist($id){
        Wishlist::where("id",$id)->delete();
        return back();
    }
}
