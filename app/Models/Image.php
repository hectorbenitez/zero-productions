<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'byte_size', 'checksum', 'caption', 'position',
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

        return round($bytes, 2) . ' ' . $units[$unitIndex];
    }
}
