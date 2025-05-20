<div>
    <div class="client-depot-selector mb-4">
        <div class="row g-3">
            <!-- Client Selection -->
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text bg-primary text-white">
                        <i class="bi bi-person-fill"></i>
                    </span>
                    <select class="form-select shadow-sm" wire:model="client" wire:change="handleClient()">
                        <option value="" class="text-muted">Sélectionner un client</option>
                        @foreach ($clients as $client)
                            <option value="{{ $client->id }}" class="text-dark">
                                {{ $client->name }}
                                @if($client->phone)
                                    ({{ $client->phone }})
                                @endif
                            </option>
                        @endforeach
                    </select>
                    <button class="btn btn-outline-primary" type="button" wire:click="clearClient()" title="Clear selection">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
            </div>

            <!-- Depot Selection (Disabled) -->
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text bg-secondary text-white">
                        <i class="bi bi-shop"></i>
                    </span>
                    <select class="form-select shadow-sm" disabled>
                        <option class="text-muted">Dépôt (bientôt disponible)</option>
                    </select>
                    <button class="btn btn-outline-secondary" type="button" disabled title="Coming soon">
                        <i class="bi bi-info-circle"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Selected Client Info (conditional) -->
        @if(!empty($client))
            @php
                $currentClient = collect($clients)->firstWhere('id', $client);
            @endphp
            @if($currentClient)
            <div class="client-info mt-3 p-3 bg-light rounded-3 animate__animated animate__fadeIn">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-1 fw-bold">{{ $currentClient['name'] }}</h6>
                        @if(!empty($currentClient['phone']))
                        <p class="mb-1 small"><i class="bi bi-telephone me-2"></i>{{ $currentClient['phone'] }}</p>
                        @endif
                        @if(!empty($currentClient['address']))
                        <p class="mb-0 small"><i class="bi bi-geo-alt me-2"></i>{{ $currentClient['address'] }}</p>
                        @endif
                    </div>
                    <button class="btn btn-sm btn-outline-danger" wire:click="clearClient()">
                        <i class="bi bi-trash"></i> Supprimer
                    </button>
                </div>
            </div>
            @endif
        @endif
    </div>

    <style>
        .client-depot-selector {
            transition: all 0.3s ease;
        }

        .form-select {
            border-radius: 0.375rem !important;
            border-left: none !important;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .form-select:focus {
            border-color: #6a1e96;
            box-shadow: 0 0 0 0.25rem rgba(106, 30, 150, 0.25);
        }

        .input-group-text {
            border-radius: 0.375rem 0 0 0.375rem !important;
            border-right: none;
        }

        .client-info {
            border-left: 3px solid #6a1e96;
            transition: all 0.3s ease;
        }

        .client-info:hover {
            background-color: #f8f9fa !important;
            transform: translateY(-1px);
        }

        @media (max-width: 768px) {
            .input-group-text {
                padding: 0.5rem;
            }

            .form-select, .btn {
                padding: 0.5rem;
            }
        }
    </style>
</div>
