<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
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

    protected function avatar(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value): ?string {
                if (isset($value) && is_string($value)) {
                    if (filter_var($value, FILTER_VALIDATE_URL)) {
                        return $value;
                    }

                    return Storage::disk('public')->url($value);
                }

                return config('app.user.default_user_avatar');
            }
        );
    }

    public function posts() // $user->posts
    {
        return $this->hasMany(Post::class);
    }

    // get all the followers of the author
    public function followers()
    {
        return $this->belongsToMany(User::class, 'author_followers', 'author_id')->withTimestamps();
    }

    // get all the followings of a user (list of author a user follows)
    public function followings()
    {
        return $this->belongsToMany(User::class, 'author_followers', 'user_id', 'author_id')->orderByPivot('created_at', 'desc');
    }
}
