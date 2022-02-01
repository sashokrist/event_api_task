<?php

namespace Tests\Feature;

use App\Models\Meet;
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


    public function testIsLoggedOut()
    {
        //$user = factory(User::class)->create(['email' => 'user@test.com']);
        $user = User::create([
                                 'name' => 'Sasho55',
                                 'email' => 'sasho55@test.com',
                                 'password' => Hash::make('11111111')
                             ]);
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $this->json('get', '/api/meets', [], $headers)->assertStatus(200);
        $this->json('post', '/api/logout', [], $headers)->assertStatus(200);

        $user = User::find($user->id);

        $this->assertEquals(null, $user->api_token);
    }

    public function testMeetIsCreated()
    {
        $meet = Meet::create([
            'name' => 'Interview meet',
            'room' => 'room 1'
                             ]);
        $arrays[] = $meet->toArray();
        $this->assertArrayHasKey('name', $arrays);
    }

    public function testMeetIsDeleted()
    {
        $user = new User();
        $user->name = 'Sashooo888';
        $user->email = 'test888@test.com';
        $user->api_token = Str::random(60);
        $user->password = '11111111';
        $user->save();
        $token = $user->api_token;
        $headers = ['Authorization' => "Bearer $token"];

        $payload = [
            'name' => 'Interview meet',
            'room' => 'room 1',
            'start_time' => '2021-08-01 11:00:00',
            'end_time' => '2021-08-01 12:00:00'
        ];

        $this->json('DELETE', '/api/meets/', [], $headers)
            ->assertStatus(204);
    }
}
