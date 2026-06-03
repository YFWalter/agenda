<x-site-layout>
    <!-- Encabezado -->
    <div class="pt-28 pb-16 text-center container mx-auto px-4">
        <p class="uppercase tracking-loose text-sm mb-2">Acerca de</p>
        <h1 class="my-2 text-4xl sm:text-5xl font-bold leading-tight">
            Una demostración funcional
        </h1>
        <p class="text-xl leading-normal max-w-2xl mx-auto mt-4">
            MiAgenda es una aplicación de ejemplo de un sistema de reserva de citas para un salón de belleza. Está completamente funcional, pero los datos que ves son de prueba: no corresponde a un negocio real.
        </p>
        <span class="inline-block mt-6 text-xs font-bold uppercase tracking-wide bg-white text-gray-700 rounded-full px-4 py-2">
            Proyecto demostrativo · datos de ejemplo
        </span>
    </div>

    <!-- Roles -->
    <section class="bg-white text-gray-800 py-12">
        <div class="container max-w-5xl mx-auto px-4">
            <h2 class="w-full my-2 text-4xl font-bold leading-tight text-center">¿Qué puedes hacer?</h2>
            <div class="w-full mb-8">
                <div class="h-1 mx-auto gradient w-64 opacity-25 my-0 py-0 rounded-t"></div>
            </div>
            <div class="flex flex-wrap">
                <div class="w-full md:w-1/3 p-4">
                    <div class="bg-white rounded-lg shadow h-full p-6 text-center">
                        <div class="text-xl font-bold mb-2">Cliente</div>
                        <p class="text-gray-600">Reserva citas online eligiendo servicio, día y hora según la disponibilidad real, y gestiona o cancela sus propias citas.</p>
                    </div>
                </div>
                <div class="w-full md:w-1/3 p-4">
                    <div class="bg-white rounded-lg shadow h-full p-6 text-center">
                        <div class="text-xl font-bold mb-2">Personal</div>
                        <p class="text-gray-600">Consulta y gestiona su propia agenda de citas, con los servicios que tiene asignados.</p>
                    </div>
                </div>
                <div class="w-full md:w-1/3 p-4">
                    <div class="bg-white rounded-lg shadow h-full p-6 text-center">
                        <div class="text-xl font-bold mb-2">Administración</div>
                        <p class="text-gray-600">Administra usuarios, servicios y horarios de atención del salón, y puede impersonar cuentas para dar soporte.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tecnología -->
    <section class="bg-gray-100 text-gray-800 py-12">
        <div class="container max-w-5xl mx-auto px-4 text-center">
            <h2 class="w-full my-2 text-4xl font-bold leading-tight">Construido con</h2>
            <div class="w-full mb-8">
                <div class="h-1 mx-auto gradient w-64 opacity-25 my-0 py-0 rounded-t"></div>
            </div>
            <div class="flex flex-wrap justify-center gap-3">
                <span class="bg-white shadow rounded-full px-5 py-2 font-semibold">Laravel</span>
                <span class="bg-white shadow rounded-full px-5 py-2 font-semibold">Blade</span>
                <span class="bg-white shadow rounded-full px-5 py-2 font-semibold">Tailwind CSS</span>
                <span class="bg-white shadow rounded-full px-5 py-2 font-semibold">Alpine.js</span>
                <span class="bg-white shadow rounded-full px-5 py-2 font-semibold">Vite</span>
                <span class="bg-white shadow rounded-full px-5 py-2 font-semibold">Spatie Permission</span>
                <span class="bg-white shadow rounded-full px-5 py-2 font-semibold">Laravel Sanctum</span>
            </div>
        </div>
    </section>

    <!-- Código / contacto -->
    <section class="container mx-auto text-center py-16 px-4">
        <h2 class="my-2 text-4xl font-bold leading-tight text-white">¿Quieres ver el código?</h2>
        <p class="text-lg leading-normal mb-6 max-w-xl mx-auto">
            El proyecto está disponible en GitHub. Eres libre de revisarlo, clonarlo y probarlo.
        </p>
        <a href="https://github.com/YFWalter/agenda" target="_blank" rel="noopener"
           class="inline-block hover:underline bg-white text-gray-800 font-bold rounded-full py-4 px-8 shadow-lg focus:outline-none focus:shadow-outline transform transition hover:scale-105 duration-300 ease-in-out">
            Ver en GitHub
        </a>
    </section>
</x-site-layout>
