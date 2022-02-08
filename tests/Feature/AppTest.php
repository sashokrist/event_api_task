<?php

namespace Tests\Feature;

use App\Models\Meet;
use App\Models\Room;
use App\Models\Tire;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class AppTest extends TestCase
{
    public function testRequiresEmailAndLogin()
    {
        $this->json('POST', 'api/login')
            ->assertStatus(422);
    }

    public function testUserLoginsSuccessfully()
    {
        $user = User::create([
                                 'name' => 'Sasho',
                                 'email' => 'sasho@test.com',
                                 'password' => Hash::make('123456')
                             ]);

        $payload = ['name' => 'Sasho', 'email' => 'sasho@test.com', 'password' => '123456'];
        $this->json('POST', 'api/login', $payload)
            ->assertStatus(200)
            ->assertJsonStructure([
                                      'data' => [
                                          'id',
                                          'name',
                                          'email',
                                          'created_at',
                                          'updated_at',
                                          'api_token',
                                      ],
                                  ]);
    }

    public function testRegistersSuccessfully()
    {
        $payload = [
            'name' => 'John2',
            'email' => 'sasho2@test.com',
            'password' => '11111111',
            'password_confirmation' => '11111111',
        ];

        $this->json('post', '/api/register', $payload)
            ->assertStatus(201)
            ->assertJsonStructure([
                                      'data' => [
                                          'id',
                                          'name',
                                          'email',
                                          'created_at',
                                          'updated_at',
                                          'api_token',
                                      ],
                                  ]);;
    }

    public function testMeetIsCreated()
    {
        $meet = Meet::create([
            'name' => 'new meet'
                             ]);
        $room = new Room();
        $room->meet_id = $meet->id;
        $room->room_name = 'room 1';
        $room->meet_date = '2021:12:01';
        $room->start = '10:00';
        $room->end = '11:00';
        $room->save();
        $meet = Meet::with('room')->where('id', $meet->id)->orderByDesc('created_at')->first();
        $arrays[] = $meet->toArray();
        $this->assertTrue(true);
    }

    public function testUserCanReadAllMeets()
    {
        $meet = Meet::create([
                                 'name' => 'new meet'
                             ]);
        $room = new Room();
        $room->meet_id = $meet->id;
        $room->room_name = 'room 1';
        $room->meet_date = '2021:12:01';
        $room->start = '10:00';
        $room->end = '11:00';
        $room->save();
        $meet = Meet::with('room')->where('id', $meet->id)->orderByDesc('created_at')->first();
        $arrays[] = $meet->toArray();
        //When user visit the tasks page
        $response = $this->get('api/meets');
        $this->assertNotEmpty($meet);
    }

    public function testMeetIsDeleted()
    {
        $meetToDelete = Meet::all()->first();
        $meetToDelete->delete();

        $this->assertDatabaseMissing('meets',['id'=> $meetToDelete->id]);
    }
}
