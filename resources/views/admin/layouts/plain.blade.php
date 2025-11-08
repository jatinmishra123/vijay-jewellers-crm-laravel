<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Payment')</title>

    <!-- Minimal CSS you need (Bootstrap + icons) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    @stack('head') {{-- optional for page-specific css --}}
    <style>
        body {
            background: #f4f6fb;
        }
    </style>
</head>

<body>
    <main class="d-flex justify-content-center align-items-center" style="min-height:100vh;">
        @yield('content')
    </main>

    <!-- Optional JS (Bootstrap, SweetAlert, confetti will be loaded by view if needed) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>