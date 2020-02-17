<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Resources\User as UserResource;

class UserController extends Controller
{
    public function store(Request $request){
        return "it works"; 
    }
    
    public function signin(Request $request){
        return "it works";
    }
}
