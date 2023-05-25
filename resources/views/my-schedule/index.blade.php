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
                            <x-calendar url-handler="{{ route('my-schedule') }}"> </x-calendar>                    
                        </div>
                        <div class="w-2/3 py-8 px-5">
                            <h3 class="font-bold text-lg"> Mis citas acá: {{$date->isoFormat('dddd Do MMMM YYYY')}}</h3>
                            <x-auth-validation-error></x-auth-validation-error>
                            @foreach ($dayScheduler as $schedule)
                                <div class="flex items-center mt-2 bg-indigo-100 p-3 rounded">
                                    <div class="w-1/2">
                                        <div>Servicio: {{ $schedule->service->name}} - Con: {{ $schedule->staffUser->name}}</div>
                                        <div>Desde:<span class="font-bold"> {{$schedule->from->format('H:i')}} </span> - Hasta: <span class="font-bold"> {{$schedule->to->format('H:i')}} </span></div>
                                    </div>
                                    <div>
                                        @can('delete', $schedule)    
                                            <form action="{{ route('my-schedule.destroy', ['scheduler' => $schedule->id]) }}" onsubmit="return confirm('¿Realmente quiere cancelar esta cita?')" method="POST" class="inline-block">
                                                @method('DELETE')
                                                @csrf
                                                <x-danger-button>Cancelar</x-danger-button>
                                            </form>
                                        @endcan
                                        <x-link href="{{ route('my-schedule.edit', ['scheduler' => $schedule->id]) }}">
                                            Reagendar
                                        </x-link>
                                    </div>
                                </div>    
                            @endforeach
                            <x-link class="mt-2" href="{{ route('my-schedule.create',['date' => $date->format('Y-m-d')]) }}"> Reservar Lugar </x-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>