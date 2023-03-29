<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends BaseController
{
    use SendsPasswordResetEmails;

    public function sendPasswordResetLink(Request $request)
    {
        return $this->sendResetLinkEmail($request);
    }

    protected function sendResetLinkResponse(Request $request, $response)
    {
        return $this->sendResponse($response, 'Password reset email sent.', 200);
    }

    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        $message = "Email could not be sent to this email address.";
        return $this->sendResponse($message, $message, 422);        
    }
}
