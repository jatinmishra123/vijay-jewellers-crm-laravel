@extends('admin.layouts.app')

@section('title', 'Schemes - Admin Dashboard')

@section('content')
    <!-- Icons Css -->
    <link href="{{ asset('assets/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Schemes List</h4>
                    <a href="{{ route('admin.schemes.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-circle"></i> Add Scheme
                    </a>
                </div>
                <div class="card-body">
                    <!-- Search -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <form method="GET" action="{{ route('admin.schemes.index') }}" class="d-flex">
                                <input type="text" name="search" class="form-control me-2"
                                    placeholder="Search by scheme name..." value="{{ request('search') }}">
                                <button type="submit" class="btn btn-primary">Search</button>
                            </form>
                        </div>
                    </div>

                    <!-- Schemes Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Scheme Name</th>
                                    <th>Description</th>
                                    <th>Duration (Months)</th>
                                    <th>Total Amount</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($schemes as $key => $scheme)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $scheme->name }}</td>
                                        <td>
                                            {{ \Illuminate\Support\Str::words(strip_tags($scheme->description ?? 'N/A'), 20, '...') }}

                                            @if(strlen(strip_tags($scheme->description)) > 0)
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#schemeModal{{ $scheme->id }}">
                                                    View More
                                                </a>
                                            @endif
                                        </td>
                                        <!-- Scheme Description Modal -->
                                        <div class="modal fade" id="schemeModal{{ $scheme->id }}" tabindex="-1"
                                            aria-labelledby="schemeModalLabel{{ $scheme->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="schemeModalLabel{{ $scheme->id }}">
                                                            {{ $scheme->name }}
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>{{ strip_tags($scheme->description) }}</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <td>{{ $scheme->duration }}</td>
                                        <td>{{ number_format($scheme->total_amount, 2) }}</td>
                                        <td>{{ $scheme->created_at->format('M d, Y H:i') }}</td>
                                        <td>
                                            <div class="btn-group" role="group">

                                                <a href="{{ route('admin.schemes.edit', $scheme->id) }}"
                                                    class="btn btn-sm btn-outline-warning me-1">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('admin.schemes.destroy', $scheme->id) }}" method="POST"
                                                    class="d-inline delete-scheme-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-danger btn-delete-scheme">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No schemes found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($schemes->hasPages())
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="text-muted">
                                Showing {{ $schemes->firstItem() }} to {{ $schemes->lastItem() }} of {{ $schemes->total() }}
                                entries
                            </div>
                            <div class="pagination-container">
                                {{ $schemes->appends(request()->query())->links() }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Delete Scheme Confirmation
            const deleteButtons = document.querySelectorAll('.btn-delete-scheme');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const form = this.closest('.delete-scheme-form');

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "This scheme will be permanently deleted!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!',
                        reverseButtons: true,
                        focusCancel: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
@endpush