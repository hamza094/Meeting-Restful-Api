<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Meeting;
use App\Http\Resources\Meeting as MeetingResource;
use App\Http\Resources\MeetingCollection as MeetingCollection;
use Illuminate\Support\Facades\Auth;
use JWTAuth;
class MeetingController extends Controller
{
 public function __construct()
    {
        $this->middleware('auth:api',['only' => ['store','update','delete']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $meetings=new MeetingCollection(Meeting::all());
        
            $response=[
                'msg'=>'List of all meetings',
                'meetings'=>$meetings
            ];
            
            return response()->json($response,200);
        
         
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
        $this->validate($request,[
           'title'=>'required',
            'description'=>'required',
                        
        ]);
        
          if(! $user=JWTAuth::parseToken()->authenticate()){
            return response()->json(['msg'=>'User not found'],404);
        }
        
      $title=$request->input('title');
      $description=$request->input('description');
      $user_id=$user->id;
        
        $meeting=new MeetingResource(Meeting::create([
           'title'=>$title,
            'description'=>$description,
        ])
        );
        if($meeting->save()){
            $meeting->users()->attach($user_id);
        }
 
        
        $message=[
            'msg'=>'Meeting Created',
            'meeting'=>$meeting,
        ];
        
        return response()->json($message,201);
        
         
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $meeting=new MeetingResource(Meeting::where('id',$id)->firstOrFail());
        $user=$meeting->users;   
        $message=[
            'msg'=>'Meeting Information',
            'meeting'=>$meeting,
            'meeting_users'=>$user
        ];
        
        return response()->json($message,200);
        
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
     
         $this->validate($request,[
           'title'=>'required',
            'description'=>'required',
                        
        ]);
        
         if(! $user=JWTAuth::parseToken()->authenticate()){
            return response()->json(['msg'=>'User not found'],404);
        }
        
        $title=$request->input('title');
        $description=$request->input('description');
        $user_id=$user->id;

                
      $meeting=new MeetingResource(Meeting::findOrFail($id));
        
        if(!$meeting->users()->where('users.id',$user_id)->first()){
            return response()->json(['msg'=>'users not registered for meeting,update not successfull'],401);
        }
        
        $meeting->title=$title;
        $meeting->description=$description;
        
        if(!$meeting->update()){
            return response()->json(['msg'=>'Error during updating'],404);
        }
        
        $response=[
            'msg'=>'meeting updated successfully',
            'meeting'=>$meeting
            ];
        
        return response()->json($response,201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
          $meeting=new MeetingResource(Meeting::findOrFail($id));
        
        if(! $user=JWTAuth::parseToken()->authenticate()){
            return response()->json(['msg'=>'User not found'],404);
        }
        
        if(!$meeting->users()->where('users.id',$user->id)->first()){
            return response()->json(['msg'=>'users not registered for meeting,update not successfull'],401);
        }
       
        $meeting->users()->detach();
        
        if(!$meeting->delete()){
            return response()->json(['msg'=>'deletion failed'],404);
        }
        
    $response=[
          'msg'=>"Meeting deleted",
            'create'=>[
            'method'=>"POST",
            'params'=>'description,title'
        ]
        ];
        
        return response()->json($response,200);
    }
}
