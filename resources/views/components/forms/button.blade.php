@props(['extClass'])
@php
    $class = 'px-10 py-2 rounded-2xl text-xs font-semibold';

    $class .= $extClass ?? ' bg-blue-500 text-white  hover:bg-blue-600';

@endphp

<button type="submit" class="{{$class}}">
    {{$slot}}
</button>
