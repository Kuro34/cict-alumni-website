<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class ImageController extends Controller
{
    public function show($folder, $filename)
    {
        $path = "public/{$folder}/{$filename}";

        if (!Storage::exists($path)) {
            abort(404, 'Image not found.');
        }

        $file = Storage::get($path);
        $type = Storage::mimeType($path);

        return response($file, 200)->header('Content-Type', $type);
    }
}
