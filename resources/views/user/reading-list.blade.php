<x-layout>
    @push('css')
    <style>
        .middot::before {
            display: inline-block;
            content: "";
            border-radius: 50%;
            height: 4px;
            margin: 0px 6px;
            position: relative;
            background-color: #8b7c7c;
            top: -3px;
            width: 4px
        }
    </style>
    @endpush
    <section class="py-8">

        {{--user dashboard header --}}
        <x-user.header/>

        <div class="flex justify-center max-w-7xl mx-auto my-6 px-22 gap-8">

            <div class="saved-articles w-8/12">

                @if ($posts->count())
                    <div class="saved-articles_lists">
                        <h1 class="text-2xl font-semibold mb-2">Saved Articles</h1>

                        @foreach ($posts as $post)
                            <div class="saved-article flex flex-row gap-9 justify-between py-4 border-b-2">

                                <div class="saved-article_text text-xs">

                                    <div class="saved-article_meta mb-2">
                                        <span>{{$post->published_at->format('d  M, Y')}}</span> <span class="middot uppercase">{{ $post->category->name }}</span>
                                    </div>

                                    <a href="{{ route('post.show',[$post->slug]) }}" class="saved-article_title font-semibold text-lg tracking-wide">{{ $post->title }}</a>

                                    <div class="saved-article_author mb-4 mt-2 text-xs">
                                        By <span class="font-semibold mx-1">{{ $post->author->name }}</span>
                                    </div>

                                    <div class="saved-article_icons">
                                        <form action="{{ route('bookmark.destroy',[$post]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"><i class="fa-solid fa-bookmark text-blue-500"></i></button>
                                        </form>                              {{-- <button type="submit"><i class="fa-solid fa-bookmark text-blue-500"></i></button> --}}
                                    </div>

                                </div>

                                <a class="saved-article__image-container" href="{{ route('post.show',[$post->slug]) }}">
                                    <img src="{{ asset('/storage/'.$post->thumbnail) }}" alt="article_image" class="h-32 object-cover w-60">
                                </a>

                            </div>
                        @endforeach

                    </div>
                @else
                    <h1 class="text-2xl font-semibold text-center">No Saved Articles</h1>
                @endif
            </div>

            <div class="border-l-2 border-solid pl-8 recommended-articles w-96">
                <h1 class="text-2xl font-semibold">You May Also Like</h1>
            </div>
        </div>
    </section>
</x-layout>
