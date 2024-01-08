<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\People;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function index(){



        $team     = People::all();
        $payments = Payment::orderBy('created_at', 'desc')->get();
        $totalPrice = 0;

        if(request('term')==null){

        if ($payments->isEmpty()) {
            $payments = collect();
        }
        else
            foreach ($payments as $pay){
                $pay->team = People::where('id',$pay->team_id)->withTrashed()->get();
                $totalPrice = $totalPrice + $pay->mony;

        }
        return view('payments')->with('team',$team)->with('payments',$payments)->with('total',$totalPrice);
    }

    else{
        $term = request()->query('term','');
        $paymentsSearch=Payment::search($term)->get();
        // return $paymentsSearch;
        if(count($paymentsSearch)!=0){
            foreach($paymentsSearch as $pay){
                $pay->team = People::where('id',$pay->team_id)->withTrashed()->get();
                $totalPrice = $totalPrice + $pay->mony;
            }
            return view('payments')->with('team',$team)->with('payments',$paymentsSearch)->with('total',$totalPrice);
        }
        else{
            foreach($payments as $pay){
                $pay->team = People::where('id',$pay->team_id)->withTrashed()->get();
                $totalPrice = $totalPrice + $pay->mony;
            }
            return view('payments')->with('team',$team)->with('payments',$payments)->with('total',$totalPrice);
        }
    }
}


    function Add(Request $request){
        $payment = new Payment();

        $checkTeam = People::where('id',$request->input('team_id'))->get();

        if(count($checkTeam)!=0)
            $payment->team_id = $request->input('team_id');
        else{
            $teamId = People::where('name',$request->input('team_id'))->first();
            $payment->team_id = $teamId->id;
        }
        $payment->mony = $request->input('mony');

        if($request->input('reason') == null)
            $payment->reason = "None";
        else
            $payment->reason = $request->input('reason');

        $payment->save();
    }
    function del($id){
        $del = Payment::find($id);
        $del->delete();
        return response()->json('Deleted',200);
    }
    function fetchPaymentData() {
        $team = People::all();
        $payments = Payment::all();

        // Check if payments data is empty
        if ($payments->isEmpty()) {
            return response()->json([], 200); // Return an empty JSON array
        } else {
            foreach ($payments as $pay) {
                $people = People::where('id', $pay->team_id)->get();
                $pay->name = $people[0]->name;
            }

            return response()->json($payments, 200);
        }
    }

    function editPay(Request $request){
        $pay =  Payment::where('id',$request->input('payment_id'))->first();

        $pay->team_id = $request->input('team_id');

        if($request->input('mony')!=0)
            $pay->mony = $request->input('mony');

        if($request->input('reason'))
            $pay->reason = $request->input('reason');

        $pay->save();

        return response()->json('Saved', 200);


    }

}

