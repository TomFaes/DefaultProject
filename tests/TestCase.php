<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    protected function authenticatedUser($userId = 1, $role = "User"){
        $user = Sanctum::actingAs(
            User::find($userId),
            ['create-servers']
        );
        $user->role = $role;
        return $user;
    }
}
