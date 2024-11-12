<form action="{{route('profile.update',[$user->id])}}" method="post" enctype="multipart/form-data">
    @method('PUT')
    @csrf
    <x-forms.input name='name' :value="$user->name"/>

    <x-forms.input name='username' :value="$user->username"/>

    <x-forms.input name='email' readonly :value="$user->email"/>

    <x-forms.input name='avatar' type='file'/>

    <img src="{{$user->avatar}}" alt="profile-photo" class="h-24 rounded-2xl mt-4">

    <x-forms.field>
        <x-forms.button >Save</x-forms.button>
    </x-forms.field>
</form>
