<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DriverResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
            $driver = $this->userable;

            if ($driver instanceof \App\Models\Driver) {
                return [
                    'id' => $driver->id,
                    'name' => $driver->name,
                    'place_id' => $driver->place_id,
                    'price' => $driver->price,
                    'image' => $driver->image,
                    'rating' => $driver->rating,
                    'place' => $driver->place ? $driver->place->name : null,
                    'evaluations' => $driver->evaluations->map(function ($evaluation) {
                        return [
                            'rating' => $evaluation->rating,
                            'comment' => $evaluation->comment,
                            'created_at' => $evaluation->created_at,
                        ];
                    }),
                ];
            }

            return [];
        }
}
