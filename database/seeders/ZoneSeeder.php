<?php

namespace Database\Seeders;

use App\Models\Zone;
use Illuminate\Database\Seeder;

class ZoneSeeder extends Seeder
{
    public function run(): void
    {
        $zones = [
            [
                'name' => 'Heritage Village',
                'description' => 'Experience traditional Malay architecture and culture in this authentic village setting. The Heritage Village showcases the rich history of Pekanbaru with traditional houses, cultural performances, and local crafts.',
            ],
            [
                'name' => 'Cultural Center',
                'description' => 'A modern hub celebrating Pekanbaru\'s diverse cultural heritage. Features exhibition halls, performance spaces, and interactive displays highlighting the region\'s art, music, and traditions.',
            ],
            [
                'name' => 'Garden District',
                'description' => 'Beautiful landscaped gardens featuring native plants and traditional Indonesian garden design. A peaceful retreat perfect for relaxation and photography.',
            ],
            [
                'name' => 'Food Court',
                'description' => 'Taste authentic Riau cuisine and traditional Indonesian dishes. The food court offers a wide variety of local delicacies and beverages in a comfortable, family-friendly environment.',
            ],
        ];

        foreach ($zones as $zone) {
            Zone::create($zone);
        }
    }
}
