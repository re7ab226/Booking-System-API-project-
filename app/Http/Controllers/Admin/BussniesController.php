<?php

namespace App\Http\Controllers\Admin;

use App\Models\bussines;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Validated;

class BussniesController extends Controller
{
    public function index(){
        $Bussnies=bussines::paginate(10);
        return response()->json($Bussnies);
        }
        public function show($id){
            $Bussnies=bussines::find($id);
            return response()->json($Bussnies);
        }



        public function create(Request $request)
        {


    if (!Auth::check()) {
        return response()->json([
            'message' => 'Authentication failed. Please ensure you are logged in and sending the correct token.',
            'auth_status' => Auth::check(),
            'user' => Auth::user(),
        ], 401);  
    }
        
            if (Auth::user()->role !== 'admin') {
                return response()->json([
                    'message' => 'You do not have permission to create a business.'
                ], 403); 
            }
        
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'status' => 'required|string',
                'Opining_hours' => 'required|string',
            ]);
        
            $bussines = new Bussines();
            $bussines->name = $validated['name'];
            $bussines->status = $validated['status'];
            $bussines->Opining_hours = $validated['Opining_hours'];
            $bussines->user_id = Auth::id(); 
            $bussines->save();
        
            // Return success response
            return response()->json([
                'data' => $bussines,
                'message' => 'Business created successfully!'
            ], 201);  // 201 Created status
        }

        public function update($id, Request $request){

            if(!Auth ::check()){
                return response()->json(['message you can`t acess login first']);
            }

            if(Auth::user()->role !== 'admin'){
                return response()->json(['message'=>'your are not admin']);
            }
            $Bussnies=bussines::find($id);
            if(!$Bussnies){
                return response()->json(['message'=>'no thing found']);
            }
             $validated = $request->validate([
                'name' => 'required|string|max:255',
                'status' => 'required|string',
                'Opining_hours' => 'required|string',
            ]);

            $Bussnies->update([
                'name' => $validated['name'],
                'status' => $validated['status'],
                'Opining_hours' => $validated['Opining_hours'],
              
                'user_id' => Auth::id(),
                
            ]);
            return response()->json($Bussnies);

        }
        public function delete($id){

            if (!Auth::check()){
                return response()->json(['login First']);
            }
            if(Auth::user()->role !=='admin'){
                return response()->json('you are n`t admin');
            }
            $Bussnies=bussines::find($id);
            if(!$Bussnies){
                return response()->json(['message'=>'no thing found']);
            }
            $Bussnies->delete();
            return response()->json(['message'=>'done']);
        }
}
