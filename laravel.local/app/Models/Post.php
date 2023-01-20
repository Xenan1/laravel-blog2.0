<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;

class Post extends Model
{
    use HasFactory;

    public function likes(): Relations\HasMany
    {
        return $this->hasMany(Like::class);
    }

    public function comments(): Relations\HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function user(): Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): Relations\BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
