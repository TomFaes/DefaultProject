<?php

namespace App\Services\Socialite;

class ProviderService
{
    public static function getProvider($platform)
    {
        $provider = "App\Services\Socialite\Providers\\".ucfirst($platform);
        if (class_exists($provider)) {
            return new $provider();
        } else {
            return "er is geen provider gevonden voor het opgegeven platform ".$platform;
        }
    }
}