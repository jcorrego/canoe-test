<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FundResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Convert year to integer.
        $start_year = (int) $this->start_year;
        return [
            'id' => $this->id,
            'name' => $this->name,
            'start_year' => $start_year,
            'manager' => new ManagerResource($this->manager),
            'aliases' => AliasResource::collection($this->aliases),
            'companies' => CompanyResource::collection($this->companies),
        ];
    }
}
