<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Type;
use App\Models\Sale;

class SaleController extends Controller
{
    public function index(){
        $products = Type::all();
        $sales =  Sale::orderBy('created_at', 'desc')->get();
        $totalPrice = 0;

        if(request('term')==null){

        if ($products->isEmpty()) {
            $products = collect();
        }

        foreach($sales as $sale){
            $sale->type = Type::where('id',$sale->type_id)->withTrashed()->get();
            $totalPrice = $totalPrice + $sale->price;
        }


        // return $sales;
        return view('sales')->with('products',$products)->with('sales',$sales)->with('total',$totalPrice);
    }
   else{
        $term = request()->query('term','');
        $salesSearch=Sale::search($term)->get();

        if(count($salesSearch)!=0){
            foreach($salesSearch as $sale){
                $sale->type = Type::where('id',$sale->type_id)->withTrashed()->get();
                $totalPrice = $totalPrice + $sale->price;
            }

            return view('sales')->with('products',$products)->with('sales',$salesSearch)->with('total',$totalPrice);
        }
        else{
            foreach($sales as $sale){
                $sale->type = Type::where('id',$sale->type_id)->withTrashed()->get();
                $totalPrice = $totalPrice + $sale->price;

            }
            return view('sales')->with('products',$products)->with('sales',$sales)->with('total',$totalPrice);
        }
    }
    }

    public function Add(Request $request){
        $data = $request->all();
        $typePrice = Type::where('id',$data['type_id'])->get('price');
        $sale = new Sale();
        $sale->name      = $data['name'];
        $sale->type_id   = $data['type_id'];
        $sale->amount    = $data['amount'];
        $sale->price     = floatval($data['amount']) * $typePrice[0]->price;

        $sale->save();
        return response()->json('succ', 200);

    }
    function Del($id){
        $delete = Sale::find($id);
        $delete->delete();
        return response()->json('Deleted',200);
    }
    function Update($id,Request $request){
        $req = $request->all();

        if($req['amount']!=null){
            $update = Sale::where('id',$id)->first('price');
            $NewPrice = $update->price * $req['amount'];
            $req['price'] = $NewPrice;
        }

        foreach ($req as $key => $value) {
            if (empty($value)) {
                unset($req[$key]);
            }
        }

        $update = Sale::where('id',$id)->update($req);
        return response()->json('Updated', 200);
    }


    function searchPartHeader(Request $req)
    {
        $term = $req->query('term','');
        $parts=Part::search($term)->with('category')->with('seller')->with('model')->get();
        if(count($parts)!=0){
            foreach($parts as $dat){
                $type_id=Car::where('id',$dat->model_id)->get('type_id');
                $type_name=CarType::where('id',$type_id[0]->type_id)->get('type');
                $dat->type=$type_name[0]->type;
            }
            return response()->json($parts);
        }

        else{
            $parts=Part::where('deleted_at')->with('category')->with('seller')->with('model')->get();
            foreach($parts as $dat){
                $type_id=Car::where('id',$dat->model_id)->get('type_id');
                $type_name=CarType::where('id',$type_id[0]->type_id)->get('type');
                $dat->type=$type_name[0]->type;
            }
            return response()->json($parts);
        }

    }
}
