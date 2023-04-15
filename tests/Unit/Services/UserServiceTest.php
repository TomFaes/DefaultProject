<?php

namespace Tests\Unit\Services;

use App\Models\SocialiteUser;
use App\Models\User;
use App\Services\UserService;
use Tests\TestCase;
use Database\Seeders\DatabaseSeeder;

class UserServiceTest extends TestCase
{
    protected $userService;

    public function setUp() : void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);

        $this->userService = new UserService();
    }

    public function test_user_service_randomize_user_data()
    {
        $user = User::first();

        $array = [
            'firstName'=> $user->first_name,
            'lastName'=> $user->name,
            'email'=> $user->email,
        ];

        $randomisedUser = $this->userService->randomizeUserData($user);

        $this->assertNotEquals($array['firstName'], $randomisedUser->first_name);
        $this->assertNotEquals($array['lastName'], $randomisedUser->name);
        $this->assertNotEquals($array['email'], $randomisedUser->email);

    }

    public function test_user_service_setup_socialite_user()
    {
        //first_name, name, email, password, provider_id, provider
        $array = [
            'first_name'=> "John",
            'name'=> "Doe",
            'email'=> "John.doe@test.be",
            'provider' => 'google',
            'provider_id' => '123'
        ];

        $user =$this->userService->setupSocialiteUser($array);

        $socialiteUser = SocialiteUser::all()->last();

        $this->assertEquals($array['first_name'], $user->first_name);
        $this->assertEquals($array['name'], $user->name);
        $this->assertEquals($array['email'], $user->email);
        $this->assertEquals($array['provider'], $socialiteUser->provider);
        $this->assertEquals($array['provider_id'], $socialiteUser->socialite_id);
    }

    public function test_user_service_create_new_socialiteUser()
    {
        $user = User::all()->last();

        $array = [
            'provider' => 'google',
            'provider_id' => '123'
        ];

        $socialiteUser = $this->userService->createNewSocialiteUser($user, $array);

        $this->assertEquals($array['provider'], $socialiteUser->provider);
        $this->assertEquals($array['provider_id'], $socialiteUser->socialite_id);
        $this->assertEquals($user->id, $socialiteUser->user_id);
    }
}