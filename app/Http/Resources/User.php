<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Role as RoleResource;

class User extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return
            [
                'id' => $this->id,
                'fname' => $this->fname,
                'lname' => $this->lname,
                'phone' => $this->phone,
                'email' => $this->email,
                'role_id' => $this->role_id,
                
            ];
    }
}
