@extends('admin.layouts.app')

@section('title', 'Edit Role - Vijay Jewellers')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">Edit Role</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.roles.index') }}">Roles</a></li>
                            <li class="breadcrumb-item active">Edit Role</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-lg-14 mx-auto">
                <div class="card shadow-sm">
                    <div class="card-header text-white bg-primary">
                        <h5 class="mb-0">Role Details</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.roles.update', $role->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Role Name (readonly) -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Role Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $role->name }}" readonly>
                            </div>

                            <!-- Permissions -->
                            <div class="mb-3">
                                <label class="form-label">Permissions</label>
                                <div class="row">
                                    @foreach($permissionOptions as $key => $label)
                                        <div class="col-md-6 mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" 
                                                    name="permissions[{{ $key }}]" 
                                                    value="true" 
                                                    id="perm-{{ $key }}"
                                                    {{ isset($role->permissions[$key]) && $role->permissions[$key] ? 'checked' : '' }}>
                                                <label class="form-check-label" for="perm-{{ $key }}">
                                                    {{ $label }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                @error('permissions')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-success">Update Role</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
