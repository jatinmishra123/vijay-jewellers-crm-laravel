@extends('admin.layouts.app')

@section('title', 'View Role - Vijay Jewellers')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">View Role: {{ $role->name }}</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.roles.index') }}">Roles</a></li>
                            <li class="breadcrumb-item active">View Role</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">Role Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <strong>Role Name:</strong>
                                    <p class="text-muted">{{ $role->name }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <strong>Created At:</strong>
                                    <p class="text-muted">{{ $role->created_at->format('d M Y, h:i A') }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <strong>Permissions:</strong>
                            <div class="mt-2">
                                @if(isset($role->permissions) && is_array($role->permissions))
                                    @foreach($role->permissions as $key => $value)
                                        @if($value === true)
                                            <span class="badge bg-info mb-1">{{ $key }}</span>
                                        @endif
                                    @endforeach
                                @else
                                    <p class="text-muted">No permissions assigned</p>
                                @endif
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.roles.edit', $role->id) }}" class="btn btn-warning">
                                <i class="bi bi-pencil"></i> Edit Role
                            </a>
                            <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Back to List
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection