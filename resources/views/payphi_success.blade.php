@extends('admin.layouts.plain')

@section('title', 'Payment Successful')

@section('content')
    <div class="container py-5 text-center">
        <div class="d-flex flex-column justify-content-center align-items-center" style="min-height: 70vh;">
            <div class="card shadow-lg p-5 border-0" style="max-width: 600px; background: #f9fbff;">
                <div class="text-center mb-4">
                    <div
                        style="width: 80px; height: 80px; background-color: #28a745; border-radius: 50%; display: flex; justify-content: center; align-items: center; margin: 0 auto;">
                        <i class="bi bi-check-lg text-white" style="font-size: 40px;"></i>
                    </div>
                    <h2 class="text-success mt-3">Payment Successful 🎉</h2>
                    <p class="text-muted">Thank you for your payment!</p>
                </div>

                <div class="text-start mx-auto" style="max-width: 400px;">
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>Transaction No:</strong></td>
                            <td>{{ $data['merchantTxnNo'] ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Amount:</strong></td>
                            <td>₹{{ $data['amount'] ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Status:</strong></td>
                            <td>{{ strtoupper($data['status'] ?? 'SUCCESS') }}</td>
                        </tr>
                    </table>
                </div>

                <div class="mt-4">
                    <p class="text-muted">You will be redirected to your dashboard shortly.</p>
                    <a href="{{ url('/admin/dashboard') }}" class="btn btn-success px-4 py-2">Go to Dashboard</a>
                </div>
            </div>
        </div>
    </div>

    {{-- SweetAlert2 Popup --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- Confetti animation --}}
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // 🎉 SweetAlert Popup
            Swal.fire({
                title: '🎉 Payment Successful!',
                html: `
                                    <strong>Txn No:</strong> {{ $data['merchantTxnNo'] ?? 'N/A' }} <br>
                                    <strong>Amount:</strong> ₹{{ $data['amount'] ?? 'N/A' }} <br><br>
                                    Thank you for your payment! You’ll be redirected to your dashboard shortly.
                                `,
                icon: 'success',
                confirmButtonText: 'Go Now',
                confirmButtonColor: '#28a745',
                timer: 5000,
                timerProgressBar: true
            }).then((result) => {
                window.location.href = "{{ url('/admin/dashboard') }}";
            });

            // 🎊 Confetti celebration effect
            const duration = 2 * 1000;
            const animationEnd = Date.now() + duration;
            const defaults = { startVelocity: 30, spread: 360, ticks: 60, zIndex: 1000 };

            function randomInRange(min, max) {
                return Math.random() * (max - min) + min;
            }

            const interval = setInterval(() => {
                const timeLeft = animationEnd - Date.now();

                if (timeLeft <= 0) {
                    return clearInterval(interval);
                }

                const particleCount = 50 * (timeLeft / duration);
                confetti(Object.assign({}, defaults, {
                    particleCount,
                    origin: { x: randomInRange(0.1, 0.3), y: Math.random() - 0.2 }
                }));
                confetti(Object.assign({}, defaults, {
                    particleCount,
                    origin: { x: randomInRange(0.7, 0.9), y: Math.random() - 0.2 }
                }));
            }, 250);
        });
    </script>
@endsection