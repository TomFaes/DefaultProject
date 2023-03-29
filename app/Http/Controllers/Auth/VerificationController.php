<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Resources\ProfileResource;
use App\Models\User;
use Illuminate\Http\Request;

class VerificationController extends BaseController
{
    public function verify($user_id, Request $request) 
    {
        if (!$request->hasValidSignature()) {
            $message = "Invalid/Expired url provided.";
            return $this->sendResponse($message, $message, 401);
        }

        $user = User::findOrFail($user_id);

        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }
        return redirect()->to('/');
    }

    public function resend() 
    {
        if (auth()->user()->hasVerifiedEmail()) {
            $message = "Email already verified.";
            return $this->sendResponse($message, $message, 401);
            //return response()->json(["msg" => "Email already verified."], 400);
        }
        auth()->user()->sendEmailVerificationNotification();
        $message = 'Email verification link sent on your email id.';
        return $this->sendResponse($message, $message, 200);
    }
}
