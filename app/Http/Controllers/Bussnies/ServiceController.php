<?php

namespace App\Http\Controllers\Bussnies;

use App\Models\service;
use App\Models\bussines;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{

    public function index(){
        $Bussines = bussines::where('user_id', Auth::id())->first();
        if (!$Bussines) {
            return response()->json(['message' => 'No business found for this user'], 404);
        }
       
        $service = service::where('bussines_id', $Bussines->id)->paginate(10);

        return response()->json($service);



    }



    public function show($id){
        $Bussines = bussines::where('user_id', Auth::id())->first();
        if (!$Bussines) {

            return response()->json(['message' => 'No business found for this user'], 404);
        }
        $service = Service::where('id', $id)->where('bussines_id', $Bussines->id)->first();
                if (!$service) {
        return response()->json(['message' => 'Service not found or does not belong to this business'], 404);
    }
    return response()->json($service);

    }
    
    public function store(Request $request) {

        $validation=Validator::make($request->all(),[
            'name' => 'required|string',
            'price' => 'required|numeric',
            'description' => 'nullable|string'
        ]);
        if ($validation ->fails()){
            return response()->json($validation->errors()->toJson(),400);
        }
        $Bussines = bussines::where('user_id', Auth::id())->first();
        if (!$Bussines) {
            return response()->json(['message' => 'No business found for this user'], 404);
        }
    
        $service=new service();
        $service->name= $request->name;
       // $service->bussines_id=$request->bussines_id;
        $service->bussines_id = $Bussines->id; 
        $service->price=$request->price;
        $service->description=$request->description;
        $service->save();
        return response()->json('service  is added');
        
    }
    public function update(Request $request,$id){

        $validation=Validator::make($request->all(),[
            'name' => 'string',
            'price' => 'numeric',
            'description' => 'nullable|string'
        ]);
        if ($validation ->fails()){
            return response()->json($validation->errors()->toJson(),400);
        }

        $Bussines = bussines::where('user_id', Auth::id())->first();
        if (!$Bussines) {
            return response()->json(['message' => 'No business found for this user'], 404);
        }

        $service = service::find($id);
        if (!$service) {
            return response()->json(['message' => 'Service not found'], 404);
        }
    
        $service->name = $request->name;
                // $service->bussines_id = $Bussines->id; 
                $service->price = $request->price;
                $service->description = $request->description;
                $service->save();
    return response()->json('Service is updated successfully');
    }

    public function delete($id){
     
        $service=service::find($id);
        if(!$service){
            return response()->json(['message'=>'no service found']);
        }
        $Bussines = bussines::where('user_id', Auth::id())->first();
        if (!$Bussines) {
            return response()->json(['message' => 'No business found for this user'], 404);
        }
        if ($service->bussines_id !== $Bussines->id) {
            return response()->json(['message' => 'You do not have permission to delete this service'], 403);
        }
        $service->delete();
        return response()->json('service is deleted sussfully');

    }

}
