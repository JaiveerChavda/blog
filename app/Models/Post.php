<?php

namespace App\Models;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\File;
use Spatie\YamlFrontMatter\YamlFrontMatter;

class Post
{
    public function __construct(
        public $title,
        public $body,
        public $date,
        public $excerpt,
        public $slug,
    ) {}

    public static function all()
    {
        $posts = collect($files = File::files(resource_path('posts')))
        ->map(fn ($file) => YamlFrontMatter::parseFile($file))
        ->map(fn ($doc) => new Post(
                $doc->title,
                $doc->body(),
                $doc->date,
                $doc->excerpt,
                $doc->slug,
            ));

        return $posts;
    }

    public static function find($slug)
    {
    //    $posts = static::all();
       return static::all()->firstWhere('slug',$slug);
    }
}
