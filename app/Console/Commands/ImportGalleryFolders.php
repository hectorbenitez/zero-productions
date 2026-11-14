<?php

namespace App\Console\Commands;

use App\Models\Event;
use App\Models\Image;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ImportGalleryFolders extends Command
{
    protected $signature = 'images:import-gallery-folders {--dry-run : List what would be imported}';

    protected $description = 'Import photos from public/assets/gallery/{event_id}/ as gallery images in object storage';

    private const EXTENSIONS = ['jpg', 'jpeg', 'png', 'webp', 'gif'];

    public function handle(): int
    {
        $root = public_path('assets/gallery');

        if (! File::isDirectory($root)) {
            $this->info('No gallery folders.');

            return self::SUCCESS;
        }

        $imported = 0;

        foreach (File::directories($root) as $dir) {
            $event = Event::find(basename($dir));

            if (! $event) {
                $this->warn('Folder '.basename($dir).': no event with that id, skipped.');

                continue;
            }

            $files = collect(File::files($dir))
                ->filter(fn ($file) => in_array(strtolower($file->getExtension()), self::EXTENSIONS))
                ->sortBy(fn ($file) => $file->getFilename())
                ->values();

            $existing = $event->galleryImages()->pluck('checksum')->filter()->all();
            $position = ($event->galleryImages()->max('position') ?? -1) + 1;

            foreach ($files as $file) {
                $contents = File::get($file->getPathname());
                $checksum = md5($contents);

                if (in_array($checksum, $existing, true)) {
                    $this->line("{$event->slug}: {$file->getFilename()} already imported.");

                    continue;
                }

                if ($this->option('dry-run')) {
                    $this->line("{$event->slug}: would import {$file->getFilename()}.");

                    continue;
                }

                $mime = File::mimeType($file->getPathname());
                $path = Image::putContents($contents, $mime, strtolower($file->getExtension()));

                Image::create([
                    'event_id' => $event->id,
                    'kind' => 'gallery',
                    'mime_type' => $mime,
                    'filename' => $file->getFilename(),
                    'byte_size' => strlen($contents),
                    'checksum' => $checksum,
                    'path' => $path,
                    'position' => $position++,
                ]);

                $existing[] = $checksum;
                $imported++;
                $this->line("{$event->slug}: {$file->getFilename()} → {$path}");
            }
        }

        $this->info("{$imported} photo(s) imported.");

        return self::SUCCESS;
    }
}
