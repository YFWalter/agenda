<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Reservar Lugar') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <x-auth-validation-error></x-auth-validation-error>
                    <form action="{{ route('my-schedule.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-2 gap-4">

                            <div>
                                <x-input-label for="from[date]" :value="__('Fecha para la cita')" />

                                <x-text-input id="from[date]" class="block mt-1 w-full" type="date" name="from[date]" :value="old('from.date', request('date'))" autofocus />
                            </div>

                            <div>
                                <x-input-label for="from[time]" :value="__('Elije la hora de inicio')" />

                                <x-select-time id="from[time]" init-hour="8" end-hour="17" :selected-hour="old('from.time')" class="block mt-1 w-full" name="from[time]"></x-select-time>
                            </div>

                            <div>
                                <x-input-label for="service_id" :value="__('Elige el servicio')" />

                                <x-select id="service_id" class="block mt-1 w-full" name="service_id">
                                    <option value="">--Selecciona el servicio--</option>
                                    @foreach ($services as $service)
                                        <option value="{{$service->id}}" {{old('service_id') == $service->id ? 'selected' : ''}}> {{$service->name}} </option>
                                    @endforeach
                                </x-select>
                            </div>

                            <div>
                                <x-input-label for="staff_user_id" :value="__('Elige quién te atenderá')" />

                                    <x-select id="staff_user_id" class="block mt-1 w-full" name="staff_user_id">
                                        <option value="">--Selecciona quien te atendera--</option>
                                        @foreach ($staffUsers as $user)
                                            <option value="{{$user->id}}" {{old('staff_user_id') == $user->id ? 'selected' : ''}}> {{$user->name}} </option>
                                        @endforeach
                                    </x-select>
                            </div>
                        </div>

                        <x-primary-button class="mt-4">Reservar</x-button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>