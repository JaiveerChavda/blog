<?php

namespace App\Models;

use App\Enums\PostStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;

class Post extends Model implements Feedable
{
    use HasFactory;

    protected $with = ['author','category'];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function scopeFilter($query, array $filters)
    {
        $query->when(
            $filters['search'] ?? false,
            fn ($query, $search) =>
            $query->where(
                fn ($query) =>
                    $query->where('title', 'like', '%' . $search . '%')
                    ->Orwhere('body', 'like', '%' . $search . '%')
            )
        );

        $query->when(
            $filters['category'] ?? false,
            fn ($query, $category) =>
            $query->whereHas(
                'category',
                fn ($query) =>
                $query->where('slug', $category)
            )
        );

        $query->when(
            $filters['author'] ?? false,
            fn ($query, $author) =>
            $query->whereHas(
                'author',
                fn ($query) =>
                $query->where('username', $author)
            )
        );
    }

    /**
    * Filter posts by published status
    */

    public function scopePublished($query)
    {
        $query->where('status', PostStatus::PUBLISHED)->latest('published_at');
    }


    /**
     * Get the route key for the model.
    */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function category()
    {
        return $this->BelongsTo(Category::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function toFeedItem(): FeedItem
    {
        return FeedItem::create()
        ->id($this->id)
        ->title($this->title)
        ->summary($this->excerpt)
        ->updated($this->published_at)
        ->link($this->getLink())
        ->authorName($this->author->name)
        ->authorEmail($this->author->email);
    }

    public static function getFeedItems()
    {
        return static::query()->published()->latest()->get();
    }

    //get the link to show in rss feed
    public function getLink()
    {
        return route('post.show', $this);
    }

    public function thumbnail(): Attribute
    {
        return Attribute::make(
            get:function ($value) {
                if(is_string($value)){

                    if(filter_var($value, FILTER_VALIDATE_URL)){
                        return $value;
                    }

                    return Storage::disk('public')->url($value);
                }
            }
        );
    }
}
