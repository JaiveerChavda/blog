<x-layout>
    <section class="">

        {{--user dashboard header --}}
        <x-user.header/>

        {{-- user body content  --}}
        <div class="m-auto max-w-7xl">

            <div class="max-w-md user-profile-container flex max-w-4xl justify-between gap-4 items-center">
                <div class="user-profile-information">
                    <h1 class="font-semibold text-2xl" style="letter-spacing: -1px">Your Profile</h1>
                    <hr class="my-4">
                    <ul>
                        <li class="my-4">Name: <span class="ml-3">{{$user->name}}</span><a href="{{ route('profile.edit',[$user]) }}" class="ml-20 text-blue-500">update</a></li>
                        <li class="my-4">Username: <span class="ml-3">{{$user->username}}</span></li>
                        <li class="my-4">Email: <span class="ml-3">{{$user->email}}</span></li>

                    </ul>
                </div>

                <img src="{{asset('storage/'.$user->avatar)}}" alt="profile-image" class="h-16 w-auto">
                {{-- <div class="user-profile-photo">

                </div> --}}
            </div>

        </div>
    </section>
</x-layout>
