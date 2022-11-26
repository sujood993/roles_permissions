<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $roles = $this->roles;
        foreach ($roles as $role) {
           $role->permissions;
        }
        return [
            'id' => $this->id,
            'name' => App::isLocale('en') ? 'SUJOOD' : 'SSSS',
            'email' => $this->email,
            'phone' => $this->phone,
            'roles' => $roles,
        ];
    }





}
