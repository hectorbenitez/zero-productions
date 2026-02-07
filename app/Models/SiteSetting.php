<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'contact_email',
        'contact_phone',
        'whatsapp',
        'instagram_url',
        'facebook_url',
        'youtube_url',
        'address',
        'hero_title',
        'hero_subtitle',
    ];

    /**
     * Get the singleton site settings instance.
     */
    public static function instance(): static
    {
        return static::firstOrCreate(['id' => 1], [
            'company_name' => 'Zero Productions',
            'contact_email' => 'contacto@zeroproductions.com',
        ]);
    }

    /**
     * Check if Instagram URL is set.
     */
    public function hasInstagram(): bool
    {
        return !empty($this->instagram_url);
    }

    /**
     * Check if Facebook URL is set.
     */
    public function hasFacebook(): bool
    {
        return !empty($this->facebook_url);
    }

    /**
     * Check if YouTube URL is set.
     */
    public function hasYoutube(): bool
    {
        return !empty($this->youtube_url);
    }

    /**
     * Check if WhatsApp is set.
     */
    public function hasWhatsapp(): bool
    {
        return !empty($this->whatsapp);
    }

    /**
     * Get WhatsApp URL.
     */
    public function getWhatsappUrlAttribute(): ?string
    {
        if (!$this->hasWhatsapp()) {
            return null;
        }

        // Clean the phone number
        $phone = preg_replace('/[^0-9]/', '', $this->whatsapp);
        return "https://wa.me/{$phone}";
    }

    /**
     * Check if any social links are set.
     */
    public function hasSocialLinks(): bool
    {
        return $this->hasInstagram() || $this->hasFacebook() || $this->hasYoutube();
    }
}
