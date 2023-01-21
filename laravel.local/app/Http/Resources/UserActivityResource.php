<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Post;
use App\Http\Resources\UserCommentsResource;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\LikeResource;

class UserActivityResource extends JsonResource
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
            'likes' => LikeResource::collection($this->likes),
            'comments' => UserCommentsResource::collection($this->comments)
        ];
    }
}
