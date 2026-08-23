<?php

namespace App\Http\Controllers\User;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class WishListController extends Controller
{
    public function addWishlist($id)
    {
        $existingWishlist = Wishlist::where('user_id', Auth::id())
            ->where('product_id', $id)
            ->first();

        if (!$existingWishlist) {
            Wishlist::create([
                'product_id' => $id,
                'user_id' => Auth::id()
            ]);
        }

        return back();
    }

    public function removeWishlist($id)
    {
        Wishlist::where('id', $id)
            ->where('user_id', Auth::id())
            ->delete();

        return back();
    }

    public function toggle(Request $request)
    {
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please log in to manage wishlist'
            ], 401);
        }

        $request->validate([
            'productId' => 'required|integer|exists:products,id'
        ]);

        $userId = auth()->id();
        $productId = $request->productId;

        $wishlist = Wishlist::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($wishlist) {
            $wishlist->delete();

            return response()->json([
                'success' => true,
                'inWishlist' => false,
                'message' => 'Removed from wishlist',
                'wishlistCount' => Wishlist::where('user_id', $userId)->count(),
                'productId' => $productId
            ]);
        }

        $product = Product::findOrFail($productId);

        $newWishlist = Wishlist::create([
            'user_id' => $userId,
            'product_id' => $productId
        ]);

        return response()->json([
            'success' => true,
            'inWishlist' => true,
            'message' => 'Added to wishlist',
            'wishlistCount' => Wishlist::where('user_id', $userId)->count(),
            'productId' => $productId,
            'itemData' => [
                'id' => $newWishlist->id,
                'product_id' => $product->id,
                'product_name' => $product->name,
                'product_price' => $product->price,
                'product_image' => $product->image,
                'product_url' => route('shop#productDetails', $product->id)
            ]
        ]);
    }

    /**
     * Return the rendered HTML for the offcanvas wishlist items.
     */
    public function offcanvasItems()
    {
        $wishlistItems = Wishlist::with('product')
            ->where('user_id', auth()->id())
            ->get();

        return view('partials.wishlist-offcanvas-items', compact('wishlistItems'));
    }
}