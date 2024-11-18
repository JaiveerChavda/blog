<x-layout>
        <section class="px-6 py-8">
            <main class="max-w-6xl mx-auto mt-10 lg:mt-20 space-y-6">
                <article class="max-w-4xl mx-auto lg:grid lg:grid-cols-12 gap-x-10">
                    <div class="col-span-4 lg:text-center lg:pt-14 mb-10">
                        <img src="{{ $post->thumbnail }}" alt="" class="rounded-xl">

                        <p class="mt-4 block text-gray-400 text-xs">
                            Published <time>{{$post->created_at->diffForHumans()}}</time>
                        </p>

                        <div class="flex items-center lg:justify-start text-sm mt-4">
                            {{-- author avtar --}}
                            <img class="w-12"
                            src="https://ui-avatars.com/api/?name={{ $post->author->name }}&amp;size=64&amp;rounded=true&amp;color=fff&amp;background=fc6369"
                            title="{{ $post->author->name }}">

                            <div class="ml-3 text-left">
                                <h5 class="font-bold">
                                    <a href="/?author={{$post->author->username}}">{{$post->author->name}}</a>
                                </h5>
                            </div>
                            @auth
                                @if (auth()->id() != $post->author->id)
                                    @if (in_array(auth()->id(),$post->author->followers->pluck('id')->toArray()))
                                    <a href="{{ route('unfollow.author',[$post->author->username])}}"
                                        class="bg-red-500 py-1 rounded-2xl text-white ml-auto px-5 text-sm font-bold">UnFollow</a>
                                    @else
                                    <a href="{{ route('follow.author',[$post->author->username])}}"
                                        class="bg-blue-500 py-1 rounded-2xl text-white ml-auto px-5 text-sm font-bold">Follow</a>
                                    @endif
                                @endif
                            @endauth
                        </div>
                    </div>

                    <div class="col-span-8">
                        <div class="hidden lg:flex justify-between mb-6">
                            <a href="/"
                                class="transition-colors duration-300 relative inline-flex items-center text-lg hover:text-blue-500">
                                <svg width="22" height="22" viewBox="0 0 22 22" class="mr-2">
                                    <g fill="none" fill-rule="evenodd">
                                        <path stroke="#000" stroke-opacity=".012" stroke-width=".5" d="M21 1v20.16H.84V1z">
                                        </path>
                                        <path class="fill-current"
                                            d="M13.854 7.224l-3.847 3.856 3.847 3.856-1.184 1.184-5.04-5.04 5.04-5.04z">
                                        </path>
                                    </g>
                                </svg>

                                Back to Posts
                            </a>

                            <div class="space-x-2">
                                <x-category-button :category="$post->category" class="mt-2" id="post"/>
                            </div>
                        </div>

                        <h1 class="font-bold text-3xl lg:text-4xl mb-10">
                          {{$post->title}}
                        </h1>

                        <div class="py-1 flex pb-4 mb-4 border-b-2">
                            <div class="post-view mr-8" title="views">
                                <span><i class="fa-solid fa-eye mr-2"></i>{{$post->view_count}}</span>
                            </div>

                            <div class="post-bookmark" title="bookmark">
                                @if($is_post_bookmarked)
                                    <form action="{{ route('bookmark.destroy',[$post]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"><i class="fa-solid fa-bookmark text-blue-500"></i></button>
                                    </form>
                                @else
                                    <form action="{{ route('bookmark.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="postId" value={{$post->id}}>
                                        <button type="submit"><i class="fa-regular fa-bookmark text-blue-500"></i></button>
                                    </form>
                                @endif
                            </div>
                        </div>
                        <div class="space-y-4 lg:text-lg leading-loose">
                            {!! $post->body !!}
                        </div>
                    </div>

                    <section class="col-span-8 col-start-5 mt-10 space-y-6">
                        @include ('posts._add-comment-form')
                        @foreach ($post->comments as $comment)
                        <x-post-comment :comment="$comment"/>
                        @endforeach
                    </section>

                </article>
            </main>
        </section>
    </body>
</x-layout>
