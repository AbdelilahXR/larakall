<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "code" => $this->code,
            "reference" => $this->reference,
            "client" => $this->client,
            "phone" => $this->phone,
            "price" => $this->price,
            "city" => $this->city,
            "adress" => $this->adress,
            "information" => $this->information,
            "updated_at" => $this->updated_at,
            "deleted_at" => $this->deleted_at,
            "created_at" => $this->created_at,
            "shipping_company_id" => $this->company->id ?? null,
            "shipping_company_name" => $this->company,
            "tracking_code" => $this->tracking_code,
            "store_id" => $this->store->id ?? null,
            "store_name" => $this->store->name ?? null,
            "confirmation_state" => $this->lastConfirmationState->name ?? null,
            "delivery_state" => $this->lastDeliveryState->name ?? null,
            "products" => $this->orderProducts
        ];
    }
}
