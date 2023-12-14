@props(['heading'])
<section class="py-8 max-w-4xl m-auto">

    <h1 class="text-lg font-bold mb-4 border-b mb-8 pb-2">
        {{ $heading }}
    </h1>

    <div class="flex">
        <aside class="w-48">
            <h4 class="font-semibold mb-4">Links</h4>


            <ul>
                <li>
                    <a href="{{ route('admin.posts.index') }}"
                        class="{{request()->routeIs('admin.posts.index') ? 'text-blue-500' : ''}}"
                        >All Posts
                    </a>
                </li>
                <li>
                    <a href=" {{ route('admin.posts.create') }}"
                        class="{{request()->routeIs('admin.posts.create') ? 'text-blue-500' : ''}}"
                        >New post
                    </a>
                </li>
            </ul>
        </aside>

        <main class="flex-1">
            <x-panel>
                {{ $slot }}
            </x-panel>
        </main>
    </div>
</section>
