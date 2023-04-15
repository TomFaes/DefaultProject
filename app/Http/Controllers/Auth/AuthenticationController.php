<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends BaseController
{    public function register(RegisterRequest $request)
    {
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $input['role'] = 'User';
        $user = User::create($input);
        $success['token'] =  $user->createToken('defaultProject')->plainTextToken;
        $success['name'] = $user->first_name." ".$user->name;

        event(new Registered($user));

        //Login User after registration.
        auth()->login($user);

        return $this->sendResponse($success, 'User register successfully.');
    }

    public function login(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('defaultProject')->plainTextToken;
            $success['name'] = $user->first_name." ".$user->name;

            return $this->sendResponse($success, 'User login successfully.');
        }
        else{
            return $this->sendError('Unauthorised.', ['error'=>'Invalid username or password'], 401);
        }
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        Auth::guard('web')->logout();
        return $this->sendResponse('You are logged out', 'You have successfully logged out and the token was successfully deleted');
    }
}
