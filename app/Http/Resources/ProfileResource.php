<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Socialite;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'name' => $this->name,
            'full_name' => $this->first_name." ".$this->name,
            'email' => $this->email,
            'email_verified_at' => $this->email_verified_at, //used to check if user is verified in router.js
            'providers' => $this->socialiteUser,
        ];
    }
}
