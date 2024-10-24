<!DOCTYPE html>

<title>Laravel from scratch Blog</title>

<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="alternate" type="application/atom+xml" title="News" href="/blog-feeds">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
<script src="https://kit.fontawesome.com/9f1794eeb4.js" crossorigin="anonymous"></script>
<style>
    html {
        scroll-behavior: smooth;
    }
</style>

@vite('resources/js/app.js')
<x-head.tinymce-config />

@stack('css')

<body style="font-family:Open Sans,sans-serif;">
    @include('feed::links')
    <section class="px-6 py-8">
        <nav class="md:items-center mb-6 flex justify-between">


            {{-- app logo or name--}}
            <div>
                <a href="/" class="flex items-center font-bold text-2xl uppercase tracking-widest">
                    {{ env('APP_NAME') }}
                </a>
            </div>

            <div class="md:mt-0 flex items-center">
                @auth
                    <x-dropdown>
                        <x-slot name='trigger'>
                            <button class="text-sm text-black font-bold"> {{ __('welcome',['name' => auth()->user()->username ]) }}</button>
                        </x-slot>


                        <x-dropdown-item href='/admin/posts' :active="request()->is('/admin/posts')"> Dashboard </x-dropdown-item>
                        <x-dropdown-item href='/admin/posts/create' :active="request()->is('admin/posts/create')"> New Post </x-dropdown-item>


                        <x-dropdown-item href='/profile'>Profile</x-dropdown-item>
                        <x-dropdown-item href='/followers'>Followers</x-dropdown-item>
                        <x-dropdown-item href='/followings'>Followings</x-dropdown-item>

                        <x-dropdown-item href='#' x-data="{}"
                            @click.prevent="document.querySelector('#logout-user').submit()">Log Out</x-dropdown-item>
                        <form action="/logout" method="POST" class="hidden" id="logout-user">
                            @csrf
                        </form>
                    </x-dropdown>
                @else
                    <a href="/register" class="text-xs text-black font-bold uppercase">Register</a>
                    <a href="/login" class="ml-6 text-xs text-black font-bold uppercase">Log In</a>
                @endauth

                <a href="#newsletter" class="ml-6 text-xs text-black font-bold uppercase">subscribe to newsletter</a>

            </div>
        </nav>


        {{ $slot }}

        <footer id="newsletter" class="bg-gray-100 border border-black border-opacity-5 text-center rounded-xl py-16 px-10 mt-16">
            <i class="fa-regular fa-envelope text-3xl mb-2"></i>
            <h5 class="text-3xl">Stay in touch with the latest posts</h5>
            <p>Promise to keep the inbox clean. No bugs.</p>

            <div class="mt-10">
                <div class="relative inline-block lg:bg-gray-200  mx-auto rounded-full">
                    <form action="/newsletter" method="POST" class="lg:flex text-sm">
                        @csrf
                        <div class="lg:py-3 lg:px-5 flex items-center">
                            <label for="email" class="hidden lg:tw-inline-block">
                                <img src="/images/mailbox-icon.svg" alt="mail icon">
                            </label>

                            <div>
                                <input type="email" name="email" id="email" placeholder="Your email address"
                                    class="lg:bg-transparent pl-4 focus-within:outline-none">

                                @error('email')
                                    <span class="test-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>

                        <button type="submit" id="subscribe"
                            class="hover:bg-blue-600 mt-4 lg:mt-0 text-xs font-semibold bg-blue-500 px-6 py-3 text-white uppercase rounded-full lg:ml-3">Subscribe</button>
                    </form>
                </div>
            </div>
        </footer>

    </section>

    <x-flash />

</body>
