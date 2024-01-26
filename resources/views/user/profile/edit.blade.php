<x-layout>
    <section class="">

        {{--user dashboard header --}}
        <x-user.header/>

        {{-- user body content  --}}
        <div class="mt-16 m-auto max-w-md">
            <h1 class="text-2xl mb-4 font-semibold">Your Profile</h1>
            <x-panel>
                <form action="{{route('profile.update',[$user->id])}}" method="post">
                    @method('PUT')
                    @csrf
                    <x-forms.input name='name' :value="$user->name"/>

                    <x-forms.input name='username' :value="$user->username"/>

                    <x-forms.input name='email' readonly :value="$user->email"/>

                    <x-forms.field>
                        <x-forms.button >Save</x-forms.button>
                    </x-forms.field>
                </form>
            </x-panel>

            <h1 class="text-xl my-4 font-semibold">Update Password</h1>
            <x-panel>
                <form action="{{route('password.update')}}" method="post">
                    @method('PUT')
                    @csrf
                    <x-forms.input name='current_password' type='password'/>
                    <p class="text-red-500 text-xs mt-2"> {{$errors->updatePassword->first('current_password') }}</p>

                    <x-forms.input name='password' type='password'/>
                    <p class="text-red-500 text-xs mt-2"> {{$errors->updatePassword->first('password') }}</p>


                    <x-forms.input name='password_confirmation' type='password'/>
                    <p class="text-red-500 text-xs mt-2"> {{$errors->updatePassword->first('password_confirmation') }}</p>

                    <x-forms.field>
                        <x-forms.button >Save</x-forms.button>
                    </x-forms.field>
                </form>
            </x-panel>
        </div>
    </section>
</x-layout>
