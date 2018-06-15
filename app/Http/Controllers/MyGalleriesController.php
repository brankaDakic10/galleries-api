<?php

namespace App\Http\Controllers;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;
use App\User;
use App\Gallery;
use Illuminate\Support\Facades\Auth;
class MyGalleriesController extends Controller
{
    public function index()
    {
    //     
    //     $user=JWTAuth::parseToken()->authenticate();
    //     return json_decode($user);
    //     // return Gallery::find($user);
        $user = JWTAuth::parseToken()->authenticate();
        $user_id = $user->id;
        $galleries= Gallery::with(['images'])->where('user_id',$user_id)->get();
        return  $galleries;
 
    }
}
