<?php

namespace Tests\Feature\Route;

use Tests\TestCase;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;

class UserTest extends TestCase
{
    protected $allUsers;
    public function setUp() : void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
        $this->allUsers = User::all();
    }

    public function test_profile_controller_show()
    {
        $this->be($this->authenticatedUser());

        $response = $this->get('/api/profile');
        $response_data = $response->getData();

        $response->assertStatus(200);
        $this->assertEquals(200, $response->status());
        $this->assertEquals($response_data->data->full_name, $this->allUsers[0]->first_name.' '.$this->allUsers[0]->name);
    }

    public function test_profile_controller_update()
    {
        $this->be($this->authenticatedUser());

        $data = User::factory()->make()->toArray();

        $response = $this->postJson('/api/profile/', $data);
        $response_data = $response->getData();

        $response->assertStatus(201);
        $this->assertEquals(201, $response->status());
        $this->assertEquals($response_data->data->full_name, $data['first_name'].' '.$data['name']);
    }

    public function test_profile_controller_update_which_do_not_pass_validation()
    {
        $this->be($this->authenticatedUser());

        $response = $this->postJson('/api/profile/', array());

        $response->assertStatus(422);
        $this->assertEquals(422, $response->status());
    }

    public function test_profile_controller_destroy()
    {
        $this->be($this->authenticatedUser());

        $response = $this->json('delete', '/api/profile');

        $response->assertStatus(204);
        $this->assertEquals(204, $response->status());

        $updatedUser = User::find(1);
        $this->assertNotEquals($updatedUser->full_name, $this->allUsers[0]->first_name.' '.$this->allUsers[0]->name);
    }

    public function test_password_controller_update()
    {
        $this->be($this->authenticatedUser());
        $response = $this->postJson('/api/password', [
            'password' => 'password',
            'confirm_password' => 'password',
        ]);
        $response_data = $response->getData();

        $response->assertStatus(200);
        $this->assertEquals(200, $response->status());
        $this->assertEquals("Password is changed", $response_data->message);
    }
    
    public function test_password_controller_update_with_fault_password()
    {
        $this->be($this->authenticatedUser());
        $response = $this->postJson('/api/password', [
            'password' => 'password',
            'confirm_password' => 'other password',
        ]);
        $response_data = $response->getData();

        $response->assertStatus(422);
        $this->assertEquals(422, $response->status());
        $this->assertEquals("The confirm password and password must match.", $response_data->message);
    }
}