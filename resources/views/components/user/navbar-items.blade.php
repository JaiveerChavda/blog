@props(['name','current' => false,'url'])
<a href="{{$url}}" class="mr-6 p-2 hover:underline {{ request()->url() == $url ? 'border-white border-solid border-b-4 font-semibold' : ''}}">{{$slot}}</a>
