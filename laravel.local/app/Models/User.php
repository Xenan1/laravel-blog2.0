<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations;



class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'surname',
        'password',
        'login',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts(): Relations\HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function comments(): Relations\HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function likes(): Relations\HasMany
    {
        return $this->hasMany(Like::class);
    }


}
