<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    public function store( Request $request){
                $valdiation=validator::make($request->all(),[
                    'name' => 'required',
                    'email' =>'required',
                    'role'=>'required',
                    'password' =>'required',
                ]);
                if ($valdiation->fails()) {
                    return response()->json([
                        'errors' => $valdiation->errors()
                    ], 400);
                }
                User::create(array_merge(
                    $valdiation->validated(),
                    ['password' => bcrypt($request->password)]
                ));

   return response()->json([
        'message' => 'User is added successfully!'
    ], 201);
    }


    public function destroy($id)
    {
        $user = User::find($id);
    
        if (!$user) {
            return response()->json([
                'message' => 'User not found',
            ], 404);
        }
    
        $user->delete();
    
        return response()->json([
            'message' => 'User deleted successfully',
        ], 200); 
    }
    
}
