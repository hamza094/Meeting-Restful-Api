<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Meeting;
use App\Http\Resources\Meeting as MeetingResource;
use App\Http\Resources\MeetingCollection as MeetingCollection;

class RegistrationController extends Controller
{
      /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
     {
     $this->validate($request, [
            'meeting_id' => 'required',
            'user_id' => 'required',
        ]);

        $meeting_id = $request->input('meeting_id');
        $user_id = $request->input('user_id');

        $meeting = Meeting::findOrFail($meeting_id);
        $user = User::findOrFail($user_id);

        $message = [
            'msg' => 'User is already registered from meeting',
            'user' => $user,
            'meeting' => $meeting,
            'unregister' => [
                'href' => '/api/v1/meeting/registration/' . $meeting->id,
                'method' => 'DELETE',
            ]
        ];
        if ($meeting->users()->where('users.id', $user->id)->first()) {
            return response()->json($message, 404);
        };

        $user->meetings()->attach($meeting);

        $response = [
            'msg' => 'User registered for meeting',
            'meeting' => $meeting,
            'user' => $user,
            'unregister' => [
                'href' => '/api/v1/meeting/registration/' . $meeting->id,
                'method' => 'DELETE'
            ]
        ];

        return response()->json($response, 201);
    }
    
        /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
     
        $meeting=Meeting::findOrFail($id);
        
         if(! $user=JWTAuth::parseToken()->authenticate()){
            return response()->json(['msg'=>'User not found'],404);
        }
          if(!$meeting->users()->where('users.id',$user->id)->first()){
            return response()->json(['msg'=>'users not registered for meeting,update not successfull'],401);
        }
        $users=$meeting->users;
        $meeting->users()->detach();
        if(!$meeting->delete()){
            foreach($users as $user){
                $meeting->users()->attach($user);
            }
            return response()->json(['msg'=>'deletion failed'],404);
        }
        $response=[
          'msg'=>"Message deleted",
            'create'=>[
            'method'=>"POST",
            'params'=>'description,time'
                ]
        ];
        return response()->json($response,200);
    }
}
