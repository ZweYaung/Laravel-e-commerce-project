<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\PaymentHistory;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    //direct to admin home
    public function home(){
        $totalSaleAmt = PaymentHistory::sum('total_amt');
        $orderCount = Order::whereIn('status',[0,1])->count('status');
        $registerUser = User::where('role','user')->count('id');
        $pendingCount = Order::where('status',[0])->count('id');
        return view('admin.dashboard.main',compact('totalSaleAmt','orderCount','registerUser','pendingCount'));
    }
}
