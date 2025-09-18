@extends('admin.layouts.app')

@section('title', 'Edit Scheme - Admin Dashboard')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Edit Scheme</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.schemes.update', $scheme->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Scheme Name</label>
                            <input type="text" name="name" class="form-control" id="name"
                                value="{{ old('name', $scheme->name) }}" required>
                            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" class="form-control" id="description"
                                rows="3">{{ old('description', $scheme->description) }}</textarea>
                            @error('description') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="duration" class="form-label">Duration (Months)</label>
                            <input type="number" name="duration" class="form-control" id="duration"
                                value="{{ old('duration', $scheme->duration) }}" min="1" required>
                            @error('duration') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="total_amount" class="form-label">Total Amount</label>
                            <input type="number" name="total_amount" class="form-control" id="total_amount"
                                value="{{ old('total_amount', $scheme->total_amount) }}" step="0.01" min="0" required>
                            @error('total_amount') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Update Scheme</button>
                            <a href="{{ route('admin.schemes.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection