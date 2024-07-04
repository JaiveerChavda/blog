<x-layout>
    <section class="">

        {{--user dashboard header --}}
        <x-user.header/>

        {{-- user body content  --}}
        <div class="m-auto max-w-7xl">
            <h1 class="font-semibold text-2xl mb-4">Discover new writers to follow:</h1>

            <div class="max-w-lg">
                <p class="uppercase text-xs font-semibold mb-4">writers you follow</p>
                <div class="flex flex-col gap-3">
                    @if ($followings->count()  > 0)
                    @foreach ($followings as $following)
                    <div class="flex gap-4 items-center justify-center border-b-2 py-2">
                        <p class="mb-2">{{$following->username}}</p>
                        <div class="ml-auto">
                            <form action="{{route('unfollow.author',[$following->username])}}" class="" method="POST">
                                @csrf
                                @method('delete')
                                <x-forms.button extClass=' bg-red-500 border-solid border  hover:border-gray-300 border-gray-400'>Unfollow</x-form.button>
                            </form>
                        </div>
                        {{-- <a href="{{ route('unfollow.author',[$following->username])}}"
                        class="bg-red-500 py-1 rounded-2xl text-white ml-auto px-5 text-sm font-bold">UnFollow</a> --}}
                    </div>
                    @endforeach
                @else
                    <p class="text-center text-gray-500 py-8">You are not following any authors yet.</p>
                @endif
                </div>
            </div>

        </div>
    </section>
</x-layout>
