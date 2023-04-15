<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Models\SocialiteUser;
use App\Models\User;
use App\Services\Socialite\ProviderService;
use App\Services\UserService;
use Auth;
use Exception;
use Laravel\Socialite\Facades\Socialite;

class SocialiteUserController extends BaseController
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function getSocialiteRedirect($socialiteProvider)
    {
        try{
            return Socialite::driver($socialiteProvider)->redirect();
        }catch ( \InvalidArgumentException $e ){
            dd($e);
            //return redirect('/');
        }
    }

    public function getSocialiteCallback($socialiteProvider)
    {
        try {
            //get account info from the user who logged in
            $socialiteAccount = Socialite::driver($socialiteProvider)->user();            
            //zet de gevonden data
            $providerService = ProviderService::getProvider($socialiteProvider);
            $userdata = $providerService->convertUserdata($socialiteAccount);

            //ga na of de socialite account bestaat in ons systeem
            $socialiteUser = SocialiteUser::where('provider', $socialiteProvider)
            ->where('socialite_id', $socialiteAccount->id)
            ->first();

            if ($socialiteUser == null) {
                $user = $this->userService->setupSocialiteUser($userdata);
            }else{
                $user = User::where('id', $socialiteUser->user_id)->first();
            }

            //log de gebruiker in
            auth()->login($user);
            Auth::user()->createToken('defaultProject')->accessToken;
            return redirect('/');
        }
        catch (Exception $e) {
            echo "<hr>Error<hr><br>";
            return 'error'."<br>".$e;
        }
    }
}
