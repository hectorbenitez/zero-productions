<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventLink;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventLinkController extends Controller
{
    /**
     * Display a listing of links for an event.
     */
    public function index(Event $event): View
    {
        $event->load('links');

        return view('admin.events.links.index', [
            'event' => $event,
        ]);
    }

    /**
     * Store a newly created link.
     */
    public function store(Request $request, Event $event): RedirectResponse
    {
        $validated = $request->validate([
            'label' => ['required', 'string', 'max:255'],
            'url' => ['required', 'url', 'max:500'],
        ], [
            'label.required' => 'La etiqueta es obligatoria.',
            'label.max' => 'La etiqueta no puede exceder 255 caracteres.',
            'url.required' => 'La URL es obligatoria.',
            'url.url' => 'Ingresa una URL válida.',
            'url.max' => 'La URL no puede exceder 500 caracteres.',
        ]);

        // Get the next position
        $maxPosition = $event->links()->max('position') ?? -1;

        $event->links()->create([
            'label' => $validated['label'],
            'url' => $validated['url'],
            'position' => $maxPosition + 1,
        ]);

        return redirect()
            ->route('admin.events.links.index', $event)
            ->with('success', 'Enlace agregado exitosamente.');
    }

    /**
     * Update the specified link.
     */
    public function update(Request $request, Event $event, EventLink $link): RedirectResponse
    {
        $validated = $request->validate([
            'label' => ['required', 'string', 'max:255'],
            'url' => ['required', 'url', 'max:500'],
        ], [
            'label.required' => 'La etiqueta es obligatoria.',
            'label.max' => 'La etiqueta no puede exceder 255 caracteres.',
            'url.required' => 'La URL es obligatoria.',
            'url.url' => 'Ingresa una URL válida.',
            'url.max' => 'La URL no puede exceder 500 caracteres.',
        ]);

        $link->update($validated);

        return redirect()
            ->route('admin.events.links.index', $event)
            ->with('success', 'Enlace actualizado exitosamente.');
    }

    /**
     * Remove the specified link.
     */
    public function destroy(Event $event, EventLink $link): RedirectResponse
    {
        $link->delete();

        return redirect()
            ->route('admin.events.links.index', $event)
            ->with('success', 'Enlace eliminado exitosamente.');
    }

    /**
     * Reorder links.
     */
    public function reorder(Request $request, Event $event): RedirectResponse
    {
        $validated = $request->validate([
            'order' => ['required', 'array'],
            'order.*' => ['integer', 'exists:event_links,id'],
        ]);

        foreach ($validated['order'] as $position => $linkId) {
            EventLink::where('id', $linkId)
                ->where('event_id', $event->id)
                ->update(['position' => $position]);
        }

        return redirect()
            ->route('admin.events.links.index', $event)
            ->with('success', 'Orden actualizado exitosamente.');
    }
}
