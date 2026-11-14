<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\EventLink;
use App\Models\Image;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminReorderTest extends TestCase
{
    use RefreshDatabase;

    private function makeEvent(): Event
    {
        return Event::create([
            'title' => 'Evento Prueba',
            'event_datetime' => now()->addDays(3),
            'status' => 'published',
        ]);
    }

    private function makeLinks(Event $event): array
    {
        return collect(['Ticketmaster', 'Boletia', 'Eticket'])
            ->map(fn ($label, $i) => EventLink::create([
                'event_id' => $event->id,
                'label' => $label,
                'url' => 'https://example.com/'.$i,
                'position' => $i,
            ]))
            ->all();
    }

    private function makeGallery(Event $event): array
    {
        $bytes = "\x89PNG\r\n\x1a\nfake-image-bytes";

        return collect(range(0, 2))
            ->map(fn ($i) => Image::create([
                'event_id' => $event->id,
                'kind' => 'gallery',
                'mime_type' => 'image/png',
                'filename' => "foto{$i}.png",
                'byte_size' => strlen($bytes),
                'checksum' => md5($bytes),
                'data' => base64_encode($bytes),
                'position' => $i,
            ]))
            ->all();
    }

    /**
     * Browsers drop a <form> nested inside another form, which sent the first delete
     * button to the reorder route. The reorder form must contain no other form.
     */
    private function assertReorderFormHasNoNestedForms(string $html): void
    {
        $start = strpos($html, 'id="reorder-form"');
        $this->assertNotFalse($start, 'Reorder form not rendered.');
        $end = strpos($html, '</form>', $start);
        $this->assertStringNotContainsString('<form', substr($html, $start, $end - $start));
    }

    public function test_links_page_keeps_delete_forms_outside_the_reorder_form(): void
    {
        $event = $this->makeEvent();
        $links = $this->makeLinks($event);

        $html = $this->actingAs(User::factory()->create())
            ->get(route('admin.events.links.index', $event))
            ->assertOk()
            ->assertSee('data-sortable', false)
            ->getContent();

        $this->assertReorderFormHasNoNestedForms($html);
        foreach ($links as $link) {
            $this->assertStringContainsString('form="delete-link-'.$link->id.'"', $html);
            $this->assertStringContainsString('id="delete-link-'.$link->id.'"', $html);
        }
    }

    /**
     * The edit buttons pass their values to inline JS; quotes, apostrophes and line breaks
     * must arrive escaped instead of closing the string literal or the attribute.
     */
    public function test_edit_buttons_escape_values_passed_to_inline_js(): void
    {
        Storage::fake('s3');
        $event = $this->makeEvent();
        $link = EventLink::create([
            'event_id' => $event->id,
            'label' => 'D\'Rock "Live"',
            'url' => 'https://example.com/?a=1&b=2',
            'position' => 0,
        ]);
        [$image] = $this->makeGallery($event);
        $image->update(['caption' => "Línea 1\nD'Rock"]);
        $user = User::factory()->create();

        $html = $this->actingAs($user)->get(route('admin.events.links.index', $event))->getContent();
        $this->assertStringNotContainsString("'D&#039;Rock", $html);
        $this->assertStringContainsString("editLink({$link->id}, 'D\\u0027Rock \\u0022Live\\u0022', 'https:\\/\\/example.com\\/?a=1\\u0026b=2')", $html);

        $html = $this->actingAs($user)->get(route('admin.events.gallery.index', $event))->getContent();
        $this->assertStringContainsString("editCaption({$image->id}, 'L\\u00ednea 1\\nD\\u0027Rock')", $html);
    }

    public function test_links_reorder_saves_the_submitted_order(): void
    {
        $event = $this->makeEvent();
        [$a, $b, $c] = $this->makeLinks($event);

        $this->actingAs(User::factory()->create())
            ->post(route('admin.events.links.reorder', $event), ['order' => [$c->id, $a->id, $b->id]])
            ->assertRedirect(route('admin.events.links.index', $event));

        $this->assertSame([$c->id, $a->id, $b->id], $event->links()->orderBy('position')->pluck('id')->all());
    }

    public function test_deleting_the_first_link_removes_only_that_link(): void
    {
        $event = $this->makeEvent();
        [$first, $second] = $this->makeLinks($event);

        $this->actingAs(User::factory()->create())
            ->delete(route('admin.events.links.destroy', [$event, $first]))
            ->assertRedirect();

        $this->assertModelMissing($first);
        $this->assertModelExists($second);
    }

    public function test_gallery_page_keeps_delete_forms_outside_the_reorder_form(): void
    {
        Storage::fake('s3');
        $event = $this->makeEvent();
        $images = $this->makeGallery($event);

        $html = $this->actingAs(User::factory()->create())
            ->get(route('admin.events.gallery.index', $event))
            ->assertOk()
            ->assertSee('data-sortable', false)
            ->getContent();

        $this->assertReorderFormHasNoNestedForms($html);
        foreach ($images as $image) {
            $this->assertStringContainsString('form="delete-image-'.$image->id.'"', $html);
            $this->assertStringContainsString('id="delete-image-'.$image->id.'"', $html);
        }
    }

    public function test_gallery_reorder_saves_the_submitted_order(): void
    {
        Storage::fake('s3');
        $event = $this->makeEvent();
        [$a, $b, $c] = $this->makeGallery($event);

        $this->actingAs(User::factory()->create())
            ->post(route('admin.events.gallery.reorder', $event), ['order' => [$b->id, $c->id, $a->id]])
            ->assertRedirect(route('admin.events.gallery.index', $event));

        $this->assertSame([$b->id, $c->id, $a->id], $event->galleryImages()->pluck('id')->all());
    }
}
