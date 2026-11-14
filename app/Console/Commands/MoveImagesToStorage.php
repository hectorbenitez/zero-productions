<?php

namespace App\Console\Commands;

use App\Models\Image;
use Illuminate\Console\Command;

class MoveImagesToStorage extends Command
{
    protected $signature = 'images:move-to-storage {--dry-run : List what would be copied}';

    protected $description = 'Copy images still stored as base64 in the DB to the images disk (keeps the DB copy)';

    public function handle(): int
    {
        $ids = Image::whereNull('path')->orderBy('id')->pluck('id');
        $this->info("{$ids->count()} image(s) without a stored file.");

        $failed = 0;

        foreach ($ids as $id) {
            $image = Image::withData()->find($id);
            $contents = $image?->data === null ? false : base64_decode($image->data, true);

            if ($contents === false) {
                $this->error("#{$id}: no valid base64 data, skipped.");
                $failed++;

                continue;
            }

            if ((int) $image->byte_size !== strlen($contents) || ($image->checksum && $image->checksum !== md5($contents))) {
                $this->warn("#{$id}: size/checksum differ from the row's metadata; copying the bytes as stored.");
            }

            if ($this->option('dry-run')) {
                $this->line("#{$id}: would copy ".strlen($contents).' bytes.');

                continue;
            }

            $path = Image::putContents($contents, $image->mime_type);

            if (md5((string) Image::disk()->get($path)) !== md5($contents)) {
                Image::disk()->delete($path);
                $this->error("#{$id}: read-back mismatch, skipped.");
                $failed++;

                continue;
            }

            // Query builder update: keeps updated_at (Last-Modified) unchanged
            Image::whereKey($id)->whereNull('path')->toBase()->update(['path' => $path]);
            $this->line("#{$id}: {$path}");
        }

        return $failed ? self::FAILURE : self::SUCCESS;
    }
}
