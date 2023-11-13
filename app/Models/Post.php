<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use HasFactory;

    protected $with = ['author','category'];

    public function scopeFilter($query,array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query,$search) {
            $query
                    ->where('title', 'like', '%' . $search . '%')
                    ->Orwhere('body', 'like', '%' . $search . '%');
        });
    }


    /**
     * Get the route key for the model.
    */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function category()
    {
        return $this->BelongsTo(Category::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
