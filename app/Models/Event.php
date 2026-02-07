<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'venue',
        'city',
        'event_datetime',
        'status',
        'cover_image_id',
        'flyer_image_id',
    ];

    protected $casts = [
        'event_datetime' => 'datetime',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($event) {
            if (empty($event->slug)) {
                $event->slug = static::generateUniqueSlug($event->title);
            }
        });
    }

    /**
     * Generate a unique slug from the title.
     */
    public static function generateUniqueSlug(string $title): string
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $count = 1;

        while (static::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        return $slug;
    }

    /**
     * Get the cover image.
     */
    public function coverImage(): BelongsTo
    {
        return $this->belongsTo(Image::class, 'cover_image_id');
    }

    /**
     * Get the flyer image.
     */
    public function flyerImage(): BelongsTo
    {
        return $this->belongsTo(Image::class, 'flyer_image_id');
    }

    /**
     * Get the ticket/external links for the event.
     */
    public function links(): HasMany
    {
        return $this->hasMany(EventLink::class)->orderBy('position');
    }

    /**
     * Get the gallery images for the event.
     */
    public function galleryImages(): HasMany
    {
        return $this->hasMany(Image::class)->where('kind', 'gallery')->orderBy('position');
    }

    /**
     * Get all images for the event.
     */
    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }

    /**
     * Scope for published events.
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    /**
     * Scope for upcoming events.
     */
    public function scopeUpcoming($query)
    {
        return $query->where('event_datetime', '>=', now());
    }

    /**
     * Scope for past events.
     */
    public function scopePast($query)
    {
        return $query->where('event_datetime', '<', now());
    }

    /**
     * Check if the event is upcoming.
     */
    public function isUpcoming(): bool
    {
        return $this->event_datetime >= now();
    }

    /**
     * Check if the event is past.
     */
    public function isPast(): bool
    {
        return $this->event_datetime < now();
    }

    /**
     * Get formatted date in Spanish.
     */
    public function getFormattedDateAttribute(): string
    {
        Carbon::setLocale('es');
        return $this->event_datetime->translatedFormat('l, j \d\e F \d\e Y');
    }

    /**
     * Get formatted time.
     */
    public function getFormattedTimeAttribute(): string
    {
        return $this->event_datetime->format('H:i') . ' hrs';
    }

    /**
     * Get formatted datetime in Spanish.
     */
    public function getFormattedDatetimeAttribute(): string
    {
        Carbon::setLocale('es');
        return $this->event_datetime->translatedFormat('l, j \d\e F \d\e Y - H:i') . ' hrs';
    }

    /**
     * Get the location string.
     */
    public function getLocationAttribute(): ?string
    {
        $parts = array_filter([$this->venue, $this->city]);
        return count($parts) > 0 ? implode(', ', $parts) : null;
    }

    /**
     * Get filesystem gallery images for this event.
     * Looks in public/assets/gallery/{event_id}/ for image files.
     *
     * @return array Array of ['url' => string, 'filename' => string]
     */
    public function getFilesystemGalleryAttribute(): array
    {
        $galleryPath = public_path("assets/gallery/{$this->id}");

        if (!File::isDirectory($galleryPath)) {
            return [];
        }

        $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        $images = [];

        $files = File::files($galleryPath);

        // Sort files by name for consistent ordering
        usort($files, function ($a, $b) {
            return strcmp($a->getFilename(), $b->getFilename());
        });

        foreach ($files as $file) {
            $extension = strtolower($file->getExtension());
            if (in_array($extension, $allowedExtensions)) {
                $images[] = [
                    'url' => asset("assets/gallery/{$this->id}/{$file->getFilename()}"),
                    'filename' => $file->getFilename(),
                ];
            }
        }

        return $images;
    }

    /**
     * Check if the event has a filesystem gallery.
     */
    public function getHasFilesystemGalleryAttribute(): bool
    {
        return count($this->filesystem_gallery) > 0;
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
