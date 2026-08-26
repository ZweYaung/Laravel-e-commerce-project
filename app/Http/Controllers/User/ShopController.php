<?php

namespace App\Http\Controllers\User;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Rating;
use App\Models\Comment;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Models\PaymentHistory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ShopController extends Controller
{
    // PUBLIC METHODS - No auth required

    /**
     * Direct to shop page - PUBLIC
     * Anyone can browse products
     */
    public function shop($action = "default")
    {
        $products = Product::select(
            'products.id',
            'products.name',
            'products.image',
            'products.price',
            'products.stock',
            'products.category_id',
            'categories.name as category_name'
        )
            ->leftJoin('categories', 'products.category_id', 'categories.id')
            ->when(request('searchKey'), function ($query) {
                $query->whereAny(['products.name', 'products.price', 'categories.name'], 'like', '%' . request('searchKey') . '%');
            })
            ->when($action == "oldest", function ($query) {
                $query->orderBy("products.created_at", "asc");
            })
            ->when($action == "priceLowToHigh", function ($query) {
                $query->orderBy("products.price", "asc");
            })
            ->when($action == "priceHighToLow", function ($query) {
                $query->orderBy("products.price", "desc");
            })
            ->orderBy("products.created_at", "desc")
            ->paginate(8);

        // Get wishlist items if user is logged in
        $wishlistItems = collect();
        if (auth()->check()) {
            $wishlistItems = Wishlist::where('user_id', auth()->id())->with('product')->get();
        }

        return view("user.shop.shop", compact("products", "action", "wishlistItems"));
    }

    /**
     * Direct to product details page - PUBLIC
     * Anyone can view product details
     */
    public function productDetails($id)
    {
        $products = Product::get();

        $product = Product::where("products.id", $id)
            ->select(
                'products.id',
                'products.name',
                'products.image',
                'products.description',
                'products.price',
                'products.stock',
                'products.category_id',
                'categories.name as category_name'
            )
            ->leftJoin("categories", "products.category_id", "categories.id")
            ->first();

        $comments = Comment::select(
            'ratings.count as rating',
            'comments.id as comment_id',
            'comments.created_at',
            'comments.message',
            'users.id as user_id',
            'users.image',
            'users.name'
        )
            ->where('comments.product_id', $id)
            ->leftJoin('users', 'users.id', 'comments.user_id')
            ->leftJoin('ratings', function ($join) {
                $join->on('ratings.user_id', '=', 'comments.user_id')
                    ->on('ratings.product_id', '=', 'comments.product_id');
            })
            ->orderBy('comments.created_at', 'desc')
            ->get();

        $stars = number_format(Rating::where("product_id", $id)->avg('count'));

        // Only get user rating if logged in
        $userRating = 0;
        if (auth()->check()) {
            $userRating = number_format(Rating::where("product_id", $id)
                ->where("user_id", Auth::user()->id)
                ->value("count"));
        }

        // Get wishlist items if user is logged in
        $wishlistItems = collect();
        if (auth()->check()) {
            $wishlistItems = Wishlist::where('user_id', auth()->id())->with('product')->get();
        }

        return view("user.shop.productDetails", compact(
            "product",
            "products",
            "stars",
            "comments",
            "userRating",
            "wishlistItems"
        ));
    }

    /**
     * View cart - PUBLIC (with guest cart support)
     * Anyone can view their cart (guests see session cart)
     */
    public function cart()
    {
        $cart = collect();
        $total = 0;

        if (auth()->check()) {
            // Logged in user - get cart from database
            $cart = Cart::select(
                'carts.id as cart_id',
                'carts.qty',
                'products.id as product_id',
                'products.name',
                'products.price',
                'products.image'
            )
                ->leftJoin('products', 'carts.product_id', 'products.id')
                ->where('carts.user_id', Auth::user()->id)
                ->get();

            foreach ($cart as $item) {
                $total += $item->price * $item->qty;
            }
        } else {
            // Guest user - get cart from session
            $cart = session()->get('guest_cart', []);
            foreach ($cart as $item) {
                $total += $item['price'] * $item['quantity'];
            }
        }

        return view('user.layouts.cart', compact("cart", "total"));
    }

    // PROTECTED METHODS - Require authentication

    // Create rating - Requires login
    public function rating(Request $request)
    {
        if (!auth()->check()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please log in to rate this product',
                    'redirect' => route('login')
                ], 401);
            }
            return redirect()->route('login')->with('error', 'Please log in to rate this product');
        }

        Rating::updateOrCreate([
            'user_id' => Auth::user()->id,
            'product_id' => $request->productId
        ], [
            "product_id" => $request->productId,
            "user_id" => Auth::user()->id,
            "count" => $request->productRating
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Thanks for your feedback!'
            ]);
        }

        return back()->with("rate", "Thanks for your feedback!");
    }

    // Create comment - Requires login
    public function createComment(Request $request)
    {
        if (!auth()->check()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please log in to comment',
                    'redirect' => route('login')
                ], 401);
            }
            return redirect()->route('login')->with('error', 'Please log in to comment');
        }

        $request->validate([
            "message" => "required"
        ]);

        Comment::create([
            "product_id" => $request->productId,
            "user_id" => Auth::user()->id,
            "message" => $request->message
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Your review has been submitted!'
            ]);
        }

        return back()->with("comment", "Your review has been submitted!");
    }

    // Add to cart (POST) - Requires login
    public function addToCart(Request $request)
    {
        if (!auth()->check()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please log in to add items to cart',
                    'redirect' => route('login')
                ], 401);
            }
            return redirect()->route('login')->with('error', 'Please log in to add items to cart');
        }

        // Check if product already in cart
        $existingCart = Cart::where('user_id', $request->userId)
            ->where('product_id', $request->productId)
            ->first();

        if ($existingCart) {
            $existingCart->qty += $request->qty;
            $existingCart->save();
        } else {
            Cart::create([
                'user_id' => $request->userId,
                'product_id' => $request->productId,
                'qty' => $request->qty
            ]);
        }

        $cartCount = Cart::where('user_id', auth()->id())->count();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Item added to cart!',
                'cartCount' => $cartCount
            ]);
        }

        return back()->with("addToCart", "Item added to your cart!");
    }

    // Add to cart (GET) - Requires login
    public function addToCartGet($productId)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please log in to add items to cart');
        }

        // Check if product already in cart
        $existingCart = Cart::where('user_id', auth()->id())
            ->where('product_id', $productId)
            ->first();

        if ($existingCart) {
            $existingCart->qty += 1;
            $existingCart->save();
        } else {
            Cart::create([
                'user_id' => Auth::user()->id,
                'product_id' => $productId,
                'qty' => 1
            ]);
        }

        return back()->with("addToCart", "Item added to your cart!");
    }

    // Remove from cart - Requires login
    public function cartRemove(Request $request)
    {
        if (!auth()->check()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Please log in'
            ], 401);
        }

        $cartId = $request->cartId;
        Cart::where('id', $cartId)->where('user_id', auth()->id())->delete();

        $cartCount = Cart::where('user_id', auth()->id())->count();

        return response()->json([
            'status' => 'success',
            'message' => 'Item removed from cart',
            'cartCount' => $cartCount
        ], 200);
    }

    // Update cart quantity - Requires login
    public function updateCart(Request $request, $cartId)
    {
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        $cart = Cart::where('id', $cartId)->where('user_id', auth()->id())->first();
        if (!$cart) {
            return response()->json([
                'success' => false,
                'message' => 'Cart item not found'
            ], 404);
        }

        $cart->qty = $request->quantity;
        $cart->save();

        return response()->json([
            'success' => true,
            'cartCount' => Cart::where('user_id', auth()->id())->count()
        ]);
    }

    // Temp storage for order - Requires login
    public function tempStorage(Request $request)
    {
        if (!auth()->check()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Please log in'
            ], 401);
        }

        $orderTemp = [];

        foreach ($request->all() as $item) {
            array_push($orderTemp, [
                "user_id" => $item['user_id'],
                "product_id" => $item['product_id'],
                "count" => $item['count'],
                "status" => $item['status'],
                "order_code" => $item['order_code'],
                "finalAmt" => $item['totalAmt']
            ]);
        }

        Session::put('tempCart', $orderTemp);

        return response()->json([
            'status' => "success",
            'message' => "temp storage success"
        ], 200);
    }

    // Checkout page - Requires login
    public function checkOutPage()
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please log in to checkout');
        }

        $paymentAcc = PaymentMethod::select("id", "account_name", "account_number", "type")
            ->orderBy("type", "asc")
            ->get();
        $orderTemp = Session::get("tempCart");

        return view("user.shop.checkOut", compact("paymentAcc", "orderTemp"));
    }

    // Place order - Requires login
    public function order(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please log in to place order');
        }

        $request->validate([
            'name' => 'required',
            'phone' => 'required|numeric',
            'address' => 'required|max:150',
            'paymentType' => 'required',
            'payslipImage' => 'required|file|mimes:png,jpg,jpeg,webp,svg,gif'
        ]);

        $orderTemp = Session::get('tempCart');

        $paymentHistoryData = [
            'user_name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'payment_method' => $request->paymentType,
            'order_code' => $request->orderCode,
            'total_amt' => $request->totalAmount
        ];

        if ($request->hasFile('payslipImage')) {
            $fileName = uniqid() . $request->file('payslipImage')->getClientOriginalName();
            $request->file('payslipImage')->move(public_path() . "/payslipImage/", $fileName);
            $paymentHistoryData['payslip_image'] = $fileName;
        }

        PaymentHistory::create($paymentHistoryData);

        foreach ($orderTemp as $item) {
            Order::create([
                'product_id' => $item['product_id'],
                'user_id' => $item['user_id'],
                'count' => $item['count'],
                'status' => $item['status'],
                'order_code' => $item['order_code']
            ]);

            Cart::where('user_id', $item['user_id'])
                ->where('product_id', $item['product_id'])
                ->delete();
        }

        Session::forget('tempCart');

        return to_route("user#orderList")->with("order", "Your order has been placed.");
    }

    // Order list - Requires login
    public function orderList()
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please log in to view orders');
        }

        $orderList = Order::where("user_id", Auth::user()->id)
            ->groupBy("order_code")
            ->orderBy("created_at", "desc")
            ->paginate(5);

        return view('user.shop.orderList', compact('orderList'));
    }

    // Order details - Requires login
    public function orderDetails($orderCode)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please log in to view order details');
        }

        $order = Order::select(
            'products.id as product_id',
            'products.name as product_name',
            'products.image',
            'products.price',
            'products.stock',
            'orders.id as order_id',
            'orders.user_id',
            'orders.count as order_count',
            'orders.order_code',
            'orders.created_at'
        )
            ->leftJoin('products', 'orders.product_id', 'products.id')
            ->where('orders.order_code', $orderCode)
            ->get();

        $paymentHistory = PaymentHistory::select('payment_histories.*', 'payment_methods.type as payment_type')
            ->leftJoin('payment_methods', 'payment_methods.id', 'payment_histories.payment_method')
            ->where('order_code', $orderCode)
            ->first();

        return view("user.shop.orderDetails", compact("order", "paymentHistory"));
    }

    // GUEST CART METHODS

    // Add to guest cart (session-based)
    public function addToGuestCart(Request $request)
    {
        $productId = $request->productId;
        $product = Product::find($productId);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }

        $cart = session()->get('guest_cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $request->quantity ?? 1;
        } else {
            $cart[$productId] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image,
                'quantity' => $request->quantity ?? 1
            ];
        }

        session()->put('guest_cart', $cart);

        return response()->json([
            'success' => true,
            'message' => 'Added to cart',
            'cartCount' => count($cart)
        ]);
    }

    // Remove from guest cart
    public function removeGuestCart(Request $request)
    {
        $productId = $request->productId;
        $cart = session()->get('guest_cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('guest_cart', $cart);
        }

        return response()->json([
            'success' => true,
            'message' => 'Item removed from cart',
            'cartCount' => count($cart)
        ]);
    }

    // Update guest cart quantity
    public function updateGuestCart(Request $request)
    {
        $productId = $request->productId;
        $quantity = $request->quantity;
        $cart = session()->get('guest_cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] = $quantity;
            session()->put('guest_cart', $cart);
        }

        return response()->json([
            'success' => true,
            'cartCount' => count($cart)
        ]);
    }

     // Merge guest cart with user cart after login
    public function mergeGuestCart()
    {
        if (auth()->check()) {
            $guestCart = session()->get('guest_cart', []);

            foreach ($guestCart as $item) {
                $existingCart = Cart::where('user_id', auth()->id())
                    ->where('product_id', $item['id'])
                    ->first();

                if ($existingCart) {
                    $existingCart->qty += $item['quantity'];
                    $existingCart->save();
                } else {
                    Cart::create([
                        'user_id' => auth()->id(),
                        'product_id' => $item['id'],
                        'qty' => $item['quantity']
                    ]);
                }
            }

            session()->forget('guest_cart');
            return true;
        }

        return false;
    }
}
