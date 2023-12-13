<x-layout>
    <section class="px-6 py-8">
        <main class="max-w-lg mx-auto mt-10 bg-gray-100 border border-gray-200 p-6 rounded-xl ">
            <h1 class="text-center text-xl font-bold">Register</h1>

                <form method="POST" action="/register" class="mt-10">

                    @csrf
                    <x-forms.field>
                        <x-forms.input name='name' required/>
                    </x-forms.field>

                    <x-forms.field>
                        <x-forms.input name='username' required/>
                    </x-forms.field>

                    <x-forms.field>
                        <x-forms.input name='email'  required/>
                    </x-forms.field>

                    <x-forms.field>
                        <x-forms.input type='password' name='password' required/>
                    </x-forms.field>

                    {{-- submit button --}}

                    <x-forms.field>
                        <x-forms.button> Submit </x-forms.button>
                    </x-forms.field>

                </form>
        </main>
    </section>
</x-layout>
