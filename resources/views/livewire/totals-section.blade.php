<div class="order-summary-container" style="overflow-y: auto; max-height: 400px;">
    <div class="row g-3 mb-3">
        <div class="col-md-8">
            <div class="input-group shadow-sm rounded-3 overflow-hidden">
                <select class="form-select border-end-0 bg-light" wire:model.live="discountType">
                    <option value="fixe">Remise Fixe</option>
                    <option value="percentage">Remise %</option>
                </select>
                <input type="number" step="any"
                       class="form-control border-start-0"
                       placeholder="Montant remise"
                       wire:model.live.debounce.500ms="discount"
                       aria-label="Discount amount">
                <span class="input-group-text bg-transparent">
                    @if($discountType == 'percentage') % @else DH @endif
                </span>
            </div>
        </div>

        <div class="col-md-4">
            <div class="input-group shadow-sm rounded-3 overflow-hidden">
                <span class="input-group-text bg-light">
                    <i class="bi bi-truck"></i>
                </span>
                <input type="number" step="any"
                       class="form-control"
                       placeholder="Frais livraison"
                       wire:model.live.debounce.500ms="shipping"
                       aria-label="Shipping cost">
                <span class="input-group-text bg-transparent">DH</span>
            </div>
        </div>
    </div>

    <div class="order-totals bg-light p-3 rounded-3 shadow-sm">
        <div class="row justify-content-end g-2">
            <div class="col-md-6">
                <div class="d-flex justify-content-between border-bottom pb-2 mb-2">
                    <span class="text-muted">Articles:</span>
                    <span class="fw-medium">{{ $totalQty }}</span>
                </div>
                <div class="d-flex justify-content-between border-bottom pb-2 mb-2">
                    <span class="text-muted">Sous-total:</span>
                    <span class="fw-medium">{{ number_format($subTotal, 2) }} DH</span>
                </div>
                @if($discount > 0)
                <div class="d-flex justify-content-between border-bottom pb-2 mb-2">
                    <span class="text-muted">
                        Remise
                        @if($discountType == 'percentage')
                            ({{ $discount }}%)
                        @endif:
                    </span>
                    <span class="text-danger fw-medium">
                        -{{ number_format($discountType == 'percentage' ? ($subTotal * $discount / 100) : $discount, 2) }} DH
                    </span>
                </div>
                @endif
                @if($shipping > 0)
                <div class="d-flex justify-content-between border-bottom pb-2 mb-2">
                    <span class="text-muted">Livraison:</span>
                    <span class="fw-medium">{{ number_format($shipping, 2) }} DH</span>
                </div>
                @endif
                <div class="d-flex justify-content-between pt-2">
                    <span class="text-dark fw-bold">Total:</span>
                    <span class="text-primary fw-bold fs-5">{{ number_format($total, 2) }} DH</span>
                </div>
            </div>
        </div>
    </div>

    <style>
        .order-summary-container {
            background-color: white;
            border-radius: 12px;
            padding: 1rem;
            overflow-y: auto; /* Ensure scrollbar appears when needed */
            max-height: 400px; /* Fixed height to enable scrolling */
            scrollbar-width: thin; /* For Firefox */
        }

        /* Custom scrollbar for Webkit browsers */
        .order-summary-container::-webkit-scrollbar {
            width: 6px;
        }

        .order-summary-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .order-summary-container::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }

        .order-summary-container::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        .order-totals {
            border: 1px solid rgba(0,0,0,0.05);
        }

        .form-select, .form-control {
            transition: all 0.2s ease;
        }

        .form-select:focus, .form-control:focus {
            border-color: #2A4E6C;
            box-shadow: 0 0 0 0.25rem rgba(42, 78, 108, 0.15);
        }

        .input-group-text {
            color: #6c757d;
        }
    </style>
</div>
