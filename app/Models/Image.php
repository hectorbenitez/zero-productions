<?php

namespace App\Models;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'kind',
        'mime_type',
        'filename',
        'byte_size',
        'checksum',
        'path',
        'data',
        'caption',
        'position',
    ];

    /**
     * The attributes that should be hidden for serialization.
     * We don't want to accidentally serialize binary data.
     */
    protected $hidden = [
        'data',
    ];

    /**
     * Columns to select by default (excludes binary 'data' column).
     */
    protected static array $defaultColumns = [
        'id', 'event_id', 'kind', 'mime_type', 'filename',
        'byte_size', 'checksum', 'path', 'caption', 'position',
        'created_at', 'updated_at',
    ];

    /**
     * Boot the model - exclude 'data' column from default queries.
     */
    protected static function booted(): void
    {
        static::addGlobalScope('exclude_data', function (Builder $builder) {
            $builder->select(static::$defaultColumns);
        });

        // Remove the stored object when the row goes away
        static::deleted(function (Image $image) {
            if ($image->path) {
                try {
                    static::disk()->delete($image->path);
                } catch (\Throwable $e) {
                    report($e); // an orphaned object is harmless; don't fail the request
                }
            }
        });
    }

    /**
     * The disk that holds image files (Garage in production).
     */
    public static function disk(): Filesystem
    {
        return Storage::disk(config('filesystems.images_disk'));
    }

    /**
     * Upload a file to the images disk and create its row.
     */
    public static function storeUpload(UploadedFile $file, array $attributes): self
    {
        $contents = file_get_contents($file->getRealPath());
        $path = static::putContents($contents, $file->getMimeType(), $file->extension());

        return static::create($attributes + [
            'mime_type' => $file->getMimeType(),
            'filename' => $file->getClientOriginalName(),
            'byte_size' => strlen($contents),
            'checksum' => md5($contents),
            'path' => $path,
        ]);
    }

    /**
     * Write bytes to the images disk under a generated key and return the key.
     */
    public static function putContents(string $contents, string $mimeType, ?string $extension = null): string
    {
        $extension = $extension ?: (explode('/', $mimeType)[1] ?? 'bin');
        $path = 'images/'.Str::uuid().'.'.$extension;

        if (! static::disk()->put($path, $contents, ['ContentType' => $mimeType])) {
            throw new RuntimeException("Could not write image to [{$path}].");
        }

        return $path;
    }

    /**
     * The image bytes: from the images disk, or the legacy base64 column.
     */
    public function contents(): ?string
    {
        if ($this->path) {
            return static::disk()->get($this->path);
        }

        $data = static::withData()->whereKey($this->getKey())->value('data');

        return $data === null ? null : base64_decode($data);
    }

    /**
     * Scope to include the binary data column (for serving images).
     */
    public function scopeWithData(Builder $query): Builder
    {
        return $query->withoutGlobalScope('exclude_data');
    }

    /**
     * Get the event that owns the image.
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Scope for cover images.
     */
    public function scopeCovers($query)
    {
        return $query->where('kind', 'cover');
    }

    /**
     * Scope for gallery images.
     */
    public function scopeGallery($query)
    {
        return $query->where('kind', 'gallery');
    }

    /**
     * Check if this is a cover image.
     */
    public function isCover(): bool
    {
        return $this->kind === 'cover';
    }

    /**
     * Check if this is a gallery image.
     */
    public function isGallery(): bool
    {
        return $this->kind === 'gallery';
    }

    /**
     * Get the URL for this image.
     */
    public function getUrlAttribute(): string
    {
        return route('media.show', $this);
    }

    /**
     * Get formatted file size.
     */
    public function getFormattedSizeAttribute(): string
    {
        $bytes = $this->byte_size;
        $units = ['B', 'KB', 'MB', 'GB'];
        $unitIndex = 0;

        while ($bytes >= 1024 && $unitIndex < count($units) - 1) {
            $bytes /= 1024;
            $unitIndex++;
        }

        return round($bytes, 2).' '.$units[$unitIndex];
    }
}
