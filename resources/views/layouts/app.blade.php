<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'POS') }}</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Livewire Styles -->
    @livewireStyles

    <!-- Custom Styles -->
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .pos-container {
            display: flex;
            height: 100vh;
            overflow: hidden;
        }
        .left-panel, .right-panel {
            height: 100%;
            overflow-y: auto;
        }
        .left-panel {
            width: 40%;
            background-color: #fff;
            border-right: 1px solid #ddd;
            display: flex;
            flex-direction: column;
        }
        .right-panel {
            width: 60%;
            background-color: #f5f5f5;
            padding: 1rem;
        }
        .splitter {
            width: 5px;
            cursor: col-resize;
            background-color: #ddd;
        }
    </style>

    @stack('styles')
</head>
<body>

    @yield('content')

    <!-- Livewire Scripts -->
    @livewireScripts

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>
</html>
