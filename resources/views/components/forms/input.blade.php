@props(['name','type' => 'input'])
<x-forms.field>
    <x-forms.label name="{{$name}}" />

    <input type="{{$type}}"
        class="border border-gray-400 p-2 w-full"
        name="{{$name}}"
        id="{{$name}}"
        value="{{ old($name)}}"
        required
    >

    <x-forms.error name="{{$name}}"/>
</x-forms.field>
