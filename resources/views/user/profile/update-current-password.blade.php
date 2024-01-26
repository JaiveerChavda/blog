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
