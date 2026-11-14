<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\Image;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ImageStorageTest extends TestCase
{
    use RefreshDatabase;

    private const PNG = "\x89PNG\r\n\x1a\nfake-image-bytes";

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('s3');
    }

    private function makeEvent(): Event
    {
        return Event::create([
            'title' => 'Evento Prueba',
            'event_datetime' => now()->addDays(3),
            'status' => 'published',
        ]);
    }

    private function legacyImage(Event $event, string $bytes = self::PNG): Image
    {
        return Image::create([
            'event_id' => $event->id,
            'kind' => 'gallery',
            'mime_type' => 'image/png',
            'filename' => 'legacy.png',
            'byte_size' => strlen($bytes),
            'checksum' => md5($bytes),
            'data' => base64_encode($bytes),
        ]);
    }

    public function test_gallery_upload_stores_file_on_disk_not_in_db(): void
    {
        $event = $this->makeEvent();

        $this->actingAs(User::factory()->create())
            ->post(route('admin.events.gallery.store', $event), [
                'images' => [UploadedFile::fake()->image('foto.jpg', 20, 20)],
            ])
            ->assertRedirect();

        $image = Image::withData()->where('event_id', $event->id)->firstOrFail();
        $this->assertNull($image->data);
        $this->assertNotNull($image->path);
        Storage::disk('s3')->assertExists($image->path);
        $this->assertSame(md5(Storage::disk('s3')->get($image->path)), $image->checksum);
    }

    public function test_media_serves_stored_file(): void
    {
        $event = $this->makeEvent();
        Storage::disk('s3')->put('images/a.png', self::PNG);
        $image = Image::create([
            'event_id' => $event->id, 'kind' => 'gallery', 'mime_type' => 'image/png',
            'byte_size' => strlen(self::PNG), 'checksum' => md5(self::PNG), 'path' => 'images/a.png',
        ]);

        $response = $this->get(route('media.show', $image))->assertOk()->assertHeader('Content-Type', 'image/png');
        $this->assertSame(self::PNG, $response->getContent());
    }

    public function test_media_falls_back_to_base64_column(): void
    {
        $image = $this->legacyImage($this->makeEvent());

        $response = $this->get(route('media.show', $image))->assertOk();
        $this->assertSame(self::PNG, $response->getContent());
    }

    public function test_deleting_image_or_event_removes_files(): void
    {
        $event = $this->makeEvent();
        Storage::disk('s3')->put('images/a.png', self::PNG);
        Storage::disk('s3')->put('images/b.png', self::PNG);
        $a = Image::create(['event_id' => $event->id, 'kind' => 'gallery', 'mime_type' => 'image/png', 'byte_size' => 1, 'path' => 'images/a.png']);
        $b = Image::create(['event_id' => $event->id, 'kind' => 'cover', 'mime_type' => 'image/png', 'byte_size' => 1, 'path' => 'images/b.png']);
        $event->update(['cover_image_id' => $b->id]);

        $a->delete();
        Storage::disk('s3')->assertMissing('images/a.png');

        $event->delete();
        Storage::disk('s3')->assertMissing('images/b.png');
        $this->assertSame(0, Image::count());
    }

    public function test_move_command_copies_legacy_images_and_keeps_db_copy(): void
    {
        $image = $this->legacyImage($this->makeEvent());
        $updatedAt = $image->updated_at->toIso8601String();

        $this->artisan('images:move-to-storage')->assertSuccessful();

        $image = Image::withData()->findOrFail($image->id);
        $this->assertNotNull($image->path);
        $this->assertSame(self::PNG, Storage::disk('s3')->get($image->path));
        $this->assertSame(base64_encode(self::PNG), $image->data);
        $this->assertSame($updatedAt, $image->updated_at->toIso8601String());

        // Idempotent
        $this->artisan('images:move-to-storage')->expectsOutputToContain('0 image(s)')->assertSuccessful();
    }
}
