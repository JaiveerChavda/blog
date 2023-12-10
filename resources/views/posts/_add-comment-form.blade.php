@auth
<x-panel>
    <form method="POST" action="/posts/{{$post->slug}}/comments">
        @csrf

        <header class="flex items-center">
            <img src="https://i.pravatar.cc/100/u={{auth()->id()}}" alt="" width="40" height="40" class="rounded-full">

            <h2 class="ml-4">Want to participate?</h2>
        </header>

        <x-forms.field>

            <x-forms.textarea name='body' :rounded="true"/>
            {{-- <textarea name="body" id="body" rows="5" placeholder="Quick, thing of something to say!" class="w-full text-sm focus:outline-non focus:ring rounded" required></textarea> --}}

            @error('body')
                <p class="text-xs text-red-500">{{$message}}</p>
            @enderror
        </x-forms.field>

        <div class="flex justify-end mt-6 pt-6 border-t border-gray-200">
            <x-forms.button>Post</x-forms.button>
        </div>
    </form>
</x-panel>
@else
<p class="font-semibold">
    <a href="/register" class="hover:underline" >Register</a> or <a href="/login" class="hover:underline">Log in </a>to leave a comment.
</p>
@endauth
