<x-layout>
    <section class="px-6 py-8">
            <main class="max-w-md mx-auto md:mt-10">
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
                        <x-forms.field class="text-center">
                            <x-forms.button
                            extClass="border-solid border  hover:border-gray-300 border-gray-400"
                            >Login</x-forms.button>
                        </x-forms.field>
                    </form>

                    <div class="flex justify-center my-4">
                        <form action="{{ url('auth/redirect?type=google')  }}"  method="POST">
                            @csrf
                            <x-forms.button
                            extClass="border-solid border  hover:border-gray-300 border-gray-400"
                            >
                                <x-logos.google/>
                                <span>login with google</span>
                            </x-forms.button>
                        </form>
                    </div>
                </x-panel>
            </main>
    </section>
</x-layout>
