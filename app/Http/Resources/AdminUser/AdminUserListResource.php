<?php

namespace App\Http\Resources\AdminUser;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminUserListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'role_name' => $this->role->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'gender' => $this->gender,
            'is_active' => $this->is_active ? "Active" : "In Active",
        ];
    }
}
