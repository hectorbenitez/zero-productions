<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Response;

class MediaController extends Controller
{
    /**
     * Serve an image from the database.
     */
    public function show(Image $image): Response
    {
        // Object storage, or the legacy base64 column for rows not copied yet
        $data = $image->contents();
        abort_if($data === null, 404);

        // Create response with proper headers
        $response = response($data);

        $response->header('Content-Type', $image->mime_type);
        $response->header('Content-Length', strlen($data));

        // Cache headers - cache for 1 week since images rarely change
        $response->header('Cache-Control', 'public, max-age=604800');
        $response->header('Last-Modified', $image->updated_at->toRfc7231String());

        // Allow browser to cache based on filename
        if ($image->filename) {
            $response->header('Content-Disposition', 'inline; filename="'.$image->filename.'"');
        }

        return $response;
    }
}
