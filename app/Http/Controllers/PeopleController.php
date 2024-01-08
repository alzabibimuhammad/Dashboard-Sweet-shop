<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\People;
use Illuminate\Support\Facades\File;
use App\Models\Payment;


class PeopleController extends Controller
{

    public function index(){
        $team = People::all();
        if(request('term')==null){

        if ($team->isEmpty()) {
            $team = collect();
        }
        return view('team', compact('team'));
    }
    else{
        $term = request()->query('term','');
        $typeSearch=People::search($term)->get();
        return view('team')->with('team',$typeSearch);
    }
}
    function Add(){
        return view('AddTeam');
    }

    function save(Request $request){
        $people = new People();
        $people->name = $request->input('name');

        $image = $request->file('image');
        if ($image && $image->isValid()) {
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $path=$image->move(public_path('team'), $imageName);
            $people->image='team/'.$imageName;
        }
        else
            $people->image = 'team/empty_image.jpg';
        $people->save();
        return redirect()->back();
    }

    public function Delete(Request $request){
        $id = People::find($request->input('id'));
        $id->delete();
        return response()->json('Deleted', 200);
    }



    public function DelTeam(){
        if(request('term')==null){

        $DelTeam = People::onlyTrashed()->orderBy('deleted_at', 'desc')->get();
        return view('delTeam',compact('DelTeam'));

        }
        else{
            $term = request()->query('term','');
            $typeSearch=People::search($term)->onlyTrashed()->get();

            return view('delTeam')->with('DelTeam',$typeSearch);
        }
    }


    function UnDelTeam(Request $request){
        $undeletePart= People::withTrashed()->where('id',$request->input('id'))->restore();
        if($undeletePart)
            return response()->json("Successfully Restored",200);
        else
            return response()->json("Error",404);

    }

    function editTeam(Request $request){

        $data = $request->all();
        unset($data['_token']);
        $people = People::where('id', $data['id'])->first();
        $arr = (array)$people;

        if ($arr){
            $image = $request->file('image');
            if ($image && $image->isValid()) {
                $imageName = time().'.'.$image->getClientOriginalExtension();
                $path=$image->move(public_path('team'), $imageName);
                $filePath = public_path($people->image);

            if($people->image!='team/empty_image.jpg')
                if (File::exists($filePath))
                    File::delete($filePath);

                $data['image']='team/'.$imageName;
            }
            else
                $data['image'] = $people->image;

            $people->name = $data['name'];
            $people->image = $data['image'];

            $people->save();

            return redirect()->back();
            } else {
                return response()->json(['message' => 'Product not found'], 404);
            }
        }

        function profile(){
            $team = People::where('id',request('id'))->withTrashed()->get();
            $payment = Payment::where('team_id',request('id'))->orderBy('created_at', 'desc')->get();
            $totalPrice = 0;
            foreach($payment as $price){
                $totalPrice = $totalPrice + $price->mony;
            }
            $team[0]->totalPrice = $totalPrice;
            $team[0]->count = count($payment);

            $team[0]->payment = $payment;

            return view('profile',compact('team'));
        }
        public function Delete2(Request $request){
            $id = People::find($request->input('id'));
            $id->delete();
            return redirect('/People'); // Replace '/people' with the desired URL or route

        }

}
