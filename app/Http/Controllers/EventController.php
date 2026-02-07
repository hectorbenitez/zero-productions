<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\SiteSetting;
use Illuminate\View\View;

class EventController extends Controller
{
    /**
     * Display the events listing page.
     */
    public function index(): View
    {
        $settings = SiteSetting::instance();

        $upcomingEvents = Event::published()
            ->upcoming()
            ->orderBy('event_datetime', 'asc')
            ->get();

        $pastEvents = Event::published()
            ->past()
            ->orderBy('event_datetime', 'desc')
            ->get();

        return view('public.events.index', [
            'settings' => $settings,
            'upcomingEvents' => $upcomingEvents,
            'pastEvents' => $pastEvents,
        ]);
    }

    /**
     * Display an event detail page.
     */
    public function show(Event $event): View
    {
        // Only show published events to public
        if ($event->status !== 'published') {
            abort(404);
        }

        $settings = SiteSetting::instance();
        
        $event->load(['coverImage', 'flyerImage', 'links', 'galleryImages']);

        return view('public.events.show', [
            'settings' => $settings,
            'event' => $event,
        ]);
    }
}
