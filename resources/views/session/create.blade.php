<x-layout>
    <section class="px-6 py-8">
            <main class="max-w-lg mx-auto md:mt-10">
                <x-panel class="bg-gray-100">
                <h1 class="text-center text-xl font-bold">Log In</h1>

                    <form method="POST" action="/login" class="mt-10">
                        @csrf
                        <x-forms.field>
                        <x-forms.input type='email' name='email' autocomplete='username'/>
                        </x-forms.field>

                        <x-forms.field>
                            <x-forms.input type='password' name='password' autocomplete="current-password"/>
                        </x-forms.field>

                        {{-- submit form --}}
                        <x-forms.field>
                            <x-forms.button>Submit</x-forms.button>
                        </x-forms.field>
                    </form>
                </x-panel>
            </main>
    </section>
</x-layout>
