<?php

namespace App\Http\Resources;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request): array
    {
        return [
            'name' => $this->user->name,
            'surname' => $this->user->surname,
            'head' => $this->head,
            'text' => $this->text,
            'comments' => PostCommentsResource::collection($this->comments),
            'likes' => count($this->likes),
        ];
    }
}
