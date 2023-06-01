<div class="p-5 rounded-xl pb-10 my-10">
    <h1 class="text-3xl font-bold text-center my-6">
        Acciones de la app
    </h1>
    @auth
        <h3 class="mt-20 text-xl text-center text-cyan-900 font-bold">Usuario: {{ auth()->user()->name }}</h3>
    @endauth
    @if (session('create'))
        @include('components.toast-success')
    @elseif (session('fail'))
        @include('components.toast-failed')
    @endif
    <div class="text-center my-20">
        <h1>Proposito de la app</h1>
        <p>esta app fue hecha para juntar varias funcionalidades, ya que no es posible deployar todos los proyectos asi que los junte todos</p>
    </div>
    <ol>
        <li>
            <a class="text-center block mx-auto rounded-xl my-4 py-4 px-6 w-3/4 hover:text-white hover:bg-cyan-800 bg-cyan-500 font-bold"
                href="{{ route('mail.sends') }}">Envia una notificacion por email a los {{ count($users) }} usuarios</a>
        </li>
        <li>
            <a class="text-center block mx-auto rounded-xl my-4 py-4 px-6 w-3/4 hover:text-white hover:bg-cyan-800 bg-cyan-500 font-bold"
                href="{{ route('product.index') }}">Ir a la seccion de Productos</a>
        </li>
        <li>
            <a class="text-center block mx-auto rounded-xl my-4 py-4 px-6 w-3/4 hover:text-white hover:bg-cyan-800 bg-cyan-500 font-bold"
                href="{{ route('file.index') }}">Carga y descarga de Archivos (FileStorage)</a>
        </li>
    </ol>
</div>
