<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Resources\User as UserResource;
use App\Meeting;
use Auth;


class UserController extends Controller
{
        public function store(Request $request){
        
        $this->validate($request,[
            'name'=>'required',
            'email'=>'required',
            'password'=>'required|min:5'
        ]);
        
            
       $userData = $request->only('name', 'email', 'password');
        
        $userData['password'] = bcrypt($userData['password']);
        User::unguard();
        
       $user = User::create($userData);
        User::reguard();
        
        if($user->save()){
            $user->signin=[
                'href'=>'/api/v1/user/signin',
                'method'=>'POST',
                'params'=>'email,password'
            ];
            
             $response=[
        'msg'=>'User Created',
         'user'=>$user    
        ];
                 
        return response()->json($response,201);         
        }
        
                    $response=[
        'msg'=>'An error occured',
         'user'=>$user    
        ];
       
      return response()->json(404); 
    }
    
 
}
