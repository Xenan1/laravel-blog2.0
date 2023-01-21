<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserActivityResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'likes' => LikeResource::collection($this->likes),
            'comments' => UserCommentsResource::collection($this->comments)
        ];
    }
}
