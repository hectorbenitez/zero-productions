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
        // Get the binary data
        $data = $image->data;

        // Handle PostgreSQL bytea encoding if needed
        if (is_resource($data)) {
            $data = stream_get_contents($data);
        }

        // Create response with proper headers
        $response = response($data);
        
        $response->header('Content-Type', $image->mime_type);
        $response->header('Content-Length', $image->byte_size);
        
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
