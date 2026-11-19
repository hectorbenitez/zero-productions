<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    /**
     * List the public pages and every published event for search engines.
     */
    public function index(): Response
    {
        $urls = collect([
            ['loc' => route('home')],
            ['loc' => route('events.index')],
            ['loc' => route('contact.show')],
        ]);

        Event::published()
            ->orderBy('event_datetime', 'desc')
            ->get(['slug', 'updated_at'])
            ->each(fn (Event $event) => $urls->push([
                'loc' => route('events.show', $event),
                'lastmod' => $event->updated_at?->toAtomString(),
            ]));

        // The XML declaration can't live in the Blade file: "<?" would open a PHP tag.
        $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n".view('sitemap', ['urls' => $urls])->render();

        return response($xml, 200, ['Content-Type' => 'application/xml; charset=UTF-8']);
    }
}
