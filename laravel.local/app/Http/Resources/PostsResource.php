<?php

namespace App\Http\Resources;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class PostsResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'head' => $this->head,
            'text' => substr($this->text, 0, 99),
            'comments' => count($this->comments),
            'likes' => count($this->likes),
        ];
    }
}
