<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function setPasswordAttribute($password)
    {
        return $this->attributes['password'] = Hash::make($password);
    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'bookmarked_posts' => 'array',
    ];

    public function posts() //$user->posts
    {
        return $this->hasMany(Post::class);
    }

    //get all the followers of the author
    public function followers()
    {
        return $this->belongsToMany(User::class,'author_followers','author_id')->withTimestamps();
    }

    //get all the followings of a user (list of author a user follows)
    public function followings()
    {
        return $this->belongsToMany(User::class,'author_followers','user_id','author_id')->orderByPivot('created_at','desc');
    }
}
