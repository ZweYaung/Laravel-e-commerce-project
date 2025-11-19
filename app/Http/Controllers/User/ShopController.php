<?php

namespace App\Http\Controllers\User;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Rating;
use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Models\PaymentHistory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ShopController extends Controller
{
    //direct to shop page
    public function shop($action = "default"){
        $products = Product::select('products.id','products.name','products.image','products.price','products.stock','products.category_id','categories.name as category_name')
                    ->leftJoin('categories','products.category_id','categories.id')
                    ->when(request('searchKey'),function($query){
                            $query->whereAny(['products.name','products.price','categories.name'], 'like' , '%'.request('searchKey').'%' );
                        })
                    ->when($action == "oldest",function($query){
                        $query->orderBy("products.created_at","asc");
                    })
                    ->when($action == "priceLowToHigh",function($query){
                        $query->orderBy("products.price","asc");
                    })
                    ->when($action == "priceHighToLow",function($query){
                        $query->orderBy("products.price","desc");
                    })
                    ->orderBy("products.created_at","desc")
                    ->paginate(8);
        return view("user.shop.shop",compact("products","action"));
    }

    //direct to product details page
    public function productDetails($id){
        $products = Product::get();

        $product = Product::where("products.id",$id)->select('products.id','products.name','products.image','products.description','products.price','products.stock','products.category_id','categories.name as category_name')
                        ->leftJoin("categories","products.category_id","categories.id")
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
             ->on('ratings.product_id', '=', 'comments.product_id'); // ✅ FIX HERE
    })
    ->orderBy('comments.created_at', 'desc')
    ->get();


        $stars = number_format(Rating::where("product_id",$id)->avg('count'));

        $userRating = number_format(Rating::where("product_id",$id)->where("user_id",Auth::user()->id)->value("count"));

        return view("user.shop.productDetails",compact("product","products","stars","comments","userRating"));
    }

    //create rating
    public function rating(Request $request){
        // dd($request->toArray());
        Rating::updateOrCreate([
            'user_id' => Auth::user()->id,
            'product_id' => $request->productId
        ],[
            "product_id" => $request->productId,
            "user_id" => Auth::user()->id,
            "count" => $request->productRating
        ]);

        return back()->with("rate","Thanks for your feedback!");
    }

    //create comment
    public function createComment(Request $request){
        // dd($request->toArray());
        $request->validate([
            "message" => "required"
        ]);

        Comment::create([
            "product_id" => $request->productId,
            "user_id" => Auth::user()->id,
            "message" => $request->message
        ]);

        return back()->with("comment","Your review has been submitted!");
    }

    //direct to cart page
    public function cart(){
        $cart = Cart::select('carts.id as cart_id','carts.qty','products.id as product_id','products.name','products.price','products.image')
                ->leftJoin('products','carts.product_id','products.id')
                ->where('carts.user_id',Auth::user()->id)
                ->get();

        $total = 0;

        foreach($cart as $item){
            $total += $item->price * $item->qty;
        }

        return view('user.layouts.cart',compact("cart","total"));
    }

    //add to cart
    public function addToCart(Request $request){;
        Cart::create([
            'user_id' => $request->userId,
            'product_id' => $request->productId,
            'qty' => $request->qty
        ]);

        return back()->with("addToCart","Item added to your cart!");
    }

    public function addToCartGet($productId){
        Cart::create([
            'user_id' => Auth::user()->id,
            'product_id' => $productId,
            'qty' => 1
        ]);

        return back()->with("addToCart","Item added to your cart!");
    }

    //cart delete process
    public function cartRemove(Request $request){
       $cartId = $request->cartId;

       Cart::where('id',$cartId)->delete();

       return response()->json([
        'status' => 'success',
        'message' => 'Item removed from cart'
       ],200);
    }

    //temp storage
    public function tempStorage(Request $request){
        $orderTemp = [];

        foreach($request->all() as $item){
            array_push($orderTemp,[
                "user_id" => $item['user_id'],
                "product_id" => $item['product_id'],
                "count" => $item['count'],
                "status" => $item['status'],
                "order_code" => $item['order_code'],
                "finalAmt" => $item['totalAmt']
            ]);
        }

        Session::put('tempCart',$orderTemp);

        return response()->json([
            'status' =>"success",
            'message' => "temp storage success"
        ],200);
    }

    //direct to check out page
    public function checkOutPage(){
        $paymentAcc = PaymentMethod::select("id","account_name","account_number","type")->orderBy("type","asc")->get();
        $orderTemp = Session::get("tempCart");

        // dd($orderTemp);
        return view("user.shop.checkOut",compact("paymentAcc","orderTemp"));
    }

    public function order(Request $request){

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

        if($request->hasFile('payslipImage')){
            $fileName = uniqid().$request->file('payslipImage')->getClientOriginalName();
            $request->file('payslipImage')->move(public_path()."/payslipImage/",$fileName);
            $paymentHistoryData['payslip_image'] = $fileName;
         }

         PaymentHistory::create($paymentHistoryData);

        foreach($orderTemp as $item){
            Order::create([
                'product_id' => $item['product_id'],
                'user_id' => $item['user_id'],
                'count' => $item['count'],
                'status' => $item['status'],
                'order_code' => $item['order_code']
            ]);

            Cart::where('user_id',$item['user_id'])->where('product_id',$item['product_id'])->delete();
        }

        return to_route("user#orderList")->with("order","Your order has been placed.");
    }

    //direct to orderList
    public function orderList(){
        $orderList = Order::where("user_id",Auth::user()->id)
                        ->groupBy("order_code")
                        ->orderBy("created_at","desc")
                        ->paginate(5);

        return view('user.shop.orderList',compact('orderList'));
    }

    //direct to order details
    public function orderDetails($orderCode){
        $order = Order::select('products.id as product_id','products.name as product_name','products.image','products.price','products.stock','orders.id as order_id','orders.user_id','orders.count as order_count','orders.order_code','orders.created_at')
                ->leftJoin('products','orders.product_id','products.id')
                ->where('orders.order_code',$orderCode)
                ->get();

        $paymentHistory = PaymentHistory::select('payment_histories.*','payment_methods.type as payment_type')
                            ->leftJoin('payment_methods','payment_methods.id','payment_histories.payment_method')
                            ->where('order_code',$orderCode)->first();

        return view("user.shop.orderDetails",compact("order","paymentHistory"));
    }

}
