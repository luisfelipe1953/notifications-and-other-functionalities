@extends('app')
@include('components.navbar')
@if (session('fail'))
    @include('components.toast-failed')
@endif
<form action="{{ route('login') }}" class="w-3/4 xl:w-2/6 mx-auto my-10 p-10 rounded-xl shadow-2xl " method="post">
    @csrf
    <h1 class="text-center text-gray-900 mx-auto font-bold text-3xl my-10">
        Ingresa a tu cuenta
    </h1>
    <div>
        @error('email')
            <p class="my-2 text-sm text-red-500">{{ $message }}</p>
        @enderror
        @error('password')
            <p class="my-2 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label for="email" class="block mt-4 mb-2 text-sm font-medium text-gray-900">
            Email
        </label>
        <input type="text" id="email" name="email" placeholder="Escribe tu email"
            class="block w-full p-2 text-gray-900 border border-black rounded-lg bg-transparent sm:text-xs focus:ring-cyan-900 focus:border-cyan-900">
    </div>
    <div>
        <label for="password" class="block mt-4 mb-2 text-sm font-medium text-gray-900">
            Password
        </label>
        <input type="password" id="password" name="password" placeholder="Escribe tu contraseña"
            class="block w-full p-2 text-gray-900 border border-black rounded-lg bg-transparent sm:text-xs focus:ring-cyan-900 focus:border-cyan-900">
    </div>

    <div class="flex flex-col justify-between mt-10 w-full items-center">
        <button class="hover:text-white bg-cyan-500 hover:bg-cyan-900 px-4 py-2 rounded-xl font-bold">
            Iniciar sesión
        </button>
        <a href="{{ route('register.view') }}" class="my-5 font-bold text-gray-800 hover:text-rose-500">
            Si no estas registrado, entra aqui
        </a>
    </div>
</form>
