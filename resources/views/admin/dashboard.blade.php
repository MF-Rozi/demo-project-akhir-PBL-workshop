@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="row g-4">
    <!-- Stats Cards -->
    <div class="col-md-6 col-lg-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h6 class="card-title">Total Zones</h6>
                <h2 class="mb-0">{{ $stats['zones'] }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h6 class="card-title">Total Attractions</h6>
                <h2 class="mb-0">{{ $stats['attractions'] }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <h6 class="card-title">Pending Reviews</h6>
                <h2 class="mb-0">{{ $stats['pending_reviews'] }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <h6 class="card-title">Approved Reviews</h6>
                <h2 class="mb-0">{{ $stats['approved_reviews'] }}</h2>
            </div>
        </div>
    </div>
</div>

<!-- Recent Reviews -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Recent Reviews</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Attraction</th>
                                <th>Visitor</th>
                                <th>Rating</th>
                                <th>Comment</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recent_reviews as $review)
                                <tr>
                                    <td>{{ $review->attraction->name }}</td>
                                    <td>{{ $review->visitor_name }}</td>
                                    <td>
                                        <span class="rating-stars">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $review->rating)
                                                    ★
                                                @else
                                                    ☆
                                                @endif
                                            @endfor
                                        </span>
                                    </td>
                                    <td>{{ Str::limit($review->comment, 50) }}</td>
                                    <td>
                                        @if($review->is_approved)
                                            <span class="badge bg-success">Approved</span>
                                        @else
                                            <span class="badge bg-warning">Pending</span>
                                        @endif
                                    </td>
                                    <td>{{ $review->created_at->format('M d, Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">No reviews yet</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <a href="{{ route('admin.reviews.index') }}" class="btn btn-primary btn-sm">View All Reviews</a>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mt-4">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <h5 class="card-title">Manage Zones</h5>
                <p class="card-text">Add, edit, or delete tourism zones</p>
                <a href="{{ route('admin.zones.index') }}" class="btn btn-primary">Go to Zones</a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <h5 class="card-title">Manage Attractions</h5>
                <p class="card-text">Add, edit, or delete attractions</p>
                <a href="{{ route('admin.attractions.index') }}" class="btn btn-success">Go to Attractions</a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <h5 class="card-title">Moderate Reviews</h5>
                <p class="card-text">Approve or reject visitor reviews</p>
                <a href="{{ route('admin.reviews.index') }}" class="btn btn-warning">Go to Reviews</a>
            </div>
        </div>
    </div>
</div>
@endsection
