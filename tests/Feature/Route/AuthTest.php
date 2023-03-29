<?php

namespace Tests\Feature\Route;

use Tests\TestCase;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Password;
use URL;

class AuthTest extends TestCase
{
    protected $allUsers;
    public function setUp() : void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
        $this->allUsers = User::all();
    }

    public function test_authentication_controller_register()
    {
        $data['first_name'] = "Test";
        $data['name'] = "lastname";
        $data['email'] = "test.lastname@test.be";
        $data['password'] = "password";
        $data['confirm_password'] = "password";

        $response = $this->postJson('/api/register/', $data);

        $response->assertStatus(200);
        $this->assertEquals(200, $response->status());

        $createdUser = User::all()->last();
        $this->assertEquals($createdUser->first_name." ".$createdUser->name, $data['first_name'].' '.$data['name']);
    }

    public function test_authentication_controller_register_do_not_pass_validation()
    {
        $response = $this->postJson('/api/register/', array());

        $response->assertStatus(422);
        $this->assertEquals(422, $response->status());
    }

    public function test_authentication_controller_login_with_correct_credentials()
    {
        $user = User::factory()->make();

        $response = $this->post('api/login', [
            'email' => $this->allUsers[0]->email,
            'password' => 'password',
        ]);

        $response->assertStatus(200);
        $this->assertEquals(200, $response->status());
    }

    public function test_authentication_controller_login_with_false_password()
    {
        $response = $this->post('api/login', [
            'email' => $this->allUsers[0]->email,
            'password' => 'incorrect_password',
        ]);

        $response->assertStatus(401);
        $this->assertEquals(401, $response->status());
    }

    public function test_authentication_controller_login_with_false_email()
    {
        $response = $this->post('api/login', [
            'email' => 'test@test.test',
            'password' => 'password',
        ]);

        $response->assertStatus(401);
        $this->assertEquals(401, $response->status());
    }

    public function test_authentication_controller_logout()
    {
        $this->be($this->authenticatedUser());

        $response = $this->postJson('/api/logout');
        $response_data = $response->getData();

        $response->assertStatus(200);
        $this->assertEquals(200, $response->status());
        $this->assertEquals("You are logged out", $response_data->data);
    }


    public function test_forgot_password_controller_with_correct_email()
    {
        $response = $this->postJson('/api/reset-password', [
            'email' => $this->allUsers[0]->email,
        ]);
        $response_data = $response->getData();

        $response->assertStatus(200);
        $this->assertEquals(200, $response->status());
        $this->assertEquals("Password reset email sent.", $response_data->message);
    }

    public function test_forgot_password_controller_with_bad_email()
    {
        $response = $this->postJson('/api/reset-password', [
            'email' => "test@tester.be",
        ]);
        $response_data = $response->getData();

        $response->assertStatus(422);
        $this->assertEquals(422, $response->status());
        $this->assertEquals("Email could not be sent to this email address.", $response_data->message);
    }

    public function test_reset_password_controller()
    {
        $response = $this->postJson('/api/reset/password', [
            'email' => $this->allUsers[0]->email,
            'password' => 'password',
            'password_confirmation' => 'password',
            'token' => Password::createToken(User::first()),
        ]);
        $response_data = $response->getData();

        $response->assertStatus(200);
        $this->assertEquals(200, $response->status());
        $this->assertEquals("Password reset successfully.", $response_data->message);
    }

    public function test_reset_password_controller_with_bad_token()
    {
        $response = $this->postJson('/api/reset/password', [
            'email' => $this->allUsers[0]->email,
            'password' => 'password',
            'password_confirmation' => 'password',
            'token' => "0123456789",
        ]);
        $response_data = $response->getData();

        $response->assertStatus(422);
        $this->assertEquals(422, $response->status());
        $this->assertEquals("Failed, Invalid Token.", $response_data->message);
    }

    public function test_reset_password_controller_with_different_password()
    {
        $response = $this->postJson('/api/reset/password', [
            'email' => $this->allUsers[0]->email,
            'password' => 'password',
            'password_confirmation' => '123456',
            'token' => Password::createToken(User::first()),
        ]);
        $response_data = $response->getData();

        $response->assertStatus(422);
        $this->assertEquals(422, $response->status());
        $this->assertEquals("The password confirmation does not match.", $response_data->message);
    }

    public function test_verification_controller_verify()
    {
        $this->be($this->authenticatedUser());

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $this->allUsers[0]->id, 'hash' => sha1($this->allUsers[0]->email)]
        );

        $response = $this->get($verificationUrl);

        $response->assertStatus(302);
        $this->assertEquals(302, $response->status());
    }

    public function test_verification_controller_verify_invalid_token()
    {
        $token = "Invalid token";
        $response = $this->get('/api/email/verify/'.$this->allUsers[0]->id.'/'.$token);
        $response_data = $response->getData();

        $response->assertStatus(401);
        $this->assertEquals(401, $response->status());
        $this->assertEquals("Invalid/Expired url provided.", $response_data->message);
    }

    public function test_authentication_controller_resend()
    {
        //register a new user
        $data['first_name'] = "Test";
        $data['name'] = "lastname";
        $data['email'] = "test.lastname@test.be";
        $data['password'] = "password";
        $data['confirm_password'] = "password";
        $response = $this->postJson('/api/register/', $data);

        $createdUser = User::all()->last();

        $this->be($this->authenticatedUser($createdUser->id));

        $response = $this->get('/api/email/resend');
        $response_data = $response->getData();

        $response->assertStatus(200);
        $this->assertEquals(200, $response->status());
        $this->assertEquals("Email verification link sent on your email id.", $response_data->data);
    }

    public function test_authentication_controller_resend_already_verified()
    {
        $this->be($this->authenticatedUser());

        $response = $this->get('/api/email/resend');
        $response_data = $response->getData();

        $response->assertStatus(401);
        $this->assertEquals(401, $response->status());
        $this->assertEquals("Email already verified.", $response_data->data);
    }
}