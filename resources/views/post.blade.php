<x-layout>
    <article>
        <h1> {!! $post->title !!}</h1>
        <p>
            by <a href="/author/{{$post->author->username}}">{{$post->author->name}}</a> in <a href="/categories/{{$post->category->slug}}">{{$post->category->name}}</a>
        </p>
        <div>
            {!! $post->body !!}
        </div>
    </article>
    <a href="/">Go back</a>
</x-layout>
