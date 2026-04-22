<?php

namespace Database\Seeders;

use App\Models\Attraction;
use App\Models\Zone;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class AttractionSeeder extends Seeder
{
    public function run(): void
    {
        $attractions = [
            // Heritage Village attractions
            [
                'zone' => 'Heritage Village',
                'name' => 'Traditional Malay House',
                'description' => 'Beautifully preserved traditional Malay house (Rumah Melayu) showcasing authentic architecture from the 19th century. Features intricate wood carvings and traditional furnishings.',
                'image' => 'ngarai_sianok_1.jpg',
            ],
            [
                'zone' => 'Heritage Village',
                'name' => 'Weaving Workshop',
                'description' => 'Watch skilled artisans demonstrate traditional weaving techniques and create beautiful songket fabric. Visitors can try their hand at this ancient craft.',
                'image' => 'ngarai_sianok_2.jpg',
            ],
            [
                'zone' => 'Heritage Village',
                'name' => 'Heritage Museum',
                'description' => 'Small museum displaying artifacts, photographs, and historical documents from Pekanbaru\'s past. Learn about the city\'s development and cultural evolution.',
                'image' => 'Places-to-visit-in-Sumatra-Berastagi-01-2.jpg',
            ],

            // Cultural Center attractions
            [
                'zone' => 'Cultural Center',
                'name' => 'Performance Hall',
                'description' => 'Modern theater hosting daily traditional dance and music performances. Experience the vibrant performing arts of Riau province.',
                'image' => 'Places-to-Visit-in-Sumatra-Bukit-Lawang-1.jpg',
            ],
            [
                'zone' => 'Cultural Center',
                'name' => 'Art Gallery',
                'description' => 'Contemporary art gallery featuring works by local artists. Rotating exhibitions showcase paintings, sculptures, and mixed media inspired by Malay heritage.',
                'image' => 'Places-to-visit-in-Sumatra-Bukit-Lawang-3.jpg',
            ],
            [
                'zone' => 'Cultural Center',
                'name' => 'Craft Bazaar',
                'description' => 'Browse and purchase authentic handicrafts, textiles, and souvenirs made by local artisans. All items are handmade using traditional methods.',
                'image' => 'Places-to-Visit-in-Sumatra-Bukit-Lawang.jpg',
            ],

            // Garden District attractions
            [
                'zone' => 'Garden District',
                'name' => 'Orchid Garden',
                'description' => 'Stunning collection of tropical orchids native to Sumatra. Features over 100 species in a climate-controlled greenhouse.',
                'image' => 'Places-to-visit-in-Sumatra-Hpiso-Sipo-Waterfall.jpg',
            ],
            [
                'zone' => 'Garden District',
                'name' => 'Meditation Pavilion',
                'description' => 'Peaceful pavilion surrounded by lotus ponds. Perfect spot for meditation, yoga, or quiet contemplation.',
                'image' => 'Places-to-visit-in-Sumatra-Mount-Sibayak.jpg',
            ],
            [
                'zone' => 'Garden District',
                'name' => 'Butterfly Park',
                'description' => 'Enclosed garden habitat housing dozens of butterfly species. Educational displays teach about butterfly life cycles and conservation.',
                'image' => 'Places-to-visit-in-Sumatra-Tangkahan-1.jpg',
            ],

            // Food Court attractions
            [
                'zone' => 'Food Court',
                'name' => 'Riau Traditional Kitchen',
                'description' => 'Authentic Riau cuisine including gulai ikan patin, nasi lemak, and rendang. Family recipes passed down through generations.',
                'image' => 'Places-to-visit-in-Sumatra-Tangkahan.jpg',
            ],
            [
                'zone' => 'Food Court',
                'name' => 'Sweet Treats Corner',
                'description' => 'Traditional Indonesian desserts and snacks including kue lapis, onde-onde, and es campur. Fresh ingredients and authentic flavors.',
                'image' => 'Places-to-Visit-in-Sumatra-Lake-Toba.jpg',
            ],
            [
                'zone' => 'Food Court',
                'name' => 'Coffee & Tea House',
                'description' => 'Sample traditional Indonesian coffee and tea varieties. Try kopi tubruk and various herbal teas in a relaxing atmosphere.',
                'image' => 'Places-to-visit-in-Sumatra-Banda-Aceh.jpg',
            ],
        ];

        foreach ($attractions as $attraction) {
            $zoneId = Zone::where('name', $attraction['zone'])->value('id');

            if (! $zoneId) {
                continue;
            }

            $imagePath = $this->syncImageToPublicDisk($attraction['image']);

            $existingAttraction = Attraction::where('zone_id', $zoneId)
                ->where('name', $attraction['name'])
                ->first();

            if (! $existingAttraction) {
                continue;
            }

            $existingAttraction->update([
                'description' => $attraction['description'],
                'image' => $imagePath,
            ]);
        }
    }

    private function syncImageToPublicDisk(string $filename): string
    {
        $sourcePath = storage_path('img/' . $filename);

        if (! File::exists($sourcePath)) {
            throw new \RuntimeException("Attraction image file not found: {$filename}");
        }

        $destinationPath = 'img/' . $filename;

        if (! Storage::disk('public')->exists($destinationPath)) {
            Storage::disk('public')->put($destinationPath, File::get($sourcePath));
        }

        return $destinationPath;
    }
}
