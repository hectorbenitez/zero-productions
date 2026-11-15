<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\Image;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PublicGalleryTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_page_shows_uploaded_gallery_images_in_order(): void
    {
        Storage::fake('s3');
        $event = Event::create(['title' => 'Evento Prueba', 'event_datetime' => now()->subDays(3), 'status' => 'published']);
        $second = Image::create(['event_id' => $event->id, 'kind' => 'gallery', 'mime_type' => 'image/jpeg', 'byte_size' => 1, 'path' => 'images/b.jpg', 'position' => 1]);
        $first = Image::create(['event_id' => $event->id, 'kind' => 'gallery', 'mime_type' => 'image/jpeg', 'byte_size' => 1, 'path' => 'images/a.jpg', 'position' => 0, 'caption' => 'En vivo']);

        $gallery = $this->get(route('events.show', $event))->assertOk()->viewData('event')->public_gallery;

        $this->assertSame([
            ['url' => $first->url, 'alt' => 'En vivo'],
            ['url' => $second->url, 'alt' => 'Evento Prueba'],
        ], $gallery);
    }
}
