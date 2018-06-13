<?php

namespace App\Http\Controllers;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;
use App\User;
use App\Gallery;

class MyGalleriesController extends Controller
{
    public function index()
    {
        $user = JWTAuth::parseToken()->authenticate(); 
        
        return Gallery::find($user);
    }
}
