<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function upload(Request $request)
    {
        /* toma una la imagen que viene desde el adaptador de carga de ckeditor */
        $image = $request->file('upload');
        /* guarda la imagen en storage/app/public/images/ */
        $path = Storage::disk('public')->put('images', $image);

        Image::create([
            'path' => $path,
        ]);

        /* devuelve el path de la imagen */
        return response()->json([
            'path' => $path,
            'url' => "/storage/" . $path
        ]);
    }
}
