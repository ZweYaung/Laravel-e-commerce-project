<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    //direct to payment method page
    public function payment(){
        $payments = PaymentMethod::paginate(5);

        return view("admin.payment.list",compact('payments'));
    }

    //create payment
    public function create(Request $request){
        $this->checkValidation($request);

        $data = [
            'account_number' => $request->accountNumber,
            'account_name' => $request->accountName,
            'type' => $request->accountType
        ];

        PaymentMethod::create($data);

        return back()->with("create","Payment method created successfully!");
    }

    //delete payment
    public function delete($id){
        PaymentMethod::where('id',$id)->delete();
        return back()->with("delete","Payment method deleted successfully!");
    }

    //edit page
    public function edit($id){
        $payment = PaymentMethod::where('id',$id)->first();
        return view('admin.payment.edit',compact('payment'));
    }

    //update payment
    public function update(Request $request,$id){
        $this->checkValidation($request);

        PaymentMethod::where('id',$id)->update([
            'account_number' => $request->accountNumber,
            'account_name' => $request->accountName,
            'type' => $request->accountType
        ]);

        return to_route("admin#payment")->with("update","Payment method updated successfully!");
    }

    //check validation
    private function checkValidation($request){
        $request->validate([
            'accountNumber' => 'required|min:5|max:30|unique:payment_methods,account_number,'.$request->id,
            'accountName' => 'required',
            'accountType' => 'required'
        ]);
    }
}
