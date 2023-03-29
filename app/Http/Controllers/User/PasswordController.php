<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\BaseController;
use App\Http\Requests\PasswordRequest;
use App\Http\Resources\ProfileResource;
use App\Models\User;
use Auth;

class PasswordController extends BaseController
{
    public function update(PasswordRequest $request)
    {
        $userId = Auth::user()->id;
        $user = User::find($userId);
        $user->password = bcrypt($request['password']);
        $user->save();
        return $this->sendResponse(new ProfileResource($user), 'Password is changed', 200);
    }
}
