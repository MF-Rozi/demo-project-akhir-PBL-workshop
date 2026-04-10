@extends('layouts.admin')

@section('title', 'Attractions')
@section('page-title', 'Manage Attractions')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>All Attractions</h4>
    <a href="{{ route('admin.attractions.create') }}" class="btn btn-primary">Add New Attraction</a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Zone</th>
                        <th>Reviews</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($attractions as $attraction)
                        <tr>
                            <td>
                                @if($attraction->image)
                                    <img src="{{ asset('storage/' . $attraction->image) }}" alt="{{ $attraction->name }}" 
                                         style="width: 60px; height: 60px; object-fit: cover;" class="rounded">
                                @else
                                    <div class="bg-secondary rounded" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                                        <small class="text-white">No Image</small>
                                    </div>
                                @endif
                            </td>
                            <td>{{ $attraction->name }}</td>
                            <td>{{ Str::limit($attraction->description, 80) }}</td>
                            <td>
                                <span class="badge bg-primary">{{ $attraction->zone->name }}</span>
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $attraction->reviews_count }}</span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.attractions.edit', $attraction) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('admin.attractions.destroy', $attraction) }}" method="POST" class="d-inline" 
                                          onsubmit="return confirm('Are you sure you want to delete this attraction? All reviews for this attraction will also be deleted.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">No attractions found. Create your first attraction!</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $attractions->links() }}
        </div>
    </div>
</div>
@endsection
