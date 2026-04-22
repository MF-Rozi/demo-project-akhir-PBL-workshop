<?php

namespace Database\Seeders;

use App\Models\Zone;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ZoneSeeder extends Seeder
{
    public function run(): void
    {
        $zones = [
            [
                'name' => 'Heritage Village',
                'description' => 'Experience traditional Malay architecture and culture in this authentic village setting. The Heritage Village showcases the rich history of Pekanbaru with traditional houses, cultural performances, and local crafts.',
                'image' => 'ngarai_sianok_banner.webp',
            ],
            [
                'name' => 'Cultural Center',
                'description' => 'A modern hub celebrating Pekanbaru\'s diverse cultural heritage. Features exhibition halls, performance spaces, and interactive displays highlighting the region\'s art, music, and traditions.',
                'image' => 'Places-to-visit-in-Sumatra-Banda-Aceh.jpg',
            ],
            [
                'name' => 'Garden District',
                'description' => 'Beautiful landscaped gardens featuring native plants and traditional Indonesian garden design. A peaceful retreat perfect for relaxation and photography.',
                'image' => 'Places-to-Visit-in-Sumatra-Lake-Toba.jpg',
            ],
            [
                'name' => 'Food Court',
                'description' => 'Taste authentic Riau cuisine and traditional Indonesian dishes. The food court offers a wide variety of local delicacies and beverages in a comfortable, family-friendly environment.',
                'image' => 'Places-to-visit-in-Sumatra-Toba-Lake.jpg',
            ],
        ];

        foreach ($zones as $zone) {
            $zone['image'] = $this->syncImageToPublicDisk($zone['image']);

            $existingZone = Zone::where('name', $zone['name'])->first();

            if (! $existingZone) {
                continue;
            }

            $existingZone->update($zone);
        }
    }

    private function syncImageToPublicDisk(string $filename): string
    {
        $sourcePath = storage_path('img/' . $filename);

        if (! File::exists($sourcePath)) {
            throw new \RuntimeException("Zone image file not found: {$filename}");
        }

        $destinationPath = 'img/' . $filename;

        if (! Storage::disk('public')->exists($destinationPath)) {
            Storage::disk('public')->put($destinationPath, File::get($sourcePath));
        }

        return $destinationPath;
    }
}
