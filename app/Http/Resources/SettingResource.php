<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'is_pro' => !!$this->is_pro,
            'setting_id' => $this->pivot?->setting_id,
            'enabled' => !!$this->pivot?->enabled,
        ];
    }
}
