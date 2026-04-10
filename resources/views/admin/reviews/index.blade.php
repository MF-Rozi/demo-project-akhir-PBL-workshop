@extends('layouts.admin')

@section('title', 'Reviews')
@section('page-title', 'Manage Reviews')

@section('content')
<div class="mb-4">
    <div class="btn-group" role="group">
        <a href="{{ route('admin.reviews.index') }}" class="btn btn-outline-primary {{ !request('status') ? 'active' : '' }}">
            All Reviews
        </a>
        <a href="{{ route('admin.reviews.index', ['status' => 'pending']) }}" class="btn btn-outline-warning {{ request('status') === 'pending' ? 'active' : '' }}">
            Pending
        </a>
        <a href="{{ route('admin.reviews.index', ['status' => 'approved']) }}" class="btn btn-outline-success {{ request('status') === 'approved' ? 'active' : '' }}">
            Approved
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Attraction</th>
                        <th>Zone</th>
                        <th>Visitor</th>
                        <th>Rating</th>
                        <th>Comment</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reviews as $review)
                        <tr>
                            <td>{{ $review->attraction->name }}</td>
                            <td>{{ $review->attraction->zone->name }}</td>
                            <td>
                                <strong>{{ $review->visitor_name }}</strong><br>
                                <small class="text-muted">{{ $review->visitor_email }}</small>
                            </td>
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
                                <small>({{ $review->rating }}/5)</small>
                            </td>
                            <td>{{ Str::limit($review->comment, 60) }}</td>
                            <td>{{ $review->created_at->format('M d, Y H:i') }}</td>
                            <td>
                                @if($review->is_approved)
                                    <span class="badge bg-success">Approved</span>
                                @else
                                    <span class="badge bg-warning">Pending</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    @if(!$review->is_approved)
                                        <form action="{{ route('admin.reviews.approve', $review) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success">Approve</button>
                                        </form>
                                    @endif
                                    <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to delete this review?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">No reviews found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $reviews->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection
