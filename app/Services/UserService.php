<?php

namespace App\Services;

use App\Models\SocialiteUser;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserService 
{
    public function randomizeUserData(User $user)
    {
        $user->first_name = Str::random(10);
        $user->name = Str::random(10);
        $user->email = Str::random(10)."@".Str::random(10).".".Str::random(3);
        $user->password = Hash::make(Str::random(16));
        $user->forget_user = 1;
        return $user;
    }

    /**
     * setupSocialiteUser
     * 
     * @param $data fields => first_name, name, email, provider_id, provider
     */
    public function setupSocialiteUser($data)
    {
        $user = User::where('email', $data['email'])->first();
        // indien deze niet bestaat, maak een nieuwe gebruiker aan
        if($user == null){
            $user = $this->createNewUser($data);
        }
        // Creeër de socialite link met de gebruiker
        $this->createNewSocialiteUser($user, $data);

        return $user;
    }

    protected function createNewUser($data)
    {
        $newUser = new User();
        $newUser->first_name = $data['first_name'];
        $newUser->name = $data['name'];
        $newUser->email = $data['email'];
        $newUser->password = bcrypt(Str::random(16));
        $newUser->role = 'User';
        $newUser->save();

        event(new Registered($newUser));
        return $newUser;
    }

    /**
     * createNewSocialiteUser
     * 
     * @param $data fields => provider_id, provider
     */
    public function createNewSocialiteUser(User $user, $data)
    {
        $socialiteUser = new SocialiteUser();
        $socialiteUser->socialite_id = $data['provider_id'];
        $socialiteUser->provider = $data['provider'];
        $socialiteUser->user_id = $user->id;
        $socialiteUser->save();
        return $socialiteUser;
    }
}