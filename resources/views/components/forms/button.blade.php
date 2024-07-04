@props(['extClass'])
@php
    $class = 'px-10 py-2 rounded-2xl text-xs font-semibold';

    $class .= $extClass ?? ' bg-blue-500 text-white  hover:bg-blue-600';

@endphp

<button type="submit" class="{{$class}}"
    {{-- class="bg-blue-500 text-white px-10 py-2 rounded-2xl text-xs font-semibold hover:bg-blue-600 " --}}
    {{-- class="px-10 py-2 rounded-2xl text-xs font-semibold border-solid border  hover:border-gray-300 border-gray-600" --}}
    >
    {{$slot}}
</button>
