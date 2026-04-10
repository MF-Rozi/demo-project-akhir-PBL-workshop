<?php

namespace Database\Seeders;

use App\Models\Attraction;
use Illuminate\Database\Seeder;

class AttractionSeeder extends Seeder
{
    public function run(): void
    {
        $attractions = [
            // Heritage Village attractions
            [
                'zone_id' => 1,
                'name' => 'Traditional Malay House',
                'description' => 'Beautifully preserved traditional Malay house (Rumah Melayu) showcasing authentic architecture from the 19th century. Features intricate wood carvings and traditional furnishings.',
            ],
            [
                'zone_id' => 1,
                'name' => 'Weaving Workshop',
                'description' => 'Watch skilled artisans demonstrate traditional weaving techniques and create beautiful songket fabric. Visitors can try their hand at this ancient craft.',
            ],
            [
                'zone_id' => 1,
                'name' => 'Heritage Museum',
                'description' => 'Small museum displaying artifacts, photographs, and historical documents from Pekanbaru\'s past. Learn about the city\'s development and cultural evolution.',
            ],
            
            // Cultural Center attractions
            [
                'zone_id' => 2,
                'name' => 'Performance Hall',
                'description' => 'Modern theater hosting daily traditional dance and music performances. Experience the vibrant performing arts of Riau province.',
            ],
            [
                'zone_id' => 2,
                'name' => 'Art Gallery',
                'description' => 'Contemporary art gallery featuring works by local artists. Rotating exhibitions showcase paintings, sculptures, and mixed media inspired by Malay heritage.',
            ],
            [
                'zone_id' => 2,
                'name' => 'Craft Bazaar',
                'description' => 'Browse and purchase authentic handicrafts, textiles, and souvenirs made by local artisans. All items are handmade using traditional methods.',
            ],
            
            // Garden District attractions
            [
                'zone_id' => 3,
                'name' => 'Orchid Garden',
                'description' => 'Stunning collection of tropical orchids native to Sumatra. Features over 100 species in a climate-controlled greenhouse.',
            ],
            [
                'zone_id' => 3,
                'name' => 'Meditation Pavilion',
                'description' => 'Peaceful pavilion surrounded by lotus ponds. Perfect spot for meditation, yoga, or quiet contemplation.',
            ],
            [
                'zone_id' => 3,
                'name' => 'Butterfly Park',
                'description' => 'Enclosed garden habitat housing dozens of butterfly species. Educational displays teach about butterfly life cycles and conservation.',
            ],
            
            // Food Court attractions
            [
                'zone_id' => 4,
                'name' => 'Riau Traditional Kitchen',
                'description' => 'Authentic Riau cuisine including gulai ikan patin, nasi lemak, and rendang. Family recipes passed down through generations.',
            ],
            [
                'zone_id' => 4,
                'name' => 'Sweet Treats Corner',
                'description' => 'Traditional Indonesian desserts and snacks including kue lapis, onde-onde, and es campur. Fresh ingredients and authentic flavors.',
            ],
            [
                'zone_id' => 4,
                'name' => 'Coffee & Tea House',
                'description' => 'Sample traditional Indonesian coffee and tea varieties. Try kopi tubruk and various herbal teas in a relaxing atmosphere.',
            ],
        ];

        foreach ($attractions as $attraction) {
            Attraction::create($attraction);
        }
    }
}
