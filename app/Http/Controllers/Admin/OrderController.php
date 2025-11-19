<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\PaymentHistory;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    //direct to order list
    public function orderList(){
        $orderList = Order::select("orders.id","orders.order_code","orders.created_at","orders.status","users.name","users.nickname")
                        ->leftJoin("users","orders.user_id","users.id")
                        ->groupBy("orders.order_code")
                        ->when(request('searchKey'),function($query){
                            $query->whereAny(['orders.order_code',"users.name"], 'like' , '%'.request('searchKey').'%' );
                        })
                        ->paginate(5);


        return view("admin.order.list",compact("orderList"));
    }

    //order details
    public function orderDetails($orderCode){
        $order = Order::select('products.id as product_id','products.name as product_name','products.image','products.price','products.stock','orders.id as order_id','orders.user_id','orders.count as order_count','orders.order_code','orders.created_at')
                ->leftJoin('products','orders.product_id','products.id')
                ->where('orders.order_code',$orderCode)
                ->get();

        $paymentHistory = PaymentHistory::select('payment_histories.*','payment_methods.type as payment_type')
                            ->leftJoin('payment_methods','payment_methods.id','payment_histories.payment_method')
                            ->where('order_code',$orderCode)->first();

        $status = true;

        foreach($order as $item){
            if($item->order_count <= $item->stock){
                $status = true;
            }else{
                $status = false;
                break;
            }
        }

        return view('admin.order.details',compact('order','paymentHistory','status'));
    }

    //order reject
    public function orderReject(Request $request){
        Order::where('order_code',$request->orderCode)->update([
            'status' => 2
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'order rejected'
        ],200);
    }

    //order status change
    public function orderStatusChange(Request $request){
        Order::where('order_code',$request->order_code)->update([
            'status' => $request->status
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'order rejected'
        ],200);
    }

    //order confirm
    public function orderConfirm(Request $request){
        // logger($request->all());
        Order::where('order_code',$request[0]['orderCode'])->update([
            'status' => 1
        ]);

        foreach($request->all() as $item){
            Product::where('id',$item['productId'])->decrement('stock',$item['count']);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'order rejected'
        ],200);
    }

//saleInfo
    public function saleInfo(){
        $saleInfo = Order::where('status',1)->select('users.name as user_name','orders.order_code','orders.status','orders.created_at','users.nickname')
                    ->leftJoin('users','orders.user_id','users.id')
                    ->paginate(5);

        return view('admin.order.saleInfo',compact('saleInfo'));
    }
}
