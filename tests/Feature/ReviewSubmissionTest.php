<?php

use App\Models\Attraction;
use App\Models\Review;
use App\Models\Zone;

it('allows visitors to submit attraction reviews', function () {
    $zone = Zone::create([
        'name' => 'Coastal Zone',
        'description' => 'Beach destinations.',
    ]);

    $attraction = Attraction::create([
        'zone_id' => $zone->id,
        'name' => 'Sunny Beach',
        'description' => 'A beautiful and relaxing coastal beach.',
    ]);

    $response = $this->post(route('review.store'), [
        'reviewable_type' => 'attraction',
        'reviewable_id' => $attraction->id,
        'visitor_name' => 'Visitor One',
        'visitor_email' => 'visitor1@example.com',
        'rating' => 5,
        'comment' => 'Wonderful place with clean water and amazing sunset views.',
    ]);

    $response->assertSessionHas('success');

    expect(Review::count())->toBe(1);
    expect(Review::first()->reviewable_type)->toBe(Attraction::class);
    expect(Review::first()->reviewable_id)->toBe($attraction->id);
});

it('allows visitors to submit zone reviews', function () {
    $zone = Zone::create([
        'name' => 'Highland Zone',
        'description' => 'Mountain area with cool weather.',
    ]);

    $response = $this->post(route('review.store'), [
        'reviewable_type' => 'zone',
        'reviewable_id' => $zone->id,
        'visitor_name' => 'Visitor Two',
        'visitor_email' => 'visitor2@example.com',
        'rating' => 4,
        'comment' => 'The area is clean and peaceful with very friendly people.',
    ]);

    $response->assertSessionHas('success');

    expect(Review::count())->toBe(1);
    expect(Review::first()->reviewable_type)->toBe(Zone::class);
    expect(Review::first()->reviewable_id)->toBe($zone->id);
});
