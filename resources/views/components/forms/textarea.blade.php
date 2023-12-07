@props(['name'])
<x-forms.field>
    <x-forms.label name="{{$name}}" />

    <textarea class="border border-gray-400 p-2 w-full"
            name="{{$name}}"
            id="{{$name}}"
            required
    >
        {{ old($name)}}
    </textarea>

    <x-forms.error name="{{$name}}"/>
</x-forms.field>
