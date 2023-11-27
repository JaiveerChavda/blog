@if (session()->has('success'))
<div x-data="{ show : true }"
     x-init="setTimeout(() => show = false, 4000)"
     x-show="show"
    class="fixed bottom-3 right-5 bg-blue-500 text-white text-sm font-semibold py-2 px-6 rounded-2xl"
>

    <p class="">{{session('success')}}</p>
</div>
@endif
