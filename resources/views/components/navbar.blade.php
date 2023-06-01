<nav class="bg-transparent border-gray-200 py-2.5">
    <div class="container flex flex-wrap items-center justify-between mx-auto">
        <a href="/" class="flex items-center">
            <span class="self-center text-xl font-semibold whitespace-nowrap hover:text-gray-400">
               <> Laravel Application <>
            </span>
        </a>
        <button data-collapse-toggle="navbar-default" type="button"
            class="inline-flex items-center p-2 ml-3 text-sm text-gray-500 rounded-xl md:hidden hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-200"
            aria-controls="navbar-default" aria-expanded="false">
            <span class="sr-only">Open main menu</span>
            <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                    d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                    clip-rule="evenodd"></path>
            </svg>
        </button>
        @auth
            @include('components.notify')
        @endauth
        <div class="hidden w-full md:block md:w-auto" id="navbar-default">
            <ul
                class="flex flex-col items-center p-4 mt-4 border rounded-xl bg-gray-900 md:flex-row md:space-x-8 md:mt-0 md:text-sm md:bg-gray-900">
                <li>
                    <a href="/"
                        class="block py-2 pl-3 pr-4 font-bold {{ request()->is('/') ? 'bg-gray-400' : 'text-white' }} rounded hover:bg-gray-400 hover:text-black "
                        aria-current="page">Inicio</a>
                </li>
                @auth
                    <li>
                        <form action="{{ route('logout') }}" method="post" class="inline">
                            @csrf
                            <a onclick="this.closest('form').submit()"
                                class="inline-block py-2 pl-3 pr-4 font-bold text-white rounded hover:bg-gray-400 hover:text-black  cursor-pointer">Cerrar
                                sesión</a>
                        </form>
                    </li>
                @else
                    <li>
                        <a href="{{ route('login.view') }}"
                            class="block py-2 pl-3 pr-4 font-bold {{ request()->is('login') ? 'bg-gray-400' : 'text-white' }} rounded hover:bg-gray-400 hover:text-black py-2 pl-3 pr-4">Iniciar
                            sesión</a>
                    </li>
                    <li>
                        <a href="{{ route('register.view') }}"
                            class="block py-2 pl-3 pr-4 font-bold {{ request()->is('register') ? 'bg-gray-400' : 'text-white' }} rounded hover:bg-gray-400 hover:text-black py-2 pl-3 pr-4 ">Registrarse</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
