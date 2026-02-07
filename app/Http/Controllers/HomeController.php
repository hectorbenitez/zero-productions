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
        
        $upcomingEvents = Event::published()
            ->upcoming()
            ->orderBy('event_datetime', 'asc')
            ->limit(6)
            ->get();

        return view('public.home', [
            'settings' => $settings,
            'upcomingEvents' => $upcomingEvents,
        ]);
    }
}
