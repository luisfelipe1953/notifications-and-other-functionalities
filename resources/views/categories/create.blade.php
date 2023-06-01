@extends('app')
@include('components.navbar')

<a href="{{ route('product.index') }}"
    class="hover:text-white bg-cyan-500 hover:bg-cyan-900 px-4 py-2 rounded-r-xl font-bold">Regresar</a>

<form action="{{ route('category.store') }}" class="w-2/5 mx-auto my-10 pb-10" method="post">
    @csrf
    <h1 class="text-center text-gray-900 mx-auto font-bold text-3xl my-10">
        Crea una categoria.
    </h1>
    <div>
        @error('name')
            <p class="my-2 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label for="name" class="block mt-4 mb-2 text-sm font-medium text-gray-900 dark:text-white">
            Nombre de la categoria
        </label>
        <input type="text" id="name" name="name" placeholder="Escribe el nombre de la categoria"
            class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-transparent sm:text-xs focus:ring-cyan-900 focus:border-cyan-900 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-cyan-900 dark:focus:border-cyan-900">

    </div>
    <div>
        <button type="submit"
            class=" mt-10 hover:text-white bg-cyan-500 hover:bg-cyan-900 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-xl text-sm w-full sm:w-auto px-6 py-2.5 text-center font-bold">Crear</button>
    </div>
</form>
