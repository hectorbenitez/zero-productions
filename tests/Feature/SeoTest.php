<?php

namespace Tests\Feature;

use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeoTest extends TestCase
{
    use RefreshDatabase;

    public function test_sitemap_lists_public_pages_and_published_events_only(): void
    {
        $published = Event::create(['title' => 'Concierto Publicado', 'event_datetime' => now()->addWeek(), 'status' => 'published']);
        $draft = Event::create(['title' => 'Concierto Borrador', 'event_datetime' => now()->addWeek(), 'status' => 'draft']);

        $response = $this->get('/sitemap.xml');

        $response->assertOk()
            ->assertHeader('Content-Type', 'application/xml; charset=UTF-8')
            ->assertSee('<loc>'.route('home').'</loc>', false)
            ->assertSee('<loc>'.route('events.index').'</loc>', false)
            ->assertSee('<loc>'.route('contact.show').'</loc>', false)
            ->assertSee('<loc>'.route('events.show', $published).'</loc>', false)
            ->assertDontSee(route('events.show', $draft), false);
    }

    public function test_public_pages_have_a_canonical_without_the_query_string(): void
    {
        $this->get('/eventos?utm_source=instagram')
            ->assertOk()
            ->assertSee('<link rel="canonical" href="'.url('/eventos').'">', false);
    }

    public function test_robots_txt_points_to_the_sitemap(): void
    {
        $this->assertStringContainsString(
            'Sitemap: https://zero-productions.com/sitemap.xml',
            file_get_contents(public_path('robots.txt'))
        );
    }
}
