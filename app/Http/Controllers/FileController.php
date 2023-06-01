<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Events\FileUploadEvent;
use Illuminate\Http\UploadedFile;
use App\Http\Requests\FileRequest;
use App\Http\Controllers\Controller;
use App\Classes\Facades\CacheComposite;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function index()
    {
        $files = CacheComposite::getCacheOrCreate(
            'files',
            File::class,
            ['id', 'origin_name', 'hash_name', 'extension', 'url']
        );

        return view('files.index', compact('files'));
    }

    public function uploadFile(FileRequest $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');

            if ($file instanceof UploadedFile && $file->isValid()) {
                $hashName = $file->store('uploads');

                $file = File::create([
                    'origin_name' => $file->getClientOriginalName(),
                    'hash_name' => $hashName,
                    'url' => 'storage/' . $hashName,
                    'extension' => $file->getClientMimeType()
                ]);

                CacheComposite::updateCache(
                    File::class,
                    'files',
                    ['id', 'origin_name', 'hash_name', 'extension', 'url']
                );

                event(new FileUploadEvent($file, auth()->user()));

                return redirect()->back();
            }
        }

        return redirect()->back()->with('fail', 'Ocurrio un error');
    }


    public function downloadFile(File $file)
    {
        return Storage::download($file->hash_name, $file->name);
    }
}
