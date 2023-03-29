<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use App\Models\User;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Auth\Events\PasswordReset;

class ResetPasswordController extends BaseController
{
    use ResetsPasswords;

    public function callResetPassword(Request $request)
    {
        return $this->reset($request);
    }

    protected function resetPassword(User $user, $password)
    {
        $user->password = bcrypt($password);
        $user->save();
        event(new PasswordReset($user));
    }

    protected function sendResetResponse(Request $request, $response)
    {
        $message = 'Password reset successfully.';
        return $this->sendResponse($message, $message, 200);
    }
    protected function sendResetFailedResponse(Request $request, $response)
    {
        $message = 'Failed, Invalid Token.';
        return $this->sendResponse($message, $message, 422);
    }
}
