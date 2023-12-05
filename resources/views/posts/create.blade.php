<x-layout>
    <section class="py-8 max-w-md m-auto">
        <h1 class="text-lg font-bold mb-4">
            Publish New Post
        </h1>


        <x-panel>
            <form method="POST" action="/admin/posts/" enctype="multipart/form-data">
                @csrf
                <div class="mb-6">
                    <label class="block mb-2 uppercase font-bold text-xs text-gray-700"
                        for="title">
                        Title
                    </label>

                    <input type="text"
                        class="border border-gray-400 p-2 w-full"
                        name="title"
                        id="title"
                        required
                    >

                    @error('title')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block mb-2 uppercase font-bold text-xs text-gray-700"
                        for="slug">
                        Slug
                    </label>

                    <input type="text"
                           class="border border-gray-400 p-2 w-full"
                           name="slug"
                           id="slug"
                           required
                           value="{{ old('slug') }}"
                    >

                    @error('slug')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block mb-2 uppercase font-bold text-xs text-gray-700"
                        for="thumbnail">
                        Thumbnail
                    </label>

                    <input type="file"
                           class="border border-gray-400 p-2 w-full"
                           name="thumbnail"
                           id="thumbnail"
                           required
                    >

                    @error('thumbnail')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block mb-2 uppercase font-bold text-xs text-gray-700"
                        for="excerpt">
                        Excerpt
                    </label>

                    <textarea class="border border-gray-400 p-2 w-full"
                                name="excerpt"
                                id="excerpt"
                    >
                    {{ old('excerpt')}}
                    </textarea>

                    @error('excerpt')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block mb-2 uppercase font-bold text-xs text-gray-700"
                        for="body">
                        Body
                    </label>

                    <textarea  class="border border-gray-400 p-2 w-full"
                                name="body"
                               id="body"
                    >
                        {{old('body')}}
                    </textarea>

                    @error('body')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block mb-2 uppercase font-bold text-xs text-gray-700"
                        for="category_id">
                        Category
                    </label>

                    <select name="category_id" id="category_id">
                        @php
                            $categories = \App\Models\Category::all();
                        @endphp
                        @foreach ($categories as $category)
                            <option value="{{$category->id}}"
                                {{ old('category_id') == $category->id ? 'selected' : '' }}
                                >
                                {{ucwords($category->name)}}
                            </option>
                        @endforeach
                    </select>

                    @error('category_id')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <x-submit-button>Publish</x-submit-button>
            </form>
        </x-panel>
    </section>
</x-layout>
