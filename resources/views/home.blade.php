@extends('layouts.public')

@section('title', 'Welcome to Asia Heritage Pekanbaru')

@section('content')
<!-- Hero Section -->
<div class="bg-primary text-white py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-4 fw-bold">Welcome to Asia Heritage Pekanbaru</h1>
                <p class="lead">Discover the rich cultural heritage and traditional attractions of Riau Province</p>
            </div>
        </div>
    </div>
</div>

<!-- Zones Section -->
<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-4">Explore Our Zones</h2>
        <div class="row g-4">
            @forelse($zones as $zone)
                <div class="col-md-6 col-lg-3">
                    <div class="card zone-card h-100 shadow-sm">
                        @if($zone->image)
                            <img src="{{ asset('storage/' . $zone->image) }}" class="card-img-top" alt="{{ $zone->name }}" style="height: 200px; object-fit: cover;">
                        @else
                            <div class="bg-secondary" style="height: 200px; display: flex; align-items: center; justify-content: center;">
                                <span class="text-white">No Image</span>
                            </div>
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $zone->name }}</h5>
                            <p class="card-text text-muted small">{{ Str::limit($zone->description, 80) }}</p>
                            <p class="mb-0">
                                <span class="badge bg-info">{{ $zone->attractions_count }} Attractions</span>
                            </p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-center text-muted">No zones available yet.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Attractions Section -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-4">Featured Attractions</h2>
        <div class="row g-4">
            @forelse($attractions as $attraction)
                <div class="col-md-6 col-lg-4">
                    <div class="card attraction-card h-100 shadow-sm">
                        @if($attraction->image)
                            <img src="{{ asset('storage/' . $attraction->image) }}" class="card-img-top" alt="{{ $attraction->name }}" style="height: 200px; object-fit: cover;">
                        @else
                            <div class="bg-secondary" style="height: 200px; display: flex; align-items: center; justify-content: center;">
                                <span class="text-white">No Image</span>
                            </div>
                        @endif
                        <div class="card-body d-flex flex-column">
                            <span class="badge bg-primary mb-2 align-self-start">{{ $attraction->zone->name }}</span>
                            <h5 class="card-title">{{ $attraction->name }}</h5>
                            <p class="card-text flex-grow-1">{{ Str::limit($attraction->description, 100) }}</p>
                            
                            @php
                                $avgRating = $attraction->averageRating();
                                $reviewCount = $attraction->approvedReviews()->count();
                            @endphp
                            
                            @if($reviewCount > 0)
                                <div class="mb-2">
                                    <span class="rating-stars">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= round($avgRating))
                                                ★
                                            @else
                                                ☆
                                            @endif
                                        @endfor
                                    </span>
                                    <small class="text-muted">({{ $reviewCount }} reviews)</small>
                                </div>
                            @endif
                            
                            <a href="{{ route('attraction.show', $attraction->id) }}" class="btn btn-outline-primary btn-sm mt-auto">View Details</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-center text-muted">No attractions available yet.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
