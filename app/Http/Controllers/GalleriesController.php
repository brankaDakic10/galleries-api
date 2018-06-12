<?php

namespace App\Http\Controllers;
use App\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Illuminate\Http\Request;
use App\Gallery;
use Validator;

class GalleriesController extends Controller
{
    public function index(Request $request) 
    {
        return Gallery::all();
    }

    public function show($id)
    {
        
        return Gallery::with('images')->find($id);
    }

     public function store(Request $request)
         {
            $user = User::all()->first();
            // $user = Gallery::with('user')->first();
           
             $gallery=new Gallery();
            
             $gallery->title=$request->input('title');
             $gallery->description=$request->input('description');
             $gallery->user_id= $user->id;
            //  $gallery->user_id=auth()->user()->id;
           
             $gallery->save();
             return $gallery;
         }
         public function update(Request $request, $id)
         {
             $user = User::all()->first();
            $gallery=Gallery::find($id);
            $gallery->title=$request->input('title');
            $gallery->description=$request->input('description');
            $gallery->user_id= $user->id;
            //    $gallery->user_id=auth()->user()->id;
            $gallery->save();
            return $gallery;
         }
    
    
        public function destroy($id)
        {
            $gallery=Gallery::find($id);
            $gallery->delete();
            return new JsonResponse(true);
        }


}
