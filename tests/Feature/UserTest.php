<?php

namespace Tests\Feature;

use App\Models\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTest extends TestCase
{
    /** @test
     * A basic unit test example.
     *
     * @return void
     */
    function create_success_user()
    {

        $user = User::factory()->create();
        $response = $this->post('api/login', ['email' => $user->email, 'password' => 'password', 'token' => '*']);
        $response->assertStatus(200);
        $user->roles()->attach(1);// attache permission admin
        $response2 = $this->withHeaders(['Authorization' => 'Bearer ' . $response->json()['data']['token']])
            ->post('api/users', ['name' => 'fake',
                'phone' => 9999999999,
                'email' => 'fake22@gmail.com',
                'password' => "password"
            ]);

        $response2->assertStatus(200);
    }

    /** @test
     * A basic unit test example.
     *
     * @return void
     */

    function create_faild_user()
    {

        $user = User::factory()->create();
        $response = $this->post('api/login', ['email' => $user->email, 'password' => 'password', 'token' => '*']);
        $response->assertStatus(200);
        $user->roles()->attach(2);// attache permission user
        $response2 = $this->withHeaders(['Authorization' => 'Bearer ' . $response->json()['data']['token']])
            ->post('api/users', ['name' => 'fake',
                'phone' => 5,
                'email' => 'fake22@gmail.com',
                'password' => "password"
            ]);

        $response2->assertStatus(401);
    }

    /** @test
     * A basic unit test example.
     *
     * @return void
     */

    function update_success_user()
    {

        $user = User::factory()->create();
        $response = $this->post('api/login', ['email' => $user->email, 'password' => 'password', 'token' => '*']);
        $response->assertStatus(200);
        $user->roles()->attach(1);// attache permission admin
        $response2 = $this->withHeaders(['Authorization' => 'Bearer ' . $response->json()['data']['token']])
            ->put('api/users/1', ['name' => 'fake',
                'phone' => 5,
                'email' => 'fake22@gmail.com',
                'password' => "password"
            ]);

        $response2->assertStatus(200);
    }

    /** @test
     * A basic unit test example.
     *
     * @return void
     */
    function update_faild_user()
    {

        $user = User::factory()->create();
        $response = $this->post('api/login', ['email' => $user->email, 'password' => 'password', 'token' => '*']);
        $response->assertStatus(200);
        $user->roles()->attach(2);// attache permission admin
        $response2 = $this->withHeaders(['Authorization' => 'Bearer ' . $response->json()['data']['token']])
            ->put('api/users/367', ['name' => 'fake',
                'phone' => 5,
                'email' => 'fake22@gmail.com',
                'password' => "password"
            ]);

        $response2->assertStatus(401);
    }

    /** @test
     * A basic unit test example.
     *
     * @return void
     */
    function show_user_success_login_with_uesr_admin()
    {

        $user = User::factory()->create();
        $response = $this->post('api/login', ['email' => $user->email, 'password' => 'password', 'token' => '*']);
        $response->assertStatus(200);
        $user->roles()->attach(1);// attache permission admin
        $response2 = $this->withHeaders(['Authorization' => 'Bearer ' . $response->json()['data']['token']])
            ->get('api/users/2');

        $response2->assertStatus(200);
    }

    /** @test
     * A basic unit test example.
     *
     * @return void
     */
    function show_user_faild_login_with_uesr_role()
    {

        $user = User::factory()->create();
        $response = $this->post('api/login', ['email' => $user->email, 'password' => 'password', 'token' => '*']);
        $response->assertStatus(200);
        $user->roles()->attach(2);// attache permission admin
        $response2 = $this->withHeaders(['Authorization' => 'Bearer ' . $response->json()['data']['token']])
            ->get('api/users/2');

        $response2->assertStatus(401);
    }

    /** @test
     * A basic unit test example.
     *
     * @return void
     */
    function show_all_users_success_login_with_admin_role()
    {

        $user = User::factory()->create();
        $response = $this->post('api/login', ['email' => $user->email, 'password' => 'password', 'token' => '*']);
        $response->assertStatus(200);
        $user->roles()->attach(1);// attache permission admin
        $response2 = $this->withHeaders(['Authorization' => 'Bearer ' . $response->json()['data']['token']])
            ->get('api/users');

        $response2->assertStatus(200);
    }

    /** @test
     * A basic unit test example.
     *
     * @return void
     */
    function show_all_users_faild_login_with_user_role()
    {

        $user = User::factory()->create();
        $response = $this->post('api/login', ['email' => $user->email, 'password' => 'password', 'token' => '*']);
        $response->assertStatus(200);
        $user->roles()->attach(2);// attache permission admin
        $response2 = $this->withHeaders(['Authorization' => 'Bearer ' . $response->json()['data']['token']])
            ->get('api/users');

        $response2->assertStatus(401);
    }

    /** @test
     * A basic unit test example.
     *
     * @return void
     */
    function delete_success_user()
    {

        $user = User::factory()->create();
        $response = $this->post('api/login', ['email' => $user->email, 'password' => 'password', 'token' => '*']);
        $response->assertStatus(200);
        $user->roles()->attach(1);// attache permission admin
        $response2 = $this->withHeaders(['Authorization' => 'Bearer ' . $response->json()['data']['token']])
            ->delete('api/users/' . $user->id);

        $response2->assertStatus(204);
    }

    /** @test
     * A basic unit test example.
     *
     * @return void
     */

    function assign_rule_user_success()
    {

        $user = User::factory()->create();
        $response = $this->post('api/login', ['email' => $user->email, 'password' => 'password', 'token' => '*']);
        $response->assertStatus(200);
        $user->roles()->attach(1);// attache permission admin
        $response2 = $this->withHeaders(['Authorization' => 'Bearer ' . $response->json()['data']['token']])
            ->post('api/users/4/assign-rules', ["role_ids" => [
                1,
                2,
                3
            ]]);

        $response2->assertStatus(200);
    }

    /** @test
     * A basic unit test example.
     *
     * @return void
     */


    function assign_permission_role_success()
    {

        $user = User::factory()->create();
        $response = $this->post('api/login', ['email' => $user->email, 'password' => 'password', 'token' => '*']);
        $response->assertStatus(200);
        $user->roles()->attach(1);// attache permission admin
        $response2 = $this->withHeaders(['Authorization' => 'Bearer ' . $response->json()['data']['token']])
            ->post('api/assign-permission-role/1', ["permission_ids" => [1, 2, 3

            ]]);

        $response2->assertStatus(200);
    }


    function delete_faild_user()
    {

        $user = User::factory()->create();
        $response = $this->post('api/login', ['email' => $user->email, 'password' => 'password', 'token' => '*']);
        $response->assertStatus(200);
        $user->roles()->attach(1);// attache permission admin
        $response2 = $this->withHeaders(['Authorization' => 'Bearer ' . $response->json()['data']['token']])
            ->delete('api/users/5');

        $response2->assertStatus(404);
    }


}
