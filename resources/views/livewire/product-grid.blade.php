<div class="product-grid-container pt-1" onmousedown="handleMouseDownProduct(event)" onmouseup="handleMouseUpProduct(event)"
    onmouseleave="handleMouseUpProduct(event)" onmousemove="handleMouseMoveProduct(event)">
    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3" >
        <!-- Carte Produit -->
        @foreach ($products as $product)
        <div class="col">
            <div class="card product-card h-100" wire:click="addToCart({{ $product->id }})" style="cursor: pointer;">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <span class="badge btn-primary">{{ number_format($product->prix_ht, 2) }} DH</span>
                        <span class="badge bg-secondary">Stock : {{ $product->stock ?? 'N/A' }}</span>
                    </div>
                    <div class="text-center my-3">
                        <img src="{{ '/storage/' . ($product->image ?? 'products/placeholder.png') }}" class="img-fluid" style="height: 100px" alt="produit">
                    </div>
                    <h6 class="card-title mb-1">{{ $product->nom }}</h6>
                    <small class="text-muted">Code-barres : {{ $product->code_barre }}</small>
                </div>
            </div>
        </div>
    @endforeach

    </div>
    <div class="mt-3 mx-3">
        {{ $products->links() }}
    </div>
</div>
