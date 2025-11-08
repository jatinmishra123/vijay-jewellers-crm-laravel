@extends('admin.layouts.app')

@section('title', 'Redirecting...')

@section('content')
    <div class="d-flex flex-column justify-content-center align-items-center" style="height: 70vh;">
        <h4 class="mb-3 text-primary">Redirecting to Payment Gateway...</h4>
        <p class="text-muted">Please wait, do not refresh or close this page.</p>

        <div class="spinner-border text-primary mt-4" role="status" style="width: 3rem; height: 3rem;">
            <span class="visually-hidden">Loading...</span>
        </div>

        <form id="payphiForm" action="{{ $payload['gatewayUrl'] ?? '' }}" method="POST" class="d-none">
            @foreach($payload as $k => $v)
                <input type="hidden" name="{{ $k }}" value="{{ $v }}">
            @endforeach
        </form>
    </div>

    <script>
        // Auto-submit form after short delay
        setTimeout(() => {
            document.getElementById('payphiForm').submit();
        }, 1500);
    </script>
@endsection