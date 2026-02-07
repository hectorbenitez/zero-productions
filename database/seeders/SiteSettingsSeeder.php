<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SiteSetting::updateOrCreate(
            ['id' => 1],
            [
                'company_name' => 'Zero Productions',
                'contact_email' => 'contacto@zeroproductions.com',
                'contact_phone' => '+52 55 1234 5678',
                'whatsapp' => '+525512345678',
                'instagram_url' => 'https://instagram.com/zeroproductions',
                'facebook_url' => 'https://facebook.com/zeroproductions',
                'youtube_url' => 'https://youtube.com/@zeroproductions',
                'address' => 'Ciudad de México, México',
                'hero_title' => 'ZERO PRODUCTIONS',
                'hero_subtitle' => 'Experiencias musicales que trascienden',
            ]
        );
    }
}
