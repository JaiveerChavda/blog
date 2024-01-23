<x-layout>
    <section class="py-8">

        {{--user dashboard header --}}
        <x-user.header/>

        {{-- user body content  --}}
        <div class="mt-16 m-auto max-w-5xl">

            <div class="max-w-md">
                <h1 class="font-semibold text-2xl" style="letter-spacing: -1px">Your Profile</h1>
                <hr class="my-4">
                <ul>
                    <li class="my-4">Name: <span class="ml-3">{{$user->name}}</span><a href="{{ route('profile.edit',[$user]) }}" class="ml-20 text-blue-500">update</a></li>
                    <li class="my-4">Username: <span class="ml-3">{{$user->username}}</span></li>
                    <li class="my-4">Email: <span class="ml-3">{{$user->email}}</span></li>

                </ul>
            </div>

        </div>
    </section>
</x-layout>
