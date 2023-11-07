@props(['post'])

<article
{{ $attributes->merge([
    'class' => 'transition-colors duration-300 hover:bg-gray-100 border border-black border-opacity-0 hover:border-opacity-5 rounded-xl'
    ])}}>
    <div class="py-6 px-5">
        <div>
            {{-- TO DO --}}
            <img src="/images/illustration-3.png" alt="laracasts blog illustration-1" class="rounded-xl" >
        </div>
        <div class="mt-8 flex flex-col justify-between">
            <header>
                <div class="space-x-2">
                    <a href="categories/{{$post->category->slug}}"
                        class="border border-blue-300 px-3 py-1 rounded-full text-blue-300 uppercase"
                        style="font-size: 10px;"
                        >
                        {{$post->category->name}}
                    </a>
                </div>

                <div class="mt-4">
                    <h1 class="text-3xl">
                    <a href="/post/{{$post->slug}}">
                        {{$post->title}}
                    </a>
                    </h1>
                    <span class="mt-2 block text-xs text-gray-400">Published <time>{{$post->created_at->diffForHumans()}}</time></span>
                </div>
            </header>

            <div class="text-sm mt-4">
                <p>{{$post->excerpt}}</p>
            </div>

            <footer class="flex justify-between items-center mt-8">
                <div class="flex items-center">
                    <img src="/images/lary-avatar.svg" alt="Lary avtar">
                    <div class="ml-3">
                        <h5 class="font-bold">{{$post->author->name}}</h5>
                        <h6>Mascot at Laracasts</h6>
                    </div>
                </div>
                <div class="hidden lg:block">
                    <a href="/post/{{$post->slug}}" class="text-xs font-semibold bg-gray-200 px-8 py-2 rounded-full">Read More</a>
                </div>
            </footer>
        </div>
    </div>
</article>