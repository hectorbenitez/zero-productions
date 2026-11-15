<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\Image;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class GalleryImportTest extends TestCase
{
    use RefreshDatabase;

    private string $publicPath;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('s3');
        $this->withoutVite();

        // Point public_path() at a temp dir so the real gallery folders are untouched
        $this->publicPath = sys_get_temp_dir().'/zp-public-'.uniqid();
        $this->app->usePublicPath($this->publicPath);
    }

    protected function tearDown(): void
    {
        File::deleteDirectory($this->publicPath);
        parent::tearDown();
    }

    private function makeEvent(): Event
    {
        return Event::create([
            'title' => 'Evento Prueba',
            'event_datetime' => now()->subDays(3),
            'status' => 'published',
        ]);
    }

    public function test_import_creates_gallery_images_in_storage_and_is_idempotent(): void
    {
        $event = $this->makeEvent();
        $dir = public_path("assets/gallery/{$event->id}");
        File::makeDirectory($dir, 0755, true);
        File::put("$dir/b.jpg", 'second');
        File::put("$dir/a.jpg", 'first');
        File::put("$dir/notes.txt", 'ignored');

        $this->artisan('images:import-gallery-folders')->assertSuccessful();

        $images = $event->galleryImages()->get();
        $this->assertSame(['a.jpg', 'b.jpg'], $images->pluck('filename')->all());
        $this->assertSame([0, 1], $images->pluck('position')->all());
        $this->assertSame('first', Storage::disk('s3')->get($images[0]->path));

        $this->artisan('images:import-gallery-folders')->expectsOutputToContain('0 photo(s) imported')->assertSuccessful();
        $this->assertSame(2, Image::count());
    }

    public function test_public_page_prefers_uploaded_gallery_over_folder(): void
    {
        $event = $this->makeEvent();
        $dir = public_path("assets/gallery/{$event->id}");
        File::makeDirectory($dir, 0755, true);
        File::put("$dir/a.jpg", 'folder');

        // Folder only: falls back to the folder
        $gallery = $this->get(route('events.show', $event))->assertOk()->viewData('event')->public_gallery;
        $this->assertStringContainsString("assets/gallery/{$event->id}/a.jpg", $gallery[0]['url']);

        Storage::disk('s3')->put('images/x.jpg', 'uploaded');
        $image = Image::create([
            'event_id' => $event->id, 'kind' => 'gallery', 'mime_type' => 'image/jpeg',
            'byte_size' => 8, 'path' => 'images/x.jpg', 'caption' => 'En vivo',
        ]);

        $gallery = $this->get(route('events.show', $event))->assertOk()->viewData('event')->public_gallery;
        $this->assertSame([['url' => $image->url, 'alt' => 'En vivo']], $gallery);
    }
}
