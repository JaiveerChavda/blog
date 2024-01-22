<x-layout>
    <section class="py-8">

        {{--user dashboard header --}}
        <x-user.header/>

        {{-- user body content  --}}
        <div class="mt-16 m-auto max-w-5xl">
            <h1 class="font-semibold text-2xl mb-4">Discover new writers to follow:</h1>

            <div class="max-w-lg">
                <p class="uppercase text-xs font-semibold mb-4">writers you follow</p>

                @foreach ($followings as $following)
                    <p class="py-1">{{$following->name}}</p>
                    <p class="mb-2">{{$following->username}}</p>
                    <a href="{{ route('unfollow.author',[$following->username])}}"
                        class="bg-red-500 py-1 rounded-2xl text-white ml-auto px-5 text-sm font-bold">UnFollow</a>
                    <hr class="mt-4">
                @endforeach
            </div>

        </div>
    </section>
</x-layout>
