<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\BaseController;
use App\Http\Requests\ProfileRequest;
use App\Http\Resources\ProfileResource;
use App\Models\User;
use App\Services\UserService;
use Auth;

class ProfileController extends BaseController
{
    protected $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function show()
    {
        $userId = auth()->user()->id;
        return $this->sendResponse(new ProfileResource(User::find($userId)), "succes", 200);
    }

    public function update(ProfileRequest $request)
    {
        $userId = auth()->user()->id;
        $user = User::find($userId);
        $user->update($request->validated());
        $user->save();
        return $this->sendResponse(new ProfileResource($user), "Profile updated", 201);
    }

    public function destroy()
    {
        $userId = Auth::user()->id;
        $user = User::find($userId);
        $user = $this->userService->randomizeUserData($user);
        $user->save();
        return $this->sendResponse("Profile is removed", "Profile is removed", 204);
    }
}
