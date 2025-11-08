@extends('admin.layouts.plain')

@section('title', 'Payment Failed')

@section('content')
    <div class="container py-5 text-center">
        <h2 class="text-danger mb-3">❌ Payment Failed</h2>
        <p>{{ $error ?? 'Something went wrong during the transaction.' }}</p>

        <div class="card mx-auto shadow p-3 mt-4" style="max-width: 500px;">
            <h5 class="text-start">Transaction Details:</h5>
            <hr>
            <p><strong>Transaction No:</strong> {{ $data['merchantTxnNo'] ?? 'N/A' }}</p>
            <p><strong>Amount:</strong> ₹{{ $data['amount'] ?? 'N/A' }}</p>
            <p><strong>Status:</strong> {{ strtoupper($data['status'] ?? 'FAILED') }}</p>
        </div>

        <a href="{{ url('/payphi/checkout') }}" class="btn btn-danger mt-4">Try Again</a>
    </div>

    {{-- SweetAlert Popup --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                title: '❌ Payment Failed',
                html: `
                                {{ $error ?? 'Your payment could not be processed.' }}<br><br>
                                <strong>Txn No:</strong> {{ $data['merchantTxnNo'] ?? 'N/A' }}<br>
                                <strong>Amount:</strong> ₹{{ $data['amount'] ?? 'N/A' }}
                            `,
                icon: 'error',
                confirmButtonText: 'Try Again',
                confirmButtonColor: '#d33',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ url('/payphi/checkout') }}";
                }
            });
        });
    </script>
@endsection