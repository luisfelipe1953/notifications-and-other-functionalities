@extends('app')
@include('components.navbar')

<form action="{{ route('uploadFile') }}" class="w-2/5 mx-auto my-10 pb-10" method="post" enctype="multipart/form-data">
    @csrf
    <h1 class="text-center text-gray-900 mx-auto font-bold text-3xl my-10">
        Uso de FileStorage
    </h1>
    <div>
        @error('file')
            <p class="my-2 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>
    <div class="flex justify-between items-center">
        <input name="file" aria-describedby="file_help" type="file"
            class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-transparent focus:outline-none">
        <button type="submit"
            class="text-gray-100 font-bold ml-3 bg-gray-900 hover:text-rose-500 rounded-xl text-sm w-full sm:w-auto px-5 py-2.5 text-center">Subir</button>
    </div>
    <div>
        <p class="mt-1 text-sm text-gray-500">PNG, JPG, GIF, WEBP, PDF, RAR,
            ZIP, AVI, MP4, MPEG, WAV, CSV, XLS.</p>
        <p class="mt-1 text-sm text-rose-500">MAX 50MB</p>
    </div>
</form>

@include('files.table-files')
