<div class="pt-28">
    <div class="container px-3 mx-auto flex flex-wrap flex-col md:flex-row items-center">
    <!--Left Col-->
    <div class="flex flex-col w-full md:w-2/5 justify-center items-start text-center md:text-left">
        <p class="uppercase tracking-loose w-full">Reserva de citas online</p>
        <h1 class="my-4 text-5xl font-bold leading-tight">
        Tu próxima cita, sin llamadas ni esperas
        </h1>
        <p class="leading-normal text-2xl mb-8">
        Elige tu servicio, el día y la hora que prefieras. MiAgenda te muestra la disponibilidad real de nuestro equipo y confirma tu cita al instante.
        </p>
        <div class="w-full flex flex-col sm:flex-row items-center md:items-start gap-4">
            @auth
            <a href="{{ url('/dashboard') }}" class="mx-auto sm:mx-0 hover:underline bg-white text-gray-800 font-bold rounded-full py-4 px-8 shadow-lg focus:outline-none focus:shadow-outline transform transition hover:scale-105 duration-300 ease-in-out">
                Ir a mi agenda
            </a>
            @else
            <a href="{{ url('/register') }}" class="mx-auto sm:mx-0 hover:underline bg-white text-gray-800 font-bold rounded-full py-4 px-8 shadow-lg focus:outline-none focus:shadow-outline transform transition hover:scale-105 duration-300 ease-in-out">
                Reservar ahora
            </a>
            <a href="{{ url('/login') }}" class="mx-auto sm:mx-0 hover:underline border-2 border-white text-white font-bold rounded-full py-4 px-8 focus:outline-none focus:shadow-outline transform transition hover:scale-105 duration-300 ease-in-out">
                Iniciar sesión
            </a>
            @endauth
        </div>
    </div>
    <!--Right Col-->
    <div class="w-full md:w-3/5 py-6 text-center">
        <!-- Ilustración: tarjeta de cita confirmada -->
        <svg class="w-full md:w-4/5 mx-auto z-50" viewBox="0 0 480 360" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Cita confirmada en el calendario">
            <defs>
                <linearGradient id="hero-accent" x1="0" y1="0" x2="1" y2="1">
                    <stop offset="0" stop-color="#36d1dc" />
                    <stop offset="1" stop-color="#5b86e5" />
                </linearGradient>
            </defs>
            <!-- Tarjeta principal -->
            <rect x="70" y="50" width="340" height="260" rx="20" fill="#ffffff" />
            <rect x="70" y="50" width="340" height="64" rx="20" fill="url(#hero-accent)" />
            <rect x="70" y="94" width="340" height="20" fill="url(#hero-accent)" />
            <!-- Aros del calendario -->
            <rect x="130" y="36" width="14" height="34" rx="7" fill="#2a2a31" />
            <rect x="230" y="36" width="14" height="34" rx="7" fill="#2a2a31" />
            <rect x="330" y="36" width="14" height="34" rx="7" fill="#2a2a31" />
            <!-- Encabezado: mes -->
            <text x="100" y="92" font-family="Source Sans Pro, sans-serif" font-size="22" font-weight="700" fill="#ffffff">Tu cita</text>
            <!-- Filas de horarios -->
            <rect x="100" y="140" width="180" height="14" rx="7" fill="#e2e8f0" />
            <rect x="100" y="168" width="240" height="14" rx="7" fill="#e2e8f0" />
            <!-- Slot seleccionado -->
            <rect x="100" y="200" width="280" height="48" rx="12" fill="#eef2ff" stroke="url(#hero-accent)" stroke-width="2" />
            <circle cx="128" cy="224" r="14" fill="url(#hero-accent)" />
            <path d="M121 224 l5 5 l9 -10" fill="none" stroke="#ffffff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
            <rect x="156" y="214" width="120" height="10" rx="5" fill="#5b86e5" />
            <rect x="156" y="230" width="80" height="8" rx="4" fill="#94a3b8" />
            <!-- Botón confirmar -->
            <rect x="100" y="264" width="280" height="30" rx="15" fill="url(#hero-accent)" />
            <text x="240" y="284" text-anchor="middle" font-family="Source Sans Pro, sans-serif" font-size="14" font-weight="700" fill="#ffffff">Cita confirmada</text>
        </svg>
    </div>
    </div>
</div>
<div class="relative -mt-12 lg:-mt-24">
    <svg viewBox="0 0 1428 174" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <g transform="translate(-2.000000, 44.000000)" fill="#FFFFFF" fill-rule="nonzero">
        <path d="M0,0 C90.7283404,0.927527913 147.912752,27.187927 291.910178,59.9119003 C387.908462,81.7278826 543.605069,89.334785 759,82.7326078 C469.336065,156.254352 216.336065,153.6679 0,74.9732496" opacity="0.100000001"></path>
        <path
            d="M100,104.708498 C277.413333,72.2345949 426.147877,52.5246657 546.203633,45.5787101 C666.259389,38.6327546 810.524845,41.7979068 979,55.0741668 C931.069965,56.122511 810.303266,74.8455141 616.699903,111.243176 C423.096539,147.640838 250.863238,145.462612 100,104.708498 Z"
            opacity="0.100000001"
        ></path>
        <path d="M1046,51.6521276 C1130.83045,29.328812 1279.08318,17.607883 1439,40.1656806 L1439,120 C1271.17211,77.9435312 1140.17211,55.1609071 1046,51.6521276 Z" id="Path-4" opacity="0.200000003"></path>
        </g>
        <g transform="translate(-4.000000, 76.000000)" fill="#FFFFFF" fill-rule="nonzero">
        <path
            d="M0.457,34.035 C57.086,53.198 98.208,65.809 123.822,71.865 C181.454,85.495 234.295,90.29 272.033,93.459 C311.355,96.759 396.635,95.801 461.025,91.663 C486.76,90.01 518.727,86.372 556.926,80.752 C595.747,74.596 622.372,70.008 636.799,66.991 C663.913,61.324 712.501,49.503 727.605,46.128 C780.47,34.317 818.839,22.532 856.324,15.904 C922.689,4.169 955.676,2.522 1011.185,0.432 C1060.705,1.477 1097.39,3.129 1121.236,5.387 C1161.703,9.219 1208.621,17.821 1235.4,22.304 C1285.855,30.748 1354.351,47.432 1440.886,72.354 L1441.191,104.352 L1.121,104.031 L0.457,34.035 Z"
        ></path>
        </g>
    </g>
    </svg>
</div>
