@extends('layouts.admin')

@section('title', 'Edit Zone')
@section('page-title', 'Edit Zone')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Zone Information</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.zones.update', $zone) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">Zone Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', $zone->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="5" required>{{ old('description', $zone->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    @if($zone->image)
                        <div class="mb-3">
                            <label class="form-label">Current Image</label>
                            <div>
                                <img src="{{ asset('storage/' . $zone->image) }}" alt="{{ $zone->name }}" 
                                     style="max-width: 200px; height: auto;" class="rounded">
                            </div>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label for="image" class="form-label">{{ $zone->image ? 'Change Image' : 'Zone Image' }}</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" 
                               id="image" name="image" accept="image/*">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Max file size: 2MB. Supported formats: JPEG, PNG, JPG, GIF</small>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.zones.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update Zone</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
