<?php

namespace App\Providers;

use App\Models\Cart;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Trust all proxies (temporary)
    Request::setTrustedProxies(['*'], Request::HEADER_X_FORWARDED_ALL);

        if (env('APP_ENV') === 'production') {
        URL::forceScheme('https');
        }

        Paginator::useBootstrap();

        // Share wishlist and cart data with all views
         View::composer('*', function ($view) {
            if (auth()->check()) {
                // Wishlist: full collection
                $wishlistItems = Wishlist::with('product')
                    ->where('user_id', auth()->id())
                    ->get();

                // Cart: only count
                $cartCount = Cart::where('user_id', auth()->id())->count();
            } else {
                $wishlistItems = collect();
                $cartCount = 0;
            }

            $view->with([
                'wishlistItems' => $wishlistItems,
                'cartCount' => $cartCount
            ]);
        });
    }
}
