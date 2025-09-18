@extends('admin.layouts.app')

@section('title', 'Add Scheme - Admin Dashboard')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card shadow-sm">
                <div class="card-header  text-white">
                    <h4 class="card-title mb-0">Add New Scheme</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.schemes.store') }}" method="POST">
                        @csrf

                        <!-- Scheme Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Scheme Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="Enter the name..." value="{{ old('name') }}"
                                required>
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" class="form-control" id="description" placeholder="Enter the description..."
                                rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Duration -->
                        <div class="mb-3">
                            <label for="duration" class="form-label">Duration (Months) <span
                                    class="text-danger">*</span></label>
                            <input type="number" name="duration" class="form-control" id="duration"  placeholder="enter the duration Months..."
                                value="{{ old('duration') }}" min="1" required>
                            @error('duration')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Total Amount -->
                        <div class="mb-3">
                            <label for="total_amount" class="form-label">Total Amount <span
                                    class="text-danger">*</span></label>
                            <input type="number" name="total_amount" class="form-control" id="total_amount" placeholder="Enter the total amount..."
                                value="{{ old('total_amount') }}" step="0.01" min="0" required>
                            @error('total_amount')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('admin.schemes.index') }}" class="btn btn-secondary me-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">Add Scheme</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection