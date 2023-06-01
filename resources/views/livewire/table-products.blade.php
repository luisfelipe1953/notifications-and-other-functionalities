<div>
    @extends('app')
    @include('components.navbar')
    <div class="flex items-center justify-between my-5">
        <div class="flex items-center justify-start gap-x-4">

            <a href="{{ route('product.create') }}"
                class="px-4 py-2 bg-cyan-400 rounded-xl hover:text-white font-bold shadow-md hover:bg-cyan-900">
                Crear producto
            </a>
            <a href="{{ route('category.create') }}"
                class="px-4 py-2 bg-cyan-400 rounded-xl hover:text-white font-bold shadow-md hover:bg-cyan-900">
                Crear categoria
            </a>
            <a href="{{ route('product.trash') }}"
                class="px-4 py-2 bg-gray-900  rounded-xl hover:text-black text-white font-bold shadow-md hover:bg-gray-400">Papelera</a>
        </div>
        <div class="flex items-center justify-start gap-x-4">
            <a href="#" wire:click.prevent="export('pdf')"
                class="px-4 py-2 bg-gray-900  rounded-xl hover:text-black text-white font-bold shadow-md hover:bg-gray-400 ">Exportar
                PDF</a>
            <a href="#" wire:click.prevent="export('xlsx')"
                class="px-4 py-2 bg-cyan-400 rounded-xl hover:text-white font-bold shadow-md hover:bg-cyan-900">Exportar
                EXCEL</a>
        </div>
    </div>
    <h1 class="text-xl font-bold">FILTROS</h1>
    <div class="flex items-center w-full justify-between my-5">
        <div class="flex items-center w-full justify-start gap-x-4">
            <select wire:model.defer="categoryFilter"
                class="bg-transparent border border-gray-300 text-gray-900 sm:text-xs rounded-lg focus:ring-cyan-900 focus:border-cyan-900 block w-2/4 px-4 py-2">
                <option disabled selected>Selecciona una categoria</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            <input type="text" placeholder="Busca un producto por su nombre" wire:model.defer="searchProduct"
                class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-transparent sm:text-xs focus:ring-cyan-900 focus:border-cyan-900">
            <div class="flex w-1/5 items-center gap-x-2 justify-end">
                <button wire:click.defer="search"
                    class="px-4 w-full py-2 hover:text-black text-white bg-gray-900 shadow-md hover:bg-gray-400 rounded-xl font-bold">Buscar</button>
                <button wire:click="$emit('reset')"
                    class="px-4 w-full py-2 hover:text-black text-white bg-gray-900 shadow-md hover:bg-gray-400 rounded-xl font-bold">Limpiar</button>
            </div>
        </div>
    </div>
    <div class="relative overflow-x-auto pb-10">
        @if ($products->count())
            <table class="w-full text-sm text-left shadow">
                <thead class="text-xs  uppercase bg-cyan-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            CATEGORIA
                        </th>
                        <th scope="col" class="px-6 py-3">
                            NOMBRE
                        </th>
                        <th scope="col" class="px-6 py-3">
                            DESCRIPCION
                        </th>
                        <th scope="col" class="px-6 text-center py-3">
                            ACCIONES
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr class="bg-white border-b">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $product->category->name }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $product->name }}
                            </td>
                            <td class="px-6 py-4 w-1/2">
                                {{ $product->description }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <button wire:method="delete" wire:loading.attr="disabled"
                                    wire:click.prevent="{{ auth()->check() ? 'deleteProduct(' . $product->id . ')' : 'redirectToLogin' }}"
                                    class="px-4 py-2 bg-cyan-400 hover:text-black text-white rounded-xl font-bold hover:bg-cyan-900">
                                    Enviar a papelera
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <p class="text-right"><span class="font-bold">Nota:</span> Las acciones no tienen confirmacion.</p>
        @else
            <p class="font-semibold">No se han encontrado productos registrados.</p>
        @endif
    </div>

    <script>
        document.addEventListener('productDeleted', function() {
            Livewire.emit('refreshProductList');
        });
    </script>

</div>
