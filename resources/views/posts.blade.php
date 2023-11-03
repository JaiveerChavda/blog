<x-layout>

    @include('_post-header')

    <main class="max-w-6xl mx-auto mt-5 lg:mt-20 space-y-6">
        <!-- main blog -->
        <x-post-featured-card/>
        <!-- two equal blgo layout  -->
        <div class="lg:grid lg:grid-cols-2">
            <x-post-card/>
            <x-post-card/>
        </div>
        <!-- /three blog layout -->
        <div class="lg:grid lg:grid-cols-3">
            <x-post-card/>
            <x-post-card/>
            <x-post-card/>
        </div>
    </main>
</x-layout>
