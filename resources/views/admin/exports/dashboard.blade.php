@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Statistics Cards -->
            <div class="col-md-4">
                <div class="card bg-info text-white mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Today's Customers</h5>
                        <h2>{{ $todayCustomers }}</h2>
                        <div class="export-buttons mt-3">
                            <a href="{{ route('exports.pdf', 'customers') }}" class="btn btn-light btn-sm">PDF</a>
                            <a href="{{ route('exports.excel', 'customers') }}" class="btn btn-light btn-sm">Excel</a>
                            <a href="{{ route('exports.csv', 'customers') }}" class="btn btn-light btn-sm">CSV</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card bg-success text-white mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Today's Sales</h5>
                        <h2>₹{{ number_format($todaySales, 2) }}</h2>
                        <div class="export-buttons mt-3">
                            <a href="{{ route('exports.pdf', 'sales') }}" class="btn btn-light btn-sm">PDF</a>
                            <a href="{{ route('exports.excel', 'sales') }}" class="btn btn-light btn-sm">Excel</a>
                            <a href="{{ route('exports.csv', 'sales') }}" class="btn btn-light btn-sm">CSV</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card bg-info text-white mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Today's Payments</h5>
                        <h2>₹{{ number_format($todayPayments, 2) }}</h2>
                        <div class="export-buttons mt-3">
                            <a href="{{ route('exports.pdf', 'payments') }}" class="btn btn-light btn-sm">PDF</a>
                            <a href="{{ route('exports.excel', 'payments') }}" class="btn btn-light btn-sm">Excel</a>
                            <a href="{{ route('exports.csv', 'payments') }}" class="btn btn-light btn-sm">CSV</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Auto Report Settings -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Auto Report Settings</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="emailReports">
                                    <label class="form-check-label" for="emailReports">
                                        Send Daily Email Reports at 8:00 PM
                                    </label>
                                </div>
                                <button class="btn btn-primary btn-sm mt-2" onclick="sendTestEmail()">
                                    Send Test Email
                                </button>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="whatsappReports">
                                    <label class="form-check-label" for="whatsappReports">
                                        Send Daily WhatsApp Reports at 8:00 PM
                                    </label>
                                </div>
                                <button class="btn btn-success btn-sm mt-2" onclick="sendTestWhatsApp()">
                                    Send Test WhatsApp
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function sendTestEmail() {
            fetch("{{ route('exports.email', 'customers') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                });
        }

        function sendTestWhatsApp() {
            fetch("{{ route('exports.whatsapp', 'customers') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                });
        }
    </script>
@endsection