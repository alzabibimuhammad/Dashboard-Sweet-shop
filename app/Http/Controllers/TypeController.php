<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Type;
use App\Models\Sale;
use Illuminate\Support\Facades\File;
// use Illuminate\Support\Facades\DB;

class TypeController extends Controller
{
    public function index(){

        $index = Type::orderBy('created_at', 'desc')->get();

        if(request('term')==null){
        if ($index ->isEmpty())
            $index = collect();
        return view('types',compact('index'));

        }
        else{
            $term = request()->query('term','');

            $typeSearch=Type::search($term)->get();

            return view('types')->with('index',$typeSearch);

        }

    }


    function DelType(){
        if(request('term')==null){

        $DelType = Type::onlyTrashed()->orderBy('deleted_at', 'desc')->get();
        return view('delType',compact('DelType'));
        }
        else{
            $term = request()->query('term','');

            $typeSearch=Type::search($term)->onlyTrashed()->get();

            return view('delType')->with('DelType',$typeSearch);

        }
    }


    public function Delete(Request $request){
        $id = Type::find($request->input('id'));
        $id->delete();
        return response()->json('Deleted', 200);
    }
    function undeleteType(Request $request){
        $undeleteType= Type::withTrashed()->where('id',$request->input('id'))->restore();
        if($undeleteType)
            return response()->json("Successfully Restored",200);
        else
            return response()->json("Error",404);
    }

    public function saveType(Request $request){
        $type = new Type();
        $type->name = $request->input('name');
        $type->price = $request->input('price');
        $image = $request->file('image');

        if ($image && $image->isValid()) {
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $path=$image->move(public_path('types'), $imageName);
            $type->image='types/'.$imageName;
        }
        else
            $type->image = 'types/empty_image2.jpg';
        $type->save();
        return redirect()->back();
    }


    function editType(Request $request){

        $data = $request->all();
        unset($data['_token']);
        $product = Type::where('id', $data['id'])->first();
        $arr = (array)$product;

        if ($arr){
            $image = $request->file('image');
            if ($image && $image->isValid()) {
                $imageName = time().'.'.$image->getClientOriginalExtension();
                $path=$image->move(public_path('types'), $imageName);
                $filePath = public_path($product->image);
                if($product->image != 'types/empty_image2.jpg')
                if (File::exists($filePath))
                    File::delete($filePath);
                $data['image']='types/'.$imageName;
            }
            else
                $data['image'] = $product->image;

            $product->name = $data['type'];
            $product->price = $data['price'];
            $product->image = $data['image'];

            $product->save();
            return redirect()->back();
            } else {
                return response()->json(['message' => 'Product not found'], 404);
            }

        }


        function typeProfile(){
            $typeProfile = Type::where('id',request('id'))->get();
            $sales = Sale::where('type_id',request('id'))->orderBy('created_at', 'desc')->get();
            $count = count($sales);
            $total =0;
            foreach($sales as $sale)
                $total = $total + $sale->price;
            return view('typeProfile',compact('typeProfile','count','sales','total'));

        }
    }

