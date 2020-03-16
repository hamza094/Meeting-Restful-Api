<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Meeting;
use JWTAuth;

class UsersTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    
    /** @test */
    public function create_user(){
        $name='ali';
        $email='hamza_pisces@live.com';
        $password='abrakadabra';
        $response=$this->post("/api/v1/users",['name'=>$name,'email'=>$email,'password'=>$password])
            ->assertStatus(201);
         $response=$this->post("/api/v1/users",['name'=>$name,'email'=>$email,'password'=>$password])
            ->assertStatus(500);
    }
    
    
    /** @test */
    public function register_user_for_meeting(){
        $admin=factory(User::class)->create();
        $user1=$this->actingAs($admin);
        $meeting=factory(Meeting::class)->create();
        $user=factory(User::class)->create();
        $response=$this->post("/api/v1/meeting/registration",['meeting_id'=>$meeting->id,'user_id'=>$user->id])
        ->assertStatus(201);
        $this->assertEquals($meeting->id,$user->meetings()->first()->id);
    }
    
    /** @test */
    public function unRegister_user_for_meeting(){
        $user=factory(User::class)->create();
        $meeting=factory(Meeting::class)->create();
        $user->meetings()->attach($meeting);
        $meeting2=factory(Meeting::class)->create();
        $user->meetings()->attach($meeting2);
        $this->assertTrue($meeting->id==$user->meetings()->first()->id);
        $token = JWTAuth::fromUser($user);
        $response=$this->delete("/api/v1/meeting/registration/{$meeting->id}/?token=".$token,
        ['meeting_id'=>$meeting->id,'user_id'=>$user->id])
        ->assertStatus(200);
        $this->assertTrue($meeting2->id==$user->meetings()->first()->id);
    }
    
    /** @test */
    public function test_login_success(){
        $user=factory(User::class)->create([
            'name'=>"thomas",
            'email'=>"thanos_gemini@gmail.com",
            'password'=>bcrypt("run thomas run")
        ]);
        $response=$this->post('/api/v1/login',['email'=>'thanos_gemini@gmail.com','password'=>'run thomas run'])
            ->assertStatus(200);
    }
    
 
}
