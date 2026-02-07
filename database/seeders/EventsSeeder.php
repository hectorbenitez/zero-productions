<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\EventLink;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class EventsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Upcoming Event 1 - 2 months from now
        $event1 = Event::create([
            'title' => 'Noche de Rock en Vivo',
            'slug' => 'noche-de-rock-en-vivo',
            'description' => "Una noche épica con las mejores bandas de rock en español.\n\nDisfruta de un espectáculo inolvidable con artistas de primer nivel en un ambiente único. No te pierdas esta oportunidad de vivir la música en vivo como nunca antes.\n\nPuertas abren: 19:00\nInicio del show: 20:30",
            'venue' => 'Arena Ciudad de México',
            'city' => 'Ciudad de México',
            'event_datetime' => Carbon::now()->addMonths(2)->setTime(20, 30),
            'status' => 'published',
        ]);

        EventLink::create([
            'event_id' => $event1->id,
            'label' => 'Ticketmaster',
            'url' => 'https://www.ticketmaster.com.mx',
            'position' => 0,
        ]);

        EventLink::create([
            'event_id' => $event1->id,
            'label' => 'Boletia',
            'url' => 'https://www.boletia.com',
            'position' => 1,
        ]);

        // Upcoming Event 2 - 3 months from now
        $event2 = Event::create([
            'title' => 'Festival Electrónica 2026',
            'slug' => 'festival-electronica-2026',
            'description' => "El festival de música electrónica más grande de Latinoamérica.\n\n3 escenarios, 20+ artistas, una experiencia de otro mundo.\n\nLineup completo próximamente.",
            'venue' => 'Foro Sol',
            'city' => 'Ciudad de México',
            'event_datetime' => Carbon::now()->addMonths(3)->setTime(16, 0),
            'status' => 'published',
        ]);

        EventLink::create([
            'event_id' => $event2->id,
            'label' => 'Comprar Boletos',
            'url' => 'https://www.ticketmaster.com.mx',
            'position' => 0,
        ]);

        // Past Event - 1 month ago
        $event3 = Event::create([
            'title' => 'Concierto Acústico - Edición Especial',
            'slug' => 'concierto-acustico-edicion-especial',
            'description' => "Una velada íntima con los mejores intérpretes acústicos del momento.\n\nGracias a todos los que nos acompañaron en esta noche mágica.",
            'venue' => 'Teatro Metropolitan',
            'city' => 'Ciudad de México',
            'event_datetime' => Carbon::now()->subMonth()->setTime(20, 0),
            'status' => 'published',
        ]);

        // Note: No images are seeded as they require binary data
        // Gallery images can be added through the admin panel
    }
}
