<x-layout>
    <section class="">

        {{--user dashboard header --}}
        <x-user.header/>

        {{-- user body content  --}}
        <div class="m-auto max-w-7xl ">
            <a href="{{ route('profile.index') }}" class="hover:underline"><i class="fa-solid fa-arrow-left"></i> back</a>

            <div class="max-w-md my-4">

                <h1 class="text-2xl mb-4 font-semibold">Your Profile</h1>

                <x-panel>
                    @include('user.profile.update-personal-information')
                </x-panel>

                <h1 class="text-xl my-4 font-semibold">Update Password</h1>
                <x-panel>
                    @include('user.profile.update-current-password')
                </x-panel>
            </div>

        </div>
    </section>
</x-layout>
