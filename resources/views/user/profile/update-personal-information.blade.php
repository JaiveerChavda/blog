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
