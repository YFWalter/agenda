<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Asignacion de servicios de {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <x-auth-validation-error></x-auth-validation-error>
                    <form action="{{ route('users-services.update', ['user' => $user->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                @foreach ($services as $service)
                                    <label for="service_{{ $service->id }}" class="block"><input type="checkbox" name="services_ids[]" {{ $user->services->contains($service) ? 'checked' : '' }} value="{{ $service->id }}" id="service_{{ $service->id }}"> {{ $service->name }} </label>
                                @endforeach
                            </div>
                        </div>

                        <x-primary-button class="mt-4">Actualizar</x-button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>