<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear nuevo usuario') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <x-auth-validation-error></x-auth-validation-error>
                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-2 gap-4">

                            <div>
                                <x-input-label for="name" :value="__('Nombre')" />

                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" autofocus placeholder="Nombre del usuario" />
                            </div>

                            <div>
                                <x-input-label for="email" :value="__('Correo electrónico')" />

                                <x-text-input type="text" id="email" class="block mt-1 w-full" name="email" :value="old('email')" placeholder="Correo electrónico del usuario" />
                            </div>

                            <div>
                                <x-input-label for="roles_ids" :value="__('Tipo de usuario')" />

                                @foreach ($roles as $role)
                                    <label class="block"><input  name="roles_ids[]" type="checkbox" value="{{ $role->id }}" {{ (in_array($role->id, (array) old('roles_ids'))) ? 'checked' : '' }}>
                                        {{ ucfirst($role->name) }}
                                    </label>
                                @endforeach
                            </div>


                        </div>
                        <div class="mt-4 bg-indigo-300 px-3 py-4 rounded border-2 border-indigo-400">
                            Se enviará un correo electrónico al usuario para que establezca su contraseña.
                        </div>
                        <x-primary-button class="mt-4">Crear</x-primary-button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>