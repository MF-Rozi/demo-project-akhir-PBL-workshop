@extends('layouts.public')

@section('title', $attraction->name)

@section('content')
<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="bg-light py-3">
    <div class="container">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ $attraction->zone->name }}</a></li>
            <li class="breadcrumb-item active">{{ $attraction->name }}</li>
        </ol>
    </div>
</nav>

<!-- Attraction Details -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <!-- Image -->
                @if($attraction->image)
                    <img src="{{ asset('storage/' . $attraction->image) }}" class="img-fluid rounded shadow-sm mb-4" alt="{{ $attraction->name }}">
                @else
                    <div class="bg-secondary rounded mb-4" style="height: 400px; display: flex; align-items: center; justify-content: center;">
                        <span class="text-white h3">No Image Available</span>
                    </div>
                @endif

                <!-- Details -->
                <h1 class="mb-3">{{ $attraction->name }}</h1>
                <p class="lead">{{ $attraction->description }}</p>

                <!-- Rating Summary -->
                @if($averageRating)
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Rating & Reviews</h5>
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
                                    <small class="text-muted">{{ $attraction->approvedReviews->count() }} reviews</small>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Reviews List -->
                <h3 class="mb-4">Visitor Reviews</h3>
                @forelse($attraction->approvedReviews as $review)
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

            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="card sticky-top" style="top: 20px;">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Leave a Review</h5>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('review.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="attraction_id" value="{{ $attraction->id }}">

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

                <!-- Zone Info -->
                <div class="card mt-3">
                    <div class="card-header">
                        <h6 class="mb-0">Location Zone</h6>
                    </div>
                    <div class="card-body">
                        <h5>{{ $attraction->zone->name }}</h5>
                        <p class="mb-0 small text-muted">{{ $attraction->zone->description }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
