<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'fullName_ar' => $this->fullName_ar,
            'fullName_fr' => $this->fullName_fr,
            'fullName_en' => $this->fullName_eng,
            'email' => $this->email,
            'phone1' => $this->phone1,
            'phone2' => $this->phone2,
            'city' => $this->city,
            'avatar_url' => $this->avatar_url,
            'status' => $this->status,
            'addition' => $this->addition,
            'reference' => $this->reference,
            'roles' => $this->roles->pluck('name'),
            'stores' => $this->stores
        ];
    }
}
