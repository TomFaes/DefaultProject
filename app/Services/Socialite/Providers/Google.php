<?php

namespace App\Services\Socialite\Providers;

class Google implements IProvider
{
    public function convertUserdata($data): array
    {
        $array = array();
        $array['provider_id'] = $data->id;
        $array['provider'] = 'google';
        $array['first_name'] = $data->user['given_name'];
        $array['name'] = $data->user['family_name'];
        $array['email'] = $data->email;
        return $array;
    }
}