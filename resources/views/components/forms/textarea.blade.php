@props(['name'])
<x-forms.field>
    <x-forms.label name="{{$name}}" />

    <textarea class="border border-gray-200 p-2 w-full rounded"
            name="{{$name}}"
            id="{{$name}}"
            required
    >
        {{$slot ?? old($name)}}
    </textarea>

    <x-forms.error name="{{$name}}"/>
</x-forms.field>
