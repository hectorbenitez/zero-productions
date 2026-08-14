<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\SiteSetting;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Display the home page.
     */
    public function index(): View
    {
        $settings = SiteSetting::instance();

        // Always fill the grid with 6 events: upcoming first, then past ones (highlighted before most recent)
        $events = Event::published()
            ->upcoming()
            ->with('coverImage')
            ->orderBy('event_datetime', 'asc')
            ->limit(6)
            ->get();

        $remaining = 6 - $events->count();
        if ($remaining > 0) {
            $events = $events->concat(
                Event::published()
                    ->past()
                    ->with('coverImage')
                    ->orderByDesc('is_highlighted')
                    ->orderBy('event_datetime', 'desc')
                    ->limit($remaining)
                    ->get()
            );
        }

        $heroImages = Event::published()
            ->whereNotNull('cover_image_id')
            ->with('coverImage')
            ->orderBy('event_datetime', 'desc')
            ->limit(6)
            ->get()
            ->filter(fn (Event $event) => $event->coverImage !== null)
            ->map(fn (Event $event) => route('media.show', $event->coverImage))
            ->values()
            ->all();

        return view('public.home', [
            'settings' => $settings,
            'events' => $events,
            'heroImages' => $heroImages,
        ]);
    }
}
