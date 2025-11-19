<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\AdminProfileController;

Route::group(['prefix' => 'admin', 'middleware' => 'adminMiddleware'],function(){
    Route::get('home',[AdminController::class,'home'])->name('admin#home');

    //category
    Route::get('category',[CategoryController::class,'category'])->name('admin#category');
    Route::post('category/create',[CategoryController::class,'createCategory'])->name('create#category');
    Route::get('category/delete/{id}',[CategoryController::class,'deleteCategory'])->name('delete#category');
    Route::get('category/update/{id}',[CategoryController::class,'updateCategoryPage'])->name('update#categoryPage');
    Route::post('category/update/{id}',[CategoryController::class,'updateCategory'])->name('update#category');

    //product
    Route::get('product/create',[ProductController::class,'createProductPage'])->name('product#createPage');
    Route::post('product/create',[ProductController::class,'createProduct'])->name('product#create');
    Route::get('product/{action?}',[ProductController::class,'product'])->name('admin#product');
    Route::get('product/delete/{id}/{image}',[ProductController::class,'deleteProduct'])->name('product#delete');
    Route::get('product/edit/{id}',[ProductController::class,'edit'])->name('product#edit');
    Route::post('product/update',[ProductController::class,'update'])->name('product#update');

    //profile
    Route::group(['prefix' => 'profile'],function(){
        Route::get('change/password',[AdminProfileController::class,'changePasswordPage'])->name("admin#changePasswordPage");
        Route::post('change/password',[AdminProfileController::class,'changePassword'])->name("admin#changePassword");

        Route::get('profile',[AdminProfileController::class,'profile'])->name("admin#profile");
        Route::get('edit',[AdminProfileController::class,'edit'])->name("profile#edit");
        Route::post("update",[AdminProfileController::class,"update"])->name("profile#update");

        Route::get("photo/remove",[AdminProfileController::class,"removePhoto"])->name("profile#removePhoto");
    });

        Route::get('userList',[AccountController::class,"userList"])->name("account#userList");

        Route::middleware('superAdminMiddleware')->group(function(){
            //account
            Route::group(['prefix'=>'account'],function(){
                Route::get('adminList',[AccountController::class,"adminList"])->name("account#adminList");
                Route::get('admin/create',[AccountController::class,"createAdminPage"])->name("create#AdminPage");
                Route::post('admin/create',[AccountController::class,"createAdmin"])->name("create#Admin");
                Route::get('admin/delete/{id}/{image}',[AccountController::class,"deleteAdmin"])->name("delete#Admin");
                Route::get('admin/edit/{id}/{image}',[AccountController::class,"editAdmin"])->name("edit#admin");
                Route::post('admin/update/{id}',[AccountController::class,"updateAdmin"])->name("update#admin");
            Route::get("photo/remove/{id}/{image}",[AccountController::class,"removePhoto"])->name("admin#removePhoto");
                });

            //payment
            Route::group(["prefix"=>"payment"],function(){
                Route::get("payment",[PaymentController::class,"payment"])->name("admin#payment");
                Route::post("create",[PaymentController::class,"create"])->name("payment#create");
                Route::get("delete/{id}",[PaymentController::class,"delete"])->name("payment#delete");
                Route::get("edit/{id}",[PaymentController::class,"edit"])->name("payment#edit");
                Route::post("update/{id}",[PaymentController::class,"update"])->name("payment#update");
            });
        });

    //order
    Route::group(["prefix"=>"order"],function(){
        Route::get('saleInfo',[OrderController::class,'saleInfo'])->name('admin#saleInfo');
        Route::get("list",[OrderController::class,"orderList"])->name("admin#orderList");
        Route::get("details/{order_code}",[OrderController::class,"orderDetails"])->name("admin#orderDetails");
        Route::get('reject',[OrderController::class,'orderReject'])->name('admin#orderReject');
        Route::get('confirm',[OrderController::class,'orderConfirm'])->name('admin#orderConfirm');
        Route::get('statusChange',[OrderController::class,'orderStatusChange'])->name('admin#orderStatusChange');

    });


});
