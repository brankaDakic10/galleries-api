<?php

namespace App\Http\Controllers;
use Tymon\JWTAuth\Facades\JWTAuth;
use Symfony\Component\HttpFoundation\JsonResponse;
use Illuminate\Http\Request;
use App\User;
use App\Gallery;
use App\Image;
use App\Comment;

use Validator;


class GalleriesController extends Controller
{
    public function index(Request $request) 
    {
        $galleries = Gallery::with([
          'images',
            'user',
            'comments'
         ])->get();
       
        return $galleries;
    }

    public function show($id)
    {
        $gallery= Gallery::with([
            
            'images' => function($query){
                $query->orderBy('order');
              },
            'user',
            'comments',
            'comments.user'
            
        ])->find($id);
        return $gallery;
        
    }

     public function store(Request $request)
         { 
            $user = JWTAuth::parseToken()->authenticate(); 
            
            $gallery=new Gallery();
            $validator = Validator::make($request->all(), [
               
                'title' => 'required|min:2|max:255',
                'description' => 'max:1000',
                'images' => 'required',
               'images.*.imageUrl' => ['regex:/^(http)?s?:?(\/\/[^\']*\.(?:png|jpg|jpeg))/']
                ]);
            if ($validator->fails()) {
                return new JsonResponse($validator->errors(), 400);
            }

        
             $gallery->title=$request->input('title');
             $gallery->description=$request->input('description');
             $gallery->user_id= $user->id;
            //  $gallery->user_id = \JWTAuth::user()->id; 

            $gallery->save();
            
            $allImages = $request->input('images');
            //var_dump($allImages);

            
             $images = [];
                    $i = 0;
                    foreach($allImages as $image){
                        $newImage = new Image();
                        $newImage->gallery_id = $gallery->id;
                        $newImage->imageUrl = $image['imageUrl'];
                        $newImage->order = $i;
                        $newImage->save();
                    
                        $i++;
                    }
            
                    $gallery->images()->saveMany($images);

                   
                        // $message='Success! Saved pictures!';
                        // return new JsonResponse( $message, 200);

                  
                    return $gallery;
            
         }
         public function update(Request $request, $id)
         {
            
            $user = JWTAuth::parseToken()->authenticate();  
            $gallery=Gallery::find($id);
            $gallery->title=$request->input('title');
            $gallery->description=$request->input('description');
            $gallery->user_id= $user->id;
  
            
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
