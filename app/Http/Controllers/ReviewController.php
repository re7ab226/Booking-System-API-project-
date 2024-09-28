<?php

namespace App\Http\Controllers;

use App\Models\bussines;
use App\Models\reviews;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class ReviewController extends Controller
{
            public function index(){
                $reviews=reviews::paginate(10);
                return response()->json($reviews);
            }


            public function reviews_show($id){
          
                $review = reviews::with('bussines')
                ->where('id',$id)
                ->first();
                // ->paginate(10);
                if (!$review) {
                    return response()->json(['message' => 'No reviews found'], 404);
                }
                return response()->json($review);

            }


            public function store(Request $request)
            {
                $valdation=Validator::make($request->all(),[
                    'reviews'=>'required',
                    'stars'=>'required',
                    'bussines_id'=>'required'

                ]);
                if($valdation->fails()){
                    return response()-> json($valdation->errors()->toJson(),400);
                }
              
                $review=  new reviews();
                $review->reviews=$request->reviews;
                $review->stars=$request->stars;
                $review->bussines_id=$request->bussines_id;
                $review->user_id=Auth::id();
                $review->save();
                return response()->json('The Review Created');
            
            
            }
            public function update(Request $request,$id){
                $valdation=Validator::make($request->all(),[
                    'reviews'=>'',
                    'stars'=>'',
                    'bussines_id'=>''

                ]);
                if($valdation->fails()){
                    return response()-> json($valdation->errors()->toJson(),400);
                }
                $review=reviews::find($id);
                $review->reviews=$request->reviews;
                $review->stars=$request->stars;
                $review->bussines_id=$request->bussines_id;
                $review->user_id=Auth::id();
                $review->save();
                return response()->json('The Review Updated');

            }

            public function delete($id){
                $review=reviews::find($id);
                if(!$review){
                    return response()->json('No Data Found');
            }
            $review->delete();
            return response()->json('Review Deleted Sussfully');

        }

}
