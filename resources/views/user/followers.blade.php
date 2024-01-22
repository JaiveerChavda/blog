<x-layout>
    <section class="py-8">

        {{--user dashboard header --}}
        <x-user.header/>

        {{-- user body content  --}}
        <div class="mt-16 m-auto max-w-5xl">

            <div class="max-w-md">
                <p class="uppercase">All Followers</p>
                @foreach ($followers as $follower)
                <div class="flex mt-2">
                    <p class="py-1">{{$follower->name}}</p>
                    <form action="/remove/{{$follower->id}}" class="ml-auto">
                        <button class="bg-red-500 py-1 rounded-2xl text-white ml-auto px-5 text-sm font-bold">remove</button>
                    </form>
                </div>
                    <hr class="mt-4">
                @endforeach
            </div>

        </div>
    </section>
</x-layout>
