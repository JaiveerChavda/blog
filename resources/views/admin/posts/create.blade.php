<x-layout>
    <x-setting heading="Publish New Post">

        <form method="POST" action="/admin/posts/" enctype="multipart/form-data">
            @csrf

            <x-forms.input name='title' required/>

            <x-forms.input name='slug' required/>

            <x-forms.input name='thumbnail' type='file' required/>

            <x-forms.textarea name='excerpt' required/>

            <x-forms.textarea name='body' required/>

            <x-forms.field>

                <x-forms.label name='category' />

                <select name="category_id" id="category_id" required>
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

                <x-forms.error name='category_id'/>
            </x-forms.field>

            <x-forms.field>
                <x-forms.button>
                    Publish
                </x-forms.button>
            </x-forms.field>

        </form>

    </x-setting>
</x-layout>
