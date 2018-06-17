<?php

namespace App\Http\Controllers;
use Tymon\JWTAuth\Facades\JWTAuth;


use Illuminate\Http\Request;
use App\Gallery;
use App\User;
class UsersController extends Controller
{
    // author of gallery
    public function show($id)
    {
        
        $user = User::with([
            
            'galleries.images',
            
            'comments'
            
            ])->find($id);
            
            return  $user ;
            
        }
        
        
        
    }
