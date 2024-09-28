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
        ->paginate();
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
            
            'price'=>'required',
            'time' => '',

        ]);
        if ($validation->fails() ){
            return response()-> json($validation->errors()->toJson(),400);
        }
        // $service = Service::where('user_id', Auth::id())->first(); 
        // if (!$service) {
        //     return response()->json(['message' => 'No service found for this user'], 404);
        // }
        $Booking= new Booking();
        $Booking->time=$request->time;
        $Booking->user_id=Auth::id();
        $Booking->price=$request->price;
        $Booking->services_id=$request->services_id;
        $Booking->save();
        return response()->json(['message' => 'Booking added successfully', 'booking' => $Booking]);

    }

}
