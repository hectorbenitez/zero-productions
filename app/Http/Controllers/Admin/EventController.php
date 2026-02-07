<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Image;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class EventController extends Controller
{
    /**
     * Display a listing of events.
     */
    public function index(): View
    {
        $events = Event::with('coverImage')
            ->orderBy('event_datetime', 'desc')
            ->paginate(20);

        return view('admin.events.index', [
            'events' => $events,
        ]);
    }

    /**
     * Show the form for creating a new event.
     */
    public function create(): View
    {
        return view('admin.events.create');
    }

    /**
     * Store a newly created event.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:events,slug'],
            'description' => ['nullable', 'string'],
            'venue' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'event_datetime' => ['required', 'date'],
            'status' => ['required', 'in:draft,published'],
            'cover_image' => ['nullable', 'image', 'mimes:jpeg,png,webp', 'max:10240'],
            'flyer_image' => ['nullable', 'image', 'mimes:jpeg,png,webp', 'max:10240'],
        ], $this->validationMessages());

        // Handle slug
        if (empty($validated['slug'])) {
            $validated['slug'] = Event::generateUniqueSlug($validated['title']);
        }

        // Create event
        $event = Event::create([
            'title' => $validated['title'],
            'slug' => $validated['slug'],
            'description' => $validated['description'],
            'venue' => $validated['venue'],
            'city' => $validated['city'],
            'event_datetime' => $validated['event_datetime'],
            'status' => $validated['status'],
        ]);

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            $this->storeCoverImage($event, $request->file('cover_image'));
        }

        // Handle flyer image upload
        if ($request->hasFile('flyer_image')) {
            $this->storeFlyerImage($event, $request->file('flyer_image'));
        }

        return redirect()
            ->route('admin.events.edit', $event)
            ->with('success', 'Evento creado exitosamente.');
    }

    /**
     * Show the form for editing an event.
     */
    public function edit(Event $event): View
    {
        $event->load(['coverImage', 'flyerImage', 'links', 'galleryImages']);

        return view('admin.events.edit', [
            'event' => $event,
        ]);
    }

    /**
     * Update the specified event.
     */
    public function update(Request $request, Event $event): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:events,slug,' . $event->id],
            'description' => ['nullable', 'string'],
            'venue' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'event_datetime' => ['required', 'date'],
            'status' => ['required', 'in:draft,published'],
            'cover_image' => ['nullable', 'image', 'mimes:jpeg,png,webp', 'max:10240'],
            'flyer_image' => ['nullable', 'image', 'mimes:jpeg,png,webp', 'max:10240'],
        ], $this->validationMessages());

        // Handle slug
        if (empty($validated['slug'])) {
            if ($event->title !== $validated['title']) {
                $validated['slug'] = Event::generateUniqueSlug($validated['title']);
            } else {
                $validated['slug'] = $event->slug;
            }
        }

        // Update event
        $event->update([
            'title' => $validated['title'],
            'slug' => $validated['slug'],
            'description' => $validated['description'],
            'venue' => $validated['venue'],
            'city' => $validated['city'],
            'event_datetime' => $validated['event_datetime'],
            'status' => $validated['status'],
        ]);

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            $this->storeCoverImage($event, $request->file('cover_image'));
        }

        // Handle flyer image upload
        if ($request->hasFile('flyer_image')) {
            $this->storeFlyerImage($event, $request->file('flyer_image'));
        }

        return redirect()
            ->route('admin.events.edit', $event)
            ->with('success', 'Evento actualizado exitosamente.');
    }

    /**
     * Remove the specified event.
     */
    public function destroy(Event $event): RedirectResponse
    {
        $event->delete();

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Evento eliminado exitosamente.');
    }

    /**
     * Remove the cover image.
     */
    public function deleteCover(Event $event): RedirectResponse
    {
        if ($event->coverImage) {
            $coverImage = $event->coverImage;
            $event->update(['cover_image_id' => null]);
            $coverImage->delete();
        }

        return redirect()
            ->route('admin.events.edit', $event)
            ->with('success', 'Imagen de portada eliminada.');
    }

    /**
     * Remove the flyer image.
     */
    public function deleteFlyer(Event $event): RedirectResponse
    {
        if ($event->flyerImage) {
            $flyerImage = $event->flyerImage;
            $event->update(['flyer_image_id' => null]);
            $flyerImage->delete();
        }

        return redirect()
            ->route('admin.events.edit', $event)
            ->with('success', 'Imagen de flyer eliminada.');
    }

    /**
     * Store cover image in database.
     */
    private function storeCoverImage(Event $event, $file): void
    {
        // Delete old cover image if exists
        if ($event->coverImage) {
            $oldCover = $event->coverImage;
            $event->update(['cover_image_id' => null]);
            $oldCover->delete();
        }

        // Create new image record
        $image = Image::create([
            'event_id' => $event->id,
            'kind' => 'cover',
            'mime_type' => $file->getMimeType(),
            'filename' => $file->getClientOriginalName(),
            'byte_size' => $file->getSize(),
            'checksum' => md5_file($file->getRealPath()),
            'data' => file_get_contents($file->getRealPath()),
        ]);

        // Update event with cover image reference
        $event->update(['cover_image_id' => $image->id]);
    }

    /**
     * Store flyer image in database.
     */
    private function storeFlyerImage(Event $event, $file): void
    {
        // Delete old flyer image if exists
        if ($event->flyerImage) {
            $oldFlyer = $event->flyerImage;
            $event->update(['flyer_image_id' => null]);
            $oldFlyer->delete();
        }

        // Create new image record
        $image = Image::create([
            'event_id' => $event->id,
            'kind' => 'flyer',
            'mime_type' => $file->getMimeType(),
            'filename' => $file->getClientOriginalName(),
            'byte_size' => $file->getSize(),
            'checksum' => md5_file($file->getRealPath()),
            'data' => file_get_contents($file->getRealPath()),
        ]);

        // Update event with flyer image reference
        $event->update(['flyer_image_id' => $image->id]);
    }

    /**
     * Get validation messages in Spanish.
     */
    private function validationMessages(): array
    {
        return [
            'title.required' => 'El título es obligatorio.',
            'title.max' => 'El título no puede exceder 255 caracteres.',
            'slug.unique' => 'Este slug ya está en uso.',
            'event_datetime.required' => 'La fecha y hora del evento es obligatoria.',
            'event_datetime.date' => 'La fecha y hora no es válida.',
            'status.required' => 'El estado es obligatorio.',
            'status.in' => 'El estado debe ser borrador o publicado.',
            'cover_image.image' => 'El archivo debe ser una imagen.',
            'cover_image.mimes' => 'La imagen debe ser JPEG, PNG o WebP.',
            'cover_image.max' => 'La imagen no puede exceder 10MB.',
            'flyer_image.image' => 'El archivo debe ser una imagen.',
            'flyer_image.mimes' => 'La imagen debe ser JPEG, PNG o WebP.',
            'flyer_image.max' => 'La imagen no puede exceder 10MB.',
        ];
    }
}
