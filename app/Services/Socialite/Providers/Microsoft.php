<?php

namespace App\Services\Socialite\Providers;

class Microsoft implements IProvider
{
    public function convertUserdata($data): array
    {
        $array = array();
        $array['provider_id'] = $data->id;
        $array['provider'] = 'microsoft';
        $array['first_name'] = $data->user['givenName'];
        $array['name'] = $data->user['surname'];
        $array['email'] = $data->email;
        return $array;
    }
}