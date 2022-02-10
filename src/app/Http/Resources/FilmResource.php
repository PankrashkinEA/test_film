<?php

namespace App\Http\Resources;

use App\Models\Actor;
use App\Models\FilmActor;
use App\Models\Genre;
use Illuminate\Http\Resources\Json\JsonResource;

class FilmResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'genre_name' => Genre::where('id',$this->genre_id)->pluck('name'),
            'title' => $this->title,
            'description' => $this->description,
            'year' => $this->year,
            'actors' => $this->actors->pluck('name')
        ];
    }
}
