<x-app-layout>
    <x-slot name="headers">
        <style>
            [x-cloak] {
                display: none;
            }
        </style>
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Mi Agenda') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <div class="flex">
                        <div class="w-1/3">
                            <x-calendar url-handler="{{ route('staff-scheduler.index') }}"></x-calendar>
                        </div>
                        <div class="w-2/3 py-8 px-5">
                            <h3 class="font-bold text-lg"> Mis citas acá: {{$date->isoFormat('dddd Do MMMM YYYY')}}</h3>
                            <x-auth-validation-error></x-auth-validation-error>
                            @foreach ($dayScheduler as $schedule)
                                <div class="flex items-center mt-2 bg-indigo-100 p-3 rounded">
                                    <div class="w-1/2">
                                        <div>Servicio: {{ $schedule->service->name}} - A: {{ $schedule->clientUser->name}}</div>
                                        <div>Desde:<span class="font-bold"> {{$schedule->from->format('H:i')}} </span> - Hasta: <span class="font-bold"> {{$schedule->to->format('H:i')}} </span></div>
                                    </div>
                                    <div>
                                        <form action="{{ route('staff-scheduler.destroy', ['scheduler' => $schedule->id]) }}" onsubmit="return confirm('¿Realmente quiere cancelar esta cita?')" method="POST" class="inline-block">
                                            @method('DELETE')
                                            @csrf
                                            <x-primary-button :disabled="auth()->user()->cannot('delete', $schedule)">Cancelar</x-primary-button>
                                        </form>
                                         
                                        <x-link href="{{ route('staff-scheduler.edit', ['scheduler' => $schedule->id]) }}" :disabled="auth()->user()->cannot('update', $schedule)">
                                            Reagendar
                                        </x-link>
                                    </div>
                                </div>    
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>