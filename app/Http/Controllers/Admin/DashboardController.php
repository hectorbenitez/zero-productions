<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\ContactMessage;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index(): View
    {
        $stats = [
            'total_events' => Event::count(),
            'published_events' => Event::published()->count(),
            'upcoming_events' => Event::published()->upcoming()->count(),
            'contact_messages' => ContactMessage::count(),
        ];

        $upcomingEvents = Event::published()
            ->upcoming()
            ->orderBy('event_datetime', 'asc')
            ->limit(5)
            ->get();

        $recentMessages = ContactMessage::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', [
            'stats' => $stats,
            'upcomingEvents' => $upcomingEvents,
            'recentMessages' => $recentMessages,
        ]);
    }
}
