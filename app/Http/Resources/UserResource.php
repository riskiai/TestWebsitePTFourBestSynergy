<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'name' => $this->name,
            'address' => $this->address,
            'phone_number' => $this->phone_number,
            // Akses langsung model Role tanpa menggunakan RoleResource
            'role' => $this->role ? $this->role->role_name : null, // Ambil role_name langsung dari relasi role
        ];
    }
}
