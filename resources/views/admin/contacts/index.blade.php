@extends('admin.layouts.app')

@section('title', 'Customer Contacts')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Customer Contacts</h4>
                </div>

                <div class="card-body">
                    <form method="GET" class="mb-3">
                        <div class="input-group w-50">
                            <input type="text" name="search" class="form-control" placeholder="Search name or mobile..."
                                value="{{ request('search') }}">
                            <button class="btn btn-primary" type="submit">Search</button>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead>
                                <tr class="text-center">
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Contact</th>
                                    <th>Conversation</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($customers as $i => $customer)
                                    <tr>
                                        <td class="text-center">{{ $customers->firstItem() + $i }}</td>
                                        <td>{{ $customer->name }}</td>
                                        <td>{{ $customer->email }}</td>
                                        <td>{{ $customer->mobile }}</td>
                                        <td class="text-center">
                                            <a href="tel:{{ $customer->mobile }}" class="btn btn-sm btn-outline-success"
                                                title="Call"><i class="bi bi-telephone-fill"></i></a>
                                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $customer->mobile) }}"
                                                target="_blank" class="btn btn-sm btn-outline-success" title="WhatsApp"><i
                                                    class="bi bi-whatsapp"></i></a>
                                        </td>
                                        <td>
                                            <!-- Conversation Button to trigger modal -->
                                            <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal"
                                                data-bs-target="#convModal{{ $customer->id }}">
                                                <i class="bi bi-chat-dots"></i> Conversation
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="convModal{{ $customer->id }}" tabindex="-1"
                                                aria-labelledby="convModalLabel{{ $customer->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="convModalLabel{{ $customer->id }}">
                                                                Conversation — {{ $customer->name }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <!-- flash message -->
                                                            @if(session('success'))
                                                                <div class="alert alert-success">{{ session('success') }}</div>
                                                            @endif

                                                            <!-- History -->
                                                            <h6>History</h6>
                                                            <div class="border rounded p-2 mb-3"
                                                                style="max-height:300px; overflow-y:auto;">
                                                                @if($customer->conversations && $customer->conversations->count())
                                                                    @foreach($customer->conversations as $conv)
                                                                        <div class="mb-2">
                                                                            <small
                                                                                class="text-muted">{{ $conv->created_at->format('d M Y, h:i A') }}</small>
                                                                            <div class="mt-1">{{ $conv->message }}</div>

                                                                            <!-- optional delete single conversation -->
                                                                            <form method="POST"
                                                                                action="{{ route('admin.contacts.deleteConversation', $conv->id) }}"
                                                                                onsubmit="return confirm('Delete this message?')"
                                                                                class="d-inline-block mt-1">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <button
                                                                                    class="btn btn-sm btn-outline-danger">Delete</button>
                                                                            </form>
                                                                        </div>
                                                                        <hr class="my-2">
                                                                    @endforeach
                                                                @else
                                                                    <p class="text-muted mb-0">No conversations yet.</p>
                                                                @endif
                                                            </div>

                                                            <!-- Add new message -->
                                                            <form method="POST"
                                                                action="{{ route('admin.contacts.saveConversation', $customer->id) }}">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="input-group">
                                                                    <input type="text" name="message" class="form-control"
                                                                        placeholder="Enter conversation details..." required>
                                                                    <button class="btn btn-primary" type="submit"><i
                                                                            class="bi bi-send-fill"></i> Save</button>
                                                                </div>
                                                            </form>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end modal -->
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">No customers found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $customers->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ✅ Bootstrap Icons CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

@endsection