<!DOCTYPE html>

<title>My Blog</title>

<link rel="stylesheet" href="/app.css">

<body>

        @foreach($posts as $post)
    <article>

        <a href="posts/{{$post->slug}}">
            <h1>{{$post->title}} </h1>
        </a>
        <div>
            {{ $post->excerpt }}
        </div>
    </article>
        @endforeach
</body>
