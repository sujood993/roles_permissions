<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /** @test
     * A basic functional test example.
     *
     * @return void
     */
    function login_user(){

        $user = User::factory()->create();
        $response = $this->post('api/login', ['email' => $user->email, 'password' => 'password', 'token' => '*']);
        $response->assertStatus(200);
    }
    /** @test
     * A basic functional test example.
     *
     * @return void
     */
    function login_user_failed(){

        $user = User::factory()->create();
        $response = $this->post('api/login', ['email' => $user->email, 'password' => 'wrong', 'token' => '*']);
        $response->assertStatus(401);
    }
}
