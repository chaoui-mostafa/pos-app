<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    {{-- @livewireStyles() --}}
    <title>Commandes</title>
</head>

<body class="bg-light">
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <!-- Header Section -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h1 class="display-5 fw-bold text-primary mb-1">
                            <i class="bi bi-receipt me-2"></i>Historique des Commandes
                        </h1>
                        <p class="text-muted">Consultez l'historique complet des transactions</p>
                    </div>
                    <a href="{{ route('home') }}" wire:navigate class="btn btn-primary btn-lg rounded-pill shadow-sm">
                        <i class="bi bi-arrow-left me-2"></i> Retour au POS
                    </a>
                </div>

                <!-- Stats Cards -->
                <div class="row mb-4">
                    <div class="col-md-4 mb-3">
                        <div class="card bg-white border-0 shadow-sm rounded-3 h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="text-uppercase text-muted mb-2">Commandes Total</h6>
                                        <h3 class="mb-0">1,248</h3>
                                    </div>
                                    <div class="bg-primary bg-opacity-10 p-3 rounded">
                                        <i class="bi bi-cart-check text-primary fs-4"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card bg-white border-0 shadow-sm rounded-3 h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="text-uppercase text-muted mb-2">Revenue Total</h6>
                                        <h3 class="mb-0">$24,780</h3>
                                    </div>
                                    <div class="bg-success bg-opacity-10 p-3 rounded">
                                        <i class="bi bi-currency-dollar text-success fs-4"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card bg-white border-0 shadow-sm rounded-3 h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="text-uppercase text-muted mb-2">Moyenne/Commande</h6>
                                        <h3 class="mb-0">$19.86</h3>
                                    </div>
                                    <div class="bg-info bg-opacity-10 p-3 rounded">
                                        <i class="bi bi-graph-up text-info fs-4"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="card border-0 shadow-sm rounded-3 overflow-hidden animate__animated animate__fadeIn">
                    <div class="card-header bg-white py-3 border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Liste des Commandes</h5>
                            <div class="input-group w-25">
                                <span class="input-group-text bg-transparent border-end-0">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input type="text" class="form-control border-start-0" placeholder="Rechercher...">
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        @livewire('commandes')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        :root {
            --primary-hover: #0b5ed7;
            --card-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            --card-shadow-hover: 0 10px 15px rgba(0, 0, 0, 0.1);
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8fafc;
        }

        .card {
            border: none;
            border-radius: 10px;
            transition: all 0.3s ease;
            box-shadow: var(--card-shadow);
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: var(--card-shadow-hover);
        }

        .btn-primary {
            background-color: #0d6efd;
            border-color: #0d6efd;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
            border-color: var(--primary-hover);
            transform: translateY(-1px);
        }

        .table-hover tbody tr:hover {
            background-color: rgba(13, 110, 253, 0.05);
        }

        .rounded-3 {
            border-radius: 12px !important;
        }

        .input-group-text {
            background-color: transparent;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #ced4da;
        }

        .badge {
            padding: 6px 10px;
            font-weight: 500;
        }

        .badge.bg-success {
            background-color: #198754 !important;
        }

        .badge.bg-warning {
            background-color: #ffc107 !important;
            color: #000;
        }
    </style>

    <script data-navigate-once src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    {{-- @livewireScripts() --}}
</body>

</html>
