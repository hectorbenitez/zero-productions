<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GoogleAnalyticsTest extends TestCase
{
    use RefreshDatabase;

    public function test_tag_is_not_rendered_outside_production(): void
    {
        $this->get('/')->assertOk()->assertDontSee('googletagmanager.com', false);
    }

    public function test_tag_is_rendered_in_production(): void
    {
        $this->app['env'] = 'production';

        $this->get('/')->assertOk()
            ->assertSee('googletagmanager.com/gtag/js?id=G-TW25RHP8NM', false)
            ->assertDontSee("'generate_lead'", false);
    }

    public function test_contact_success_fires_generate_lead(): void
    {
        $this->app['env'] = 'production';

        $this->withSession(['analytics_event' => 'generate_lead'])
            ->get(route('contact.show'))
            ->assertOk()
            ->assertSee("gtag('event', 'generate_lead'", false);
    }
}
