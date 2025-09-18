@extends('admin.layouts.app')

@section('title', 'Role Management - Vijay Jewellers')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

@section('content')
    <div class="container-fluid">
        <!-- Page title -->
        <div class="row mb-3">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between py-2">
                    <h4 class="mb-0 fs-5">Role Management</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="small">Home</a></li>
                            <li class="breadcrumb-item active small">Role Management</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header  text-white p-3">
                        <h5 class="mb-0 fs-">Roles List</h5>
                    </div>
                    <div class="card-body p-3">
                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-between align-items-right mb-3">
                            <a href="{{ route('admin.roles.create') }}" class="btn btn-primary btn-sm small">
                                <i class="bi bi-plus-circle me-1 fs-6"></i> Add New Role
                            </a>

                        </div>

                        <!-- Success/Error Messages -->
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show py-2" role="alert">
                                <small>{{ session('success') }}</small>
                                <button type="button" class="btn-close p-2" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show py-2" role="alert">
                                <small>{{ session('error') }}</small>
                                <button type="button" class="btn-close p-2" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <!-- Roles Table -->
                        <div class="table-responsive">
                            <table class="table table-sm table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th class="small">#</th>
                                        <th class="small">Role Name</th>
                                        <th class="small">Permissions</th>
                                        <th class="small text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($roles as $index => $role)
                                        <tr>
                                            <td class="small">{{ $index + 1 }}</td>
                                            <td class="small fw-semibold">{{ $role->name }}</td>
                                            <td>
                                                @if(isset($role->permissions) && is_array($role->permissions))
                                                    <div class="d-flex flex-wrap gap-1">
                                                        @foreach($role->permissions as $key => $value)
                                                            @if($value === true)
                                                                <span class="badge bg-info text-dark small">{{ $key }}</span>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <span class="text-muted small">No permissions</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.roles.edit', $role->id) }}"
                                                    class="btn btn-sm btn-outline-warning mb-2">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                                        onclick="return confirm('Are you sure you want to delete this role?')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .card {
            border-radius: 8px;
        }

        .table {
            font-size: 0.875rem;
        }

        .table th,
        .table td {
            padding: 0.5rem;
            vertical-align: middle;
        }

        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }

        .badge {
            font-size: 0.75rem;
            padding: 0.35em 0.65em;
        }

        .alert {
            font-size: 0.875rem;
            margin-bottom: 1rem;
        }

        .breadcrumb {
            font-size: 0.875rem;
            margin-bottom: 0;
        }

        .card-header {
            padding: 0.75rem 1rem;
        }

        .card-body {
            padding: 1rem;
        }
    </style>
@endpush