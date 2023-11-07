@props(['posts'])

<!-- main blog -->
<x-post-featured-card :post="$posts[0]" />

@if ($posts->count() > 1)
    <!-- two equal blgo layout  -->
    <div class="lg:grid lg:grid-cols-6">
        @foreach ($posts->skip(1) as $post)
            <x-post-card
                :post="$post"
                class="{{$loop->iteration < 3 ? 'col-span-3' : 'col-span-2'}}"
            />
        @endforeach
        {{-- <x-post-card/> --}}
    </div>
@endif
