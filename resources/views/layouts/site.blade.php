<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>
      MiAgenda - Reserva tu cita online
    </title>
    <meta name="description" content="Reserva tus citas online en segundos: elige servicio, día y hora según la disponibilidad real del salón." />
    <meta name="keywords" content="reserva de citas, agenda online, peluquería, salón de belleza, barbería" />
    <meta name="author" content="MiAgenda" />
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700" rel="stylesheet" />
    <!-- Define your gradient here - use online tools to find a gradient matching your branding-->
    <style>
      .gradient {
        background: linear-gradient(90deg,  #36d1dc 0, #5b86e5 100%);
      }
    </style>
  </head>
  <body class="leading-normal tracking-normal text-white gradient" style="font-family: 'Source Sans Pro', sans-serif;">

    <!-- Barra de demostración -->
    <div class="fixed top-0 left-0 w-full z-40 h-8 flex items-center justify-center px-4 text-center text-xs sm:text-sm bg-gray-900 text-white">
      <span class="font-semibold tracking-wide">Versión demostrativa</span>
      <span class="hidden sm:inline">&nbsp;· proyecto funcional con datos de ejemplo</span>
    </div>

    @include('layouts.navigation-site')

    {{ $slot }}
    
    <!--Footer-->
    <footer class="bg-white">
      <div class="container mx-auto px-8">
        <div class="w-full flex flex-col md:flex-row py-6">
          <div class="flex-1 mb-6 text-black">
            <a class="text-gray-800 no-underline hover:no-underline font-bold text-2xl lg:text-4xl" href="{{ url('/') }}">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-8 inline align-middle" width="32" height="32" fill="none" viewBox="0 0 24 24">
                <rect x="3" y="5" width="18" height="16" rx="2.5" stroke="#5b86e5" stroke-width="1.8" />
                <path d="M3 9h18" stroke="#5b86e5" stroke-width="1.8" />
                <path d="M8 3v3M16 3v3" stroke="#36d1dc" stroke-width="1.8" stroke-linecap="round" />
                <path d="M9 14.5l2 2 4-4" stroke="#36d1dc" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
              </svg>
              MiAgenda
            </a>
          </div>
          <div class="flex-1">
            <p class="uppercase text-gray-500 md:mb-6">MiAgenda</p>
            <ul class="list-reset mb-6">
              <li class="mt-2 inline-block mr-2 md:block md:mr-0">
                <a href="#servicios" class="no-underline hover:underline text-gray-800 hover:text-pink-500">Servicios</a>
              </li>
              <li class="mt-2 inline-block mr-2 md:block md:mr-0">
                <a href="{{ url('/about') }}" class="no-underline hover:underline text-gray-800 hover:text-pink-500">Acerca de</a>
              </li>
            </ul>
          </div>
          <div class="flex-1">
            <p class="uppercase text-gray-500 md:mb-6">Cuenta</p>
            <ul class="list-reset mb-6">
              <li class="mt-2 inline-block mr-2 md:block md:mr-0">
                <a href="{{ url('/login') }}" class="no-underline hover:underline text-gray-800 hover:text-pink-500">Iniciar sesión</a>
              </li>
              <li class="mt-2 inline-block mr-2 md:block md:mr-0">
                <a href="{{ url('/register') }}" class="no-underline hover:underline text-gray-800 hover:text-pink-500">Regístrate</a>
              </li>
            </ul>
          </div>
          <div class="flex-1">
            <p class="uppercase text-gray-500 md:mb-6">Proyecto</p>
            <ul class="list-reset mb-6">
              <li class="mt-2 inline-block mr-2 md:block md:mr-0">
                <a href="https://github.com/YFWalter/agenda" target="_blank" rel="noopener" class="no-underline hover:underline text-gray-800 hover:text-pink-500">Código en GitHub</a>
              </li>
              <li class="mt-2 inline-block mr-2 md:block md:mr-0">
                <a href="{{ url('/about') }}" class="no-underline hover:underline text-gray-800 hover:text-pink-500">Sobre la demo</a>
              </li>
            </ul>
          </div>
        </div>
        <div class="border-t border-gray-200 py-4 text-center text-gray-500 text-sm">
          &copy; {{ date('Y') }} MiAgenda · Versión demostrativa con datos de ejemplo.
        </div>
      </div>
    </footer>
    <!-- jQuery if you need it
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  -->
    <script>
      var scrollpos = window.scrollY;
      var header = document.getElementById("header");
      var navcontent = document.getElementById("nav-content");
      var navactions = document.querySelectorAll(".navAction");
      var brandname = document.getElementById("brandname");
      var toToggle = document.querySelectorAll(".toggleColour");

      document.addEventListener("scroll", function () {
        /*Apply classes for slide in bar*/
        scrollpos = window.scrollY;

        if (scrollpos > 10) {
          header.classList.add("bg-white");
          navactions.forEach(function (navaction) {
            navaction.classList.remove("bg-white");
            navaction.classList.add("gradient");
            navaction.classList.remove("text-gray-800");
            navaction.classList.add("text-white");
          });
          //Use to switch toggleColour colours
          for (var i = 0; i < toToggle.length; i++) {
            toToggle[i].classList.add("text-gray-800");
            toToggle[i].classList.remove("text-white");
          }
          header.classList.add("shadow");
          navcontent.classList.remove("bg-gray-100");
          navcontent.classList.add("bg-white");
        } else {
          header.classList.remove("bg-white");
          navactions.forEach(function (navaction) {
            navaction.classList.remove("gradient");
            navaction.classList.add("bg-white");
            navaction.classList.remove("text-white");
            navaction.classList.add("text-gray-800");
          });
          //Use to switch toggleColour colours
          for (var i = 0; i < toToggle.length; i++) {
            toToggle[i].classList.add("text-white");
            toToggle[i].classList.remove("text-gray-800");
          }

          header.classList.remove("shadow");
          navcontent.classList.remove("bg-white");
          navcontent.classList.add("bg-gray-100");
        }
      });
    </script>
    <script>
      /*Toggle dropdown list*/
      /*https://gist.github.com/slavapas/593e8e50cf4cc16ac972afcbad4f70c8*/

      var navMenuDiv = document.getElementById("nav-content");
      var navMenu = document.getElementById("nav-toggle");

      document.onclick = check;
      function check(e) {
        var target = (e && e.target) || (event && event.srcElement);

        //Nav Menu
        if (!checkParent(target, navMenuDiv)) {
          // click NOT on the menu
          if (checkParent(target, navMenu)) {
            // click on the link
            if (navMenuDiv.classList.contains("hidden")) {
              navMenuDiv.classList.remove("hidden");
            } else {
              navMenuDiv.classList.add("hidden");
            }
          } else {
            // click both outside link and outside menu, hide menu
            navMenuDiv.classList.add("hidden");
          }
        }
      }
      function checkParent(t, elm) {
        while (t.parentNode) {
          if (t == elm) {
            return true;
          }
          t = t.parentNode;
        }
        return false;
      }
    </script>
  </body>
</html>