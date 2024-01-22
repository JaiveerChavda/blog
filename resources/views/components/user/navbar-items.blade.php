@props(['name','current' => false])
<a href="{{$name}}" class="mr-6 p-2 hover:underline {{ request()->path() == $name ? 'border-white border-solid border-b-4 font-semibold' : ''}}">{{$slot}}</a>
