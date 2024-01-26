<div class="text-white bg-black pt-4 px-4 mb-8">
    <a href="/">
        <i class="fa-solid fa-arrow-left"></i>
        <span class="hover:underline">back</span>
    </a>
    <h1 class="text-4xl font-semibold mt-4 mb-14">Hello, {{ auth()->user()->name }}</h1>

    <div class="flex max-w-2xl">
        <x-user.navbar-items name='profile'>Profile</x-user.navbar-items>
        <x-user.navbar-items name='followers'>Followers</x-user.navbar-items>
        <x-user.navbar-items name='followings'>Followings</x-user.navbar-items>
        <x-user.navbar-items name='reading-list'>Reading List</x-user.navbar-items>
    </div>
</div>
