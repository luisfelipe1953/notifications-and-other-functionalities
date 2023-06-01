<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationReadResource extends JsonResource
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
            'type' => $this->type,
            'data' => $this->when($this->type === 'App\\Notifications\\CreatedProductNotification', function () {
                return [
                    'product_name' => $this->data['product_name'],
                    'product_description' => $this->data['product_description'],
                ];
            }, function () {
                return $this->data;
            }),
            'created_at' => $this->created_at->diffForHumans(),
        ];
    }
}
