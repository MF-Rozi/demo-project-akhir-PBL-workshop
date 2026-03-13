@extends('layouts.public')

@section('title', $zone->name)

@section('content')
<nav aria-label="breadcrumb" class="bg-light py-3">
    <div class="container">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">{{ $zone->name }}</li>
        </ol>
    </div>
</nav>

<section class="py-5">
    <div class="container">
        <div class="row g-4 align-items-start">
            <div class="col-lg-5">
                @if($zone->image)
                    <img src="{{ asset('storage/' . $zone->image) }}" class="img-fluid rounded shadow-sm" alt="{{ $zone->name }}">
                @else
                    <div class="bg-secondary rounded" style="height: 320px; display: flex; align-items: center; justify-content: center;">
                        <span class="text-white h5 mb-0">No Image Available</span>
                    </div>
                @endif
            </div>
            <div class="col-lg-7">
                <h1 class="mb-3">{{ $zone->name }}</h1>
                <p class="lead">{{ $zone->description }}</p>
                <span class="badge bg-info">{{ $zone->attractions->count() }} Attractions</span>
            </div>
        </div>
    </div>
</section>

<section class="pb-5">
    <div class="container">
        <h2 class="mb-4">Attractions in {{ $zone->name }}</h2>
        <div class="row g-4">
            @forelse($zone->attractions as $attraction)
                <div class="col-md-6 col-lg-4">
                    <a href="{{ route('attraction.show', $attraction->id) }}" class="text-decoration-none text-reset">
                        <div class="card h-100 shadow-sm">
                            @if($attraction->image)
                                <img src="{{ asset('storage/' . $attraction->image) }}" class="card-img-top" alt="{{ $attraction->name }}" style="height: 200px; object-fit: cover;">
                            @else
                                <div class="bg-secondary" style="height: 200px; display: flex; align-items: center; justify-content: center;">
                                    <span class="text-white">No Image</span>
                                </div>
                            @endif
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $attraction->name }}</h5>
                                <p class="card-text flex-grow-1">{{ Str::limit($attraction->description, 110) }}</p>
                                <span class="btn btn-outline-primary btn-sm mt-auto align-self-start">View Details</span>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-muted mb-0">No attractions found in this zone.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
