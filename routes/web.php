<?php

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('dokumen/{filename}', function ($filename){
        if (Storage::disk('dokumen')->exists($filename)) {
            $filePath = Storage::disk('dokumen')->path($filename);
            
            $mimeType = mime_content_type($filePath);
    
            return Response::file($filePath, [
                'Content-Type' => $mimeType
            ]);
        }
    })->name('file.dokumen');
});
