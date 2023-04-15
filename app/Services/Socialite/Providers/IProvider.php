<?php

namespace App\Services\Socialite\Providers;

Interface IProvider
{
    public function convertUserdata($data);
}