<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Resources\Meeting as MeetingResource;
use App\Http\Resources\MeetingCollection as MeetingCollection;
use App\User;
use App\Meeting;
use JWTAuth;
class MeetingsTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    
    /** @test*/
    public function view_all_meetings()
    {
        $meetings = new MeetingCollection(factory(Meeting::class,5)->create());
        
        foreach($meetings as $meeting){
            $response=$this->get('api/v1/meeting')
                ->assertSee($meeting->title);
        }
        
        $response->assertStatus(200);
        $this->assertEquals(5,$meetings->count());
    }
    
    /** @test */
    public function view_single_meeting(){
        $meeting = new MeetingResource(factory(Meeting::class)->create());
        $response=$this->get("api/v1/meeting/{$meeting->id}")
            ->assertSee($meeting->title,$meeting->description);
        $response->assertStatus(200);
    }
    
    /** @test */
    public function an_authorized_user_can_create_meeting(){
        $meeting=factory(Meeting::class)->create();
        $user=factory(User::class)->create();
        $token = JWTAuth::fromUser($user);
        $response=$this->post("/api/v1/meeting/?token=".$token,$meeting->toArray())
            ->assertStatus(201);
    }
    
    /** @test */
    public function an_authorized_user_can_update_meeting(){
        $meeting=new MeetingResource(factory(Meeting::class)->create());
        $user=factory(User::class)->create();
        $meeting->users()->attach($user);
        $title="kola bola";
        $desc='lorem ipsum jipsum';
        $token = JWTAuth::fromUser($user);
        $response=$this->withExceptionHandling()->actingAs($user)->patch("api/v1/meeting/{$meeting->id}/?token=".$token,['title'=>$title,'description'=>$desc])
            ->assertStatus(201);
    }
    
     /** @test */ 
    public function an_authorized_user_can_delete_meeting(){
       $meeting=new MeetingResource(factory(Meeting::class)->create());
        $user=factory(User::class)->create();
        $meeting->users()->attach($user);
        $token = JWTAuth::fromUser($user);
        $response=$this->withoutExceptionHandling()->actingAs($user)->delete("api/v1/meeting/{$meeting->id}/?token=".$token)->
            assertStatus(200);
    }
    
}
