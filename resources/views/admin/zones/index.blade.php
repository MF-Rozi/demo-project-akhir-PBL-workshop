@extends('layouts.admin')

@section('title', 'Zones')
@section('page-title', 'Manage Zones')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>All Zones</h4>
    <a href="{{ route('admin.zones.create') }}" class="btn btn-primary">Add New Zone</a>
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
                        <th>Attractions</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($zones as $zone)
                        <tr>
                            <td>
                                @if($zone->image)
                                    <img src="{{ asset('storage/' . $zone->image) }}" alt="{{ $zone->name }}" 
                                         style="width: 60px; height: 60px; object-fit: cover;" class="rounded">
                                @else
                                    <div class="bg-secondary rounded" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                                        <small class="text-white">No Image</small>
                                    </div>
                                @endif
                            </td>
                            <td>{{ $zone->name }}</td>
                            <td>{{ Str::limit($zone->description, 80) }}</td>
                            <td>
                                <span class="badge bg-info">{{ $zone->attractions_count }}</span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.zones.edit', $zone) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('admin.zones.destroy', $zone) }}" method="POST" class="d-inline" 
                                          onsubmit="return confirm('Are you sure you want to delete this zone? All attractions in this zone will also be deleted.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">No zones found. Create your first zone!</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $zones->links() }}
        </div>
    </div>
</div>
@endsection
