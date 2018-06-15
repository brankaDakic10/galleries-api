<?php

namespace App\Http\Controllers;
use Tymon\JWTAuth\Facades\JWTAuth;
use Symfony\Component\HttpFoundation\JsonResponse;
use Illuminate\Http\Request;
use Validator;
use App\Comment;
use App\User;
use App\Gallery;

class CommentsController extends Controller
{
    public function store(Request $request,$gallery_id)
    { 
       $user = JWTAuth::parseToken()->authenticate(); 
       $gallery = Gallery::find($gallery_id);

       $comment=new Comment();
       $validator = Validator::make($request->all(), [
          
           'content' => 'required|max:1000',
           
           ]);
       if ($validator->fails()) {
           return new JsonResponse($validator->errors(), 400);
       }

   
        $comment->content=$request->input('content');
        
        $comment->user_id= $user->id;
        $comment->gallery_id = $gallery_id;

       $comment->save();
       
       return $comment;
       
    }


    public function destroy($id)
    {
        // $gallery = Gallery::find($gallery_id);
        $comment = Comment::find($id);
     
        $comment->delete();
        return new JsonResponse(true);
    }
}
