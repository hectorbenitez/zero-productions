<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventsPageTest extends TestCase
{
    use RefreshDatabase;

    private function makeEvent(string $title, string $datetime, string $status = 'published', bool $highlighted = false): Event
    {
        return Event::create([
            'title' => $title,
            'event_datetime' => $datetime,
            'status' => $status,
            'is_highlighted' => $highlighted,
        ]);
    }

    public function test_past_events_section_shows_only_highlighted_events(): void
    {
        $this->makeEvent('Pasado Destacado', now()->subDays(5), highlighted: true);
        $this->makeEvent('Pasado Normal', now()->subDays(3));

        $response = $this->get('/eventos');

        $response->assertStatus(200);
        $this->assertSame(
            ['Pasado Destacado'],
            $response->viewData('pastEvents')->pluck('title')->all()
        );
    }

    public function test_upcoming_events_show_regardless_of_highlight(): void
    {
        $this->makeEvent('Próximo Normal', now()->addDays(5));
        $this->makeEvent('Próximo Destacado', now()->addDays(10), highlighted: true);

        $response = $this->get('/eventos');

        $this->assertSame(
            ['Próximo Normal', 'Próximo Destacado'],
            $response->viewData('upcomingEvents')->pluck('title')->all()
        );
    }

    public function test_past_events_exclude_highlighted_drafts(): void
    {
        $this->makeEvent('Borrador Destacado', now()->subDay(), 'draft', highlighted: true);

        $response = $this->get('/eventos');

        $this->assertCount(0, $response->viewData('pastEvents'));
    }

    private function updatePayload(Event $event): array
    {
        return [
            'title' => $event->title,
            'description' => $event->description,
            'venue' => $event->venue,
            'city' => $event->city,
            'event_datetime' => $event->event_datetime->format('Y-m-d\TH:i'),
            'status' => $event->status,
        ];
    }

    public function test_admin_can_mark_event_as_highlighted(): void
    {
        $event = $this->makeEvent('Concierto', now()->subDay());

        $this->actingAs(User::factory()->create())
            ->put(route('admin.events.update', $event), $this->updatePayload($event) + ['is_highlighted' => '1'])
            ->assertRedirect(route('admin.events.edit', $event));

        $this->assertTrue($event->fresh()->is_highlighted);
    }

    public function test_admin_can_unmark_highlighted_event(): void
    {
        $event = $this->makeEvent('Concierto', now()->subDay(), highlighted: true);

        // Unchecked checkboxes are absent from the request
        $this->actingAs(User::factory()->create())
            ->put(route('admin.events.update', $event), $this->updatePayload($event))
            ->assertRedirect(route('admin.events.edit', $event));

        $this->assertFalse($event->fresh()->is_highlighted);
    }
}
