<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    /**
     * Get the route key for the model.
    */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
