@props(['name'])
<x-forms.field>
    <x-forms.label name="{{$name}}" />

    <input
        class="border border-gray-200 p-2 w-full"
        name="{{$name}}"
        id="{{$name}}"
        {{ $attributes(['value' => old($name) ]) }}
    >

    <x-forms.error name="{{$name}}"/>
</x-forms.field>
