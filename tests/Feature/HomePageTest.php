<?php

namespace Tests\Feature;

use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    use RefreshDatabase;

    private function makeEvent(string $title, string $datetime, string $status = 'published'): Event
    {
        return Event::create([
            'title' => $title,
            'event_datetime' => $datetime,
            'status' => $status,
        ]);
    }

    public function test_home_fills_grid_with_recent_past_events_when_few_upcoming(): void
    {
        $this->makeEvent('Próximo A', now()->addDays(5));
        $this->makeEvent('Próximo B', now()->addDays(10));

        foreach (range(1, 6) as $i) {
            $this->makeEvent("Pasado {$i}", now()->subDays($i));
        }

        $response = $this->get('/');

        $response->assertStatus(200);
        $events = $response->viewData('events');

        $this->assertCount(6, $events);
        // Upcoming first (soonest first), then most recent past
        $this->assertSame(
            ['Próximo A', 'Próximo B', 'Pasado 1', 'Pasado 2', 'Pasado 3', 'Pasado 4'],
            $events->pluck('title')->all()
        );
    }

    public function test_home_shows_only_upcoming_when_six_or_more(): void
    {
        foreach (range(1, 7) as $i) {
            $this->makeEvent("Próximo {$i}", now()->addDays($i));
        }
        $this->makeEvent('Pasado', now()->subDay());

        $events = $this->get('/')->viewData('events');

        $this->assertCount(6, $events);
        $this->assertFalse($events->pluck('title')->contains('Pasado'));
    }

    public function test_home_excludes_draft_events(): void
    {
        $this->makeEvent('Publicado', now()->addDay());
        $this->makeEvent('Borrador', now()->addDays(2), 'draft');

        $events = $this->get('/')->viewData('events');

        $this->assertSame(['Publicado'], $events->pluck('title')->all());
    }
}
