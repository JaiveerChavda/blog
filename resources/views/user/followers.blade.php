<x-layout>
    <section class="">

        {{--user dashboard header --}}
        <x-user.header/>

        {{-- user body content  --}}
        <div class="m-auto max-w-7xl">

            <div class="max-w-md">
                <p class="uppercase">All Followers</p>
                @if ($followers->count() > 0)
                    @foreach ($followers as $follower)
                    <div class="flex mt-2">
                        <p class="py-1">{{$follower->name}}</p>
                        <form action="/remove/{{$follower->id}}" class="ml-auto">
                            <button class="bg-red-500 py-1 rounded-2xl text-white ml-auto px-5 text-sm font-bold">remove</button>
                        </form>
                    </div>
                        <hr class="mt-4">
                    @endforeach
                @else
                    <h3 class="text-center text-gray-500 py-8">No followers yet.</h3>
                @endif

            </div>

        </div>
    </section>
</x-layout>
