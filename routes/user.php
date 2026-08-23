<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\ShopController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\WishListController;
use App\Http\Controllers\User\UserProfileController;

// PUBLIC ROUTES
Route::get('home', [UserController::class, 'home'])->name('user#home');
Route::get('about', [UserController::class, "about"])->name("user#about");
Route::get("contact", [UserController::class, "contact"])->name("user#contact");
Route::post('contact', [UserController::class, 'createContact'])->name('user#createContact');

Route::group(["prefix" => "shop"], function() {
    Route::get("shop/{action?}", [ShopController::class, "shop"])->name("user#shop");
    Route::get("product/details/{id}", [ShopController::class, "productDetails"])->name("shop#productDetails");
});

Route::get("cart", [ShopController::class, "cart"])->name("user#cart");

Route::post("guest/cart/add", [ShopController::class, "addToGuestCart"])->name("guest#cartAdd");
Route::delete("guest/cart/remove", [ShopController::class, "removeGuestCart"])->name("guest#cartRemove");
Route::patch("guest/cart/update", [ShopController::class, "updateGuestCart"])->name("guest#cartUpdate");

// PROTECTED ROUTES
Route::group(['middleware' => 'userMiddleware'], function() {

    // Profile
    Route::get('change/password', [UserProfileController::class, "changePasswordPage"])->name("user#changePasswordPage");
    Route::post("change/password", [UserProfileController::class, "changePassword"])->name("user#changePassword");
    Route::get('edit', [UserProfileController::class, "edit"])->name("user#editPage");
    Route::post('update', [UserProfileController::class, "update"])->name("user#update");
    Route::get("photo/remove", [UserProfileController::class, "removePhoto"])->name("user#removePhoto");

    // Shop actions
    Route::post("rating", [ShopController::class, "rating"])->name("user#rating");
    Route::post("create/comment", [ShopController::class, "createComment"])->name("create#comment");

    // Cart
    Route::post("add/cart", [ShopController::class, "addToCart"])->name("user#addToCart");
    Route::get("add/cart/{productId}", [ShopController::class, "addToCartGet"])->name("user#addToCartGet");
    Route::get("remove/cart", [ShopController::class, "cartRemove"])->name("user#removeCart");
    Route::patch("cart/update/{cartId}", [ShopController::class, "updateCart"])->name("user#updateCart");
    Route::get("checkOutPage", [ShopController::class, "checkOutPage"])->name("user#checkOutPage");
    Route::get("tempStorage", [ShopController::class, "tempStorage"])->name("user#tempStorage");
    Route::post("order", [ShopController::class, "order"])->name("user#order");
    Route::get("orderList", [ShopController::class, "orderList"])->name("user#orderList");
    Route::get("order/details/{orderCode}", [ShopController::class, "orderDetails"])->name("user#orderDetails");

    // Wishlist
    Route::group(["prefix" => "wishlist"], function() {
        Route::get("add/{id}", [WishListController::class, "addWishlist"])->name("wishlist#add");
        Route::get("remove/{id}", [WishListController::class, "removeWishlist"])->name("wishlist#remove");
        Route::post("toggle", [WishListController::class, "toggle"])->name("wishlist#toggle");
        // NEW route for offcanvas refresh
        Route::get("offcanvas-items", [WishListController::class, "offcanvasItems"])->name("wishlist.offcanvas");
    });
});