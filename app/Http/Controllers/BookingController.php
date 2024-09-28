<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\service;
use GuzzleHttp\Psr7\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    public function index(){
        $Booking=Booking::where('user_id',Auth::id())
        ->with('services')
        ->paginate(10);
        return response()->json($Booking);
    }

    public function show($id){
     
        $Booking = Booking::with('services')
        ->where('id',$id)
        // ->where('user_id', Auth::id())
        // ->get()
        ->first()
      ;

        if (!$Booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }
        return response()->json($Booking);

    }
    
    public function store(Request $request){
        if(!Auth::check()){
            return response()->json('Login first');
        }
        $validation= Validator::make($request->all(),[
            
            'price' => 'required|numeric',
            'time' => 'required|date_format:Y-m-d H:i:s',
        ]);
        if ($validation->fails() ){
            return response()-> json($validation->errors()->toJson(),400);
        }
        $Booking= new Booking();
        $Booking->time=$request->time;
        $Booking->user_id=Auth::id();
        $Booking->price=$request->price;
        $Booking->services_id=$request->services_id;
        $Booking->save();
        return response()->json(['message' => 'Booking added successfully', 'booking' => $Booking]);

    }
    public function update(Request $request ,$id){
        if(!Auth::check()){
            return response()->json('Login first');
        }
        $validation= Validator::make($request->all(),[
            
            'price' => 'numeric',
            'time' => 'date_format:Y-m-d H:i:s',
        ]);

        if ($validation->fails() ){
            return response()-> json($validation->errors()->toJson(),400);
        }
        $Booking=Booking::find($id);
            if(!$Booking){
                return response()->json('no data found');
            }
                    $Booking->time=$request->time;
        $Booking->user_id=Auth::id();
        $Booking->price=$request->price;
        // $Booking->services_id=$request->services_id;
        $Booking->save();
        return response()->json(['message' => 'Booking Updated successfully', 'booking' => $Booking]);


    }

public function delete($id) {
    $Booking=Booking::find($id);
    if(!$Booking){
        return response()->json('No data  found');

    }
    $Booking->delete();
    return response()->json('The Item Deleted Sussfully');
    
}
}
