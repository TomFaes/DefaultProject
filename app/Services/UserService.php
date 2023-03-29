<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserService 
{
    public function randomizeUserData(User $user){
        $user->first_name = Str::random(10);
        $user->name = Str::random(10);
        $user->email = Str::random(10)."@".Str::random(10).".".Str::random(3);
        $user->password = Hash::make(Str::random(16));
        $user->forget_user = 1;
        return $user;
    }
}