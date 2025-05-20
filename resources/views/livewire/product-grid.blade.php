<div>
    <div class="product-grid-container pt-1"
         onmousedown="handleMouseDownProduct(event)"
         onmouseup="handleMouseUpProduct(event)"
         onmouseleave="handleMouseUpProduct(event)"
         onmousemove="handleMouseMoveProduct(event)">

        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 g-3">
            @foreach ($products as $product)
            <div class="col">
                <div class="card product-card h-100 shadow-sm border-0 position-relative overflow-hidden"
                     wire:click="addToCart({{ $product->id }})"
                     style="cursor: pointer; transition: all 0.3s ease;">

                    <!-- Product Labels -->
                    @if($product->stock <= 0)
                    <div class="position-absolute top-0 start-0 w-100 text-center bg-danger text-white py-1 small">
                        RUPTURE DE STOCK
                    </div>
                    @elseif($product->is_promo)
                    <div class="position-absolute top-0 start-0 w-100 text-center bg-success text-white py-1 small">
                        PROMOTION
                    </div>
                    @endif

                    <div class="card-body p-3 d-flex flex-column">
                        <!-- Price & Stock -->
                        <div class="d-flex justify-content-between mb-2">
                            <span class="badge bg-primary rounded-pill fs-6">
                                {{ number_format($product->prix_ht, 2) }} DH
                            </span>
                            <span class="badge bg-dark bg-opacity-10 text-dark rounded-pill">
                                <i class="bi bi-box-seam me-1"></i>{{ $product->stock ?? 'N/A' }}
                            </span>
                        </div>

                        <!-- Product Image -->
                        <div class="text-center my-2 flex-grow-1 d-flex align-items-center justify-content-center">
                            <img src="{{ '/storage/' . ($product->image ?? 'products/placeholder.png') }}"
                                 class="img-fluid product-image"
                                 style="max-height: 120px; width: auto;"
                                 alt="{{ $product->nom }}"
                                 onerror="this.src='/storage/products/placeholder.png'">
                        </div>

                        <!-- Product Info -->
                        <div class="mt-auto">
                            <h6 class="card-title mb-1 fw-bold text-truncate">{{ $product->nom }}</h6>
                            <small class="text-muted d-block text-truncate">
                                <i class="bi bi-upc-scan me-1"></i>{{ $product->code_barre }}
                            </small>
                            @if($product->categorie)
                            <small class="d-block text-primary mt-1">
                                <i class="bi bi-tag-fill me-1"></i>{{ $product->categorie->nom }}
                            </small>
                            @endif
                        </div>
                    </div>

                    <!-- Hover Overlay -->
                    <div class="product-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center">
                        <span class="badge bg-white text-primary px-3 py-2 rounded-pill shadow">
                            <i class="bi bi-plus-circle-fill me-1"></i> Ajouter au panier
                        </span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-4 mx-3 d-flex justify-content-center">
            {{ $products->links('pagination::bootstrap-5') }}
        </div>
    </div>

    <style>
        .product-card {
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        .product-image {
            transition: transform 0.3s ease;
        }

        .product-card:hover .product-image {
            transform: scale(1.05);
        }

        .product-overlay {
            background: rgba(42, 78, 108, 0.9);
            opacity: 0;
            transition: opacity 0.3s ease;
            color: white;
        }

        .product-card:hover .product-overlay {
            opacity: 1;
        }

        .card-title {
            min-height: 2.4em;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Custom pagination styling */
        .pagination .page-item.active .page-link {
            background-color: #2A4E6C;
            border-color: #2A4E6C;
        }

        .pagination .page-link {
            color: #2A4E6C;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .product-card {
                border-radius: 8px;
            }

            .badge {
                font-size: 0.75rem !important;
            }
        }
    </style>

    <script>
        // Enhanced drag-scroll functionality for product grid
        let isMouseDownProduct = false;
        let startXProduct, scrollLeftProduct;

        function handleMouseDownProduct(e) {
            const slider = e.currentTarget;
            if (slider.scrollWidth > slider.clientWidth) {
                isMouseDownProduct = true;
                slider.style.cursor = 'grabbing';
                startXProduct = e.pageX - slider.offsetLeft;
                scrollLeftProduct = slider.scrollLeft;
                e.preventDefault();
            }
        }

        function handleMouseUpProduct(e) {
            isMouseDownProduct = false;
            e.currentTarget.style.cursor = 'default';
        }

        function handleMouseMoveProduct(e) {
            if(!isMouseDownProduct) return;
            const slider = e.currentTarget;
            const x = e.pageX - slider.offsetLeft;
            const walk = (x - startXProduct) * 2;
            slider.scrollLeft = scrollLeftProduct - walk;
        }
    </script>
</div>
