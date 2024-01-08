<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    function index(){
        $currentDate = date('Y-m-d');

        $sales    = DB::select("SELECT COUNT(id) AS number FROM sales WHERE DATE(created_at) = '".$currentDate."'");
        $payments = DB::select("SELECT COUNT(id) AS number FROM payments WHERE DATE(created_at) = '".$currentDate."'");
        $latestSales = Sale::orderBy('created_at', 'desc')->take(5)->get();
        return view('index')->with('sales', $sales[0]->number)->with('payments', $payments[0]->number)->with('latestSales',$latestSales);
    }

}
