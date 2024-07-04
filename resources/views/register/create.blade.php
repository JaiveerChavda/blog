<x-layout>
    <section class="px-6 py-8">
        <main class="max-w-md mx-auto md:mt-10 bg-gray-100 border border-gray-200 p-6 rounded-xl ">
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

                    <x-forms.field class="text-center">
                        <x-forms.button
                            extClass="border-solid border  hover:border-gray-300 border-gray-400"
                        > Register
                    </x-forms.button>
                    </x-forms.field>

                </form>

                <div class="flex justify-center my-4">
                    <form action="{{ url('auth/redirect?type=google')  }}"  method="POST">
                        @csrf
                        <x-forms.button
                            extClass="border-solid border  hover:border-gray-300 border-gray-400"
                        >
                            <x-logos.google/>
                            <span>Login with Google</span></x-forms.button>
                    </form>
                </div>
        </main>
    </section>
</x-layout>
