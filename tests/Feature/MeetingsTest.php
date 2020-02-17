<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Resources\Meeting as MeetingResource;
use App\Http\Resources\MeetingCollection as MeetingCollection;


use App\Meeting;
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
    
}
