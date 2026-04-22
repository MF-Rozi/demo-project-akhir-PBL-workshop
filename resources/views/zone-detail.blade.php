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
        <div class="row g-4">
            <div class="col-lg-8">
                @if($zone->image)
                    <img src="{{ asset('storage/' . $zone->image) }}" class="img-fluid rounded shadow-sm" alt="{{ $zone->name }}">
                @else
                    <div class="bg-secondary rounded" style="height: 320px; display: flex; align-items: center; justify-content: center;">
                        <span class="text-white h5 mb-0">No Image Available</span>
                    </div>
                @endif

                <h1 class="mb-3 mt-4">{{ $zone->name }}</h1>
                <p class="lead">{{ $zone->description }}</p>
                <span class="badge bg-info">{{ $zone->attractions->count() }} Attractions</span>

                @if($averageRating)
                    <div class="card mt-4">
                        <div class="card-body">
                            <h5 class="card-title">Zone Rating</h5>
                            <div class="d-flex align-items-center">
                                <span class="display-6 rating-stars me-3">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= round($averageRating))
                                            ★
                                        @else
                                            ☆
                                        @endif
                                    @endfor
                                </span>
                                <div>
                                    <h4 class="mb-0">{{ number_format($averageRating, 1) }}/5</h4>
                                    <small class="text-muted">{{ $zone->approvedReviews->count() }} reviews</small>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="col-lg-4">
                <div class="card sticky-top" style="top: 20px;">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Leave a Review for {{ $zone->name }}</h5>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('review.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="reviewable_type" value="zone">
                            <input type="hidden" name="reviewable_id" value="{{ $zone->id }}">

                            <div class="mb-3">
                                <label for="visitor_name" class="form-label">Your Name</label>
                                <input type="text" class="form-control @error('visitor_name') is-invalid @enderror"
                                       id="visitor_name" name="visitor_name" value="{{ old('visitor_name') }}" required>
                                @error('visitor_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="visitor_email" class="form-label">Your Email</label>
                                <input type="email" class="form-control @error('visitor_email') is-invalid @enderror"
                                       id="visitor_email" name="visitor_email" value="{{ old('visitor_email') }}" required>
                                @error('visitor_email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="rating" class="form-label">Rating</label>
                                <select class="form-select @error('rating') is-invalid @enderror" id="rating" name="rating" required>
                                    <option value="">Select rating...</option>
                                    <option value="5" {{ old('rating') == 5 ? 'selected' : '' }}>⭐⭐⭐⭐⭐ Excellent</option>
                                    <option value="4" {{ old('rating') == 4 ? 'selected' : '' }}>⭐⭐⭐⭐ Good</option>
                                    <option value="3" {{ old('rating') == 3 ? 'selected' : '' }}>⭐⭐⭐ Average</option>
                                    <option value="2" {{ old('rating') == 2 ? 'selected' : '' }}>⭐⭐ Poor</option>
                                    <option value="1" {{ old('rating') == 1 ? 'selected' : '' }}>⭐ Terrible</option>
                                </select>
                                @error('rating')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="comment" class="form-label">Your Review</label>
                                <textarea class="form-control @error('comment') is-invalid @enderror"
                                          id="comment" name="comment" rows="4" required>{{ old('comment') }}</textarea>
                                @error('comment')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Submit Review</button>
                            <small class="text-muted d-block mt-2">Your review will be published after admin approval.</small>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="pb-4">
    <div class="container">
        <h2 class="mb-4">Visitor Reviews for {{ $zone->name }}</h2>
        @forelse($zone->approvedReviews as $review)
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <h6 class="mb-0">{{ $review->visitor_name }}</h6>
                            <small class="text-muted">{{ $review->created_at->format('M d, Y') }}</small>
                        </div>
                        <span class="rating-stars">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $review->rating)
                                    ★
                                @else
                                    ☆
                                @endif
                            @endfor
                        </span>
                    </div>
                    <p class="mb-0">{{ $review->comment }}</p>
                </div>
            </div>
        @empty
            <p class="text-muted">No reviews yet. Be the first to leave a review!</p>
        @endforelse
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
