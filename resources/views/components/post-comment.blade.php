@props(['comment'])
<x-panel class="bg-gray-50">
    <article class="flex space-x-4">
        <div class="flex-shrink-0">
            {{-- author avtar --}}
            <img class="w-12"
            src="https://ui-avatars.com/api/?name={{ $comment->author->username }}&amp;size=64&amp;rounded=true&amp;color=fff&amp;background=fc6369"
            title="{{ $comment->author->username }}">
        </div>

        <div>
            <header class="mb-4">
                <h3 class="font-bold">{{$comment->author->name}}</h3>
                <p class="text-xs">
                    Posted
                    <time>{{$comment->created_at->format('F j, Y, g:i a')}}</time>
                </p>
            </header>

            <p>
                {{$comment->body}}
            </p>
        </div>
    </article>
</x-panel>
