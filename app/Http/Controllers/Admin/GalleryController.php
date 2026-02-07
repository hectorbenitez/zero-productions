<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Image;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GalleryController extends Controller
{
    /**
     * Display the gallery management page for an event.
     */
    public function index(Event $event): View
    {
        $event->load('galleryImages');

        return view('admin.events.gallery.index', [
            'event' => $event,
        ]);
    }

    /**
     * Upload gallery images.
     */
    public function store(Request $request, Event $event): RedirectResponse
    {
        $validated = $request->validate([
            'images' => ['required', 'array', 'max:10'],
            'images.*' => ['image', 'mimes:jpeg,png,webp', 'max:10240'],
        ], [
            'images.required' => 'Selecciona al menos una imagen.',
            'images.max' => 'Solo puedes subir hasta 10 imágenes a la vez.',
            'images.*.image' => 'Todos los archivos deben ser imágenes.',
            'images.*.mimes' => 'Las imágenes deben ser JPEG, PNG o WebP.',
            'images.*.max' => 'Cada imagen no puede exceder 10MB.',
        ]);

        // Get the next position
        $maxPosition = $event->galleryImages()->max('position') ?? -1;
        $position = $maxPosition + 1;

        foreach ($request->file('images') as $file) {
            Image::create([
                'event_id' => $event->id,
                'kind' => 'gallery',
                'mime_type' => $file->getMimeType(),
                'filename' => $file->getClientOriginalName(),
                'byte_size' => $file->getSize(),
                'checksum' => md5_file($file->getRealPath()),
                'data' => base64_encode(file_get_contents($file->getRealPath())),
                'position' => $position++,
            ]);
        }

        return redirect()
            ->route('admin.events.gallery.index', $event)
            ->with('success', 'Imágenes subidas exitosamente.');
    }

    /**
     * Update an image caption.
     */
    public function update(Request $request, Event $event, Image $image): RedirectResponse
    {
        $validated = $request->validate([
            'caption' => ['nullable', 'string', 'max:255'],
        ], [
            'caption.max' => 'La descripción no puede exceder 255 caracteres.',
        ]);

        $image->update(['caption' => $validated['caption']]);

        return redirect()
            ->route('admin.events.gallery.index', $event)
            ->with('success', 'Imagen actualizada.');
    }

    /**
     * Remove an image from the gallery.
     */
    public function destroy(Event $event, Image $image): RedirectResponse
    {
        // Ensure the image belongs to this event and is a gallery image
        if ($image->event_id !== $event->id || $image->kind !== 'gallery') {
            abort(404);
        }

        $image->delete();

        return redirect()
            ->route('admin.events.gallery.index', $event)
            ->with('success', 'Imagen eliminada exitosamente.');
    }

    /**
     * Reorder gallery images.
     */
    public function reorder(Request $request, Event $event): RedirectResponse
    {
        $validated = $request->validate([
            'order' => ['required', 'array'],
            'order.*' => ['integer', 'exists:images,id'],
        ]);

        foreach ($validated['order'] as $position => $imageId) {
            Image::where('id', $imageId)
                ->where('event_id', $event->id)
                ->where('kind', 'gallery')
                ->update(['position' => $position]);
        }

        return redirect()
            ->route('admin.events.gallery.index', $event)
            ->with('success', 'Orden actualizado exitosamente.');
    }
}
