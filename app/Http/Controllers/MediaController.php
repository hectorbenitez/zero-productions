<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MediaController extends Controller
{
    /**
     * Serve an image from the database.
     */
    public function show(Image $image): Response
    {
        // Reload the image with the binary data column included
        $image = Image::withData()->findOrFail($image->id);

        // Decode from base64 storage
        $data = base64_decode($image->data);

        // Create response with proper headers
        $response = response($data);
        
        $response->header('Content-Type', $image->mime_type);
        $response->header('Content-Length', strlen($data));
        
        // Cache headers - cache for 1 week since images rarely change
        $response->header('Cache-Control', 'public, max-age=604800');
        $response->header('Last-Modified', $image->updated_at->toRfc7231String());
        
        // Allow browser to cache based on filename
        if ($image->filename) {
            $response->header('Content-Disposition', 'inline; filename="' . $image->filename . '"');
        }

        return $response;
    }
}
