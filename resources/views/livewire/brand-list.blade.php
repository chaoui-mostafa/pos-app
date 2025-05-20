<div>
    <div class="brand-filter-container mb-3">
        <div class="position-relative">
            <!-- Scrollable brand buttons with gradient overlay -->
            <div class="d-flex gap-2 overflow-x-auto pb-3 drag-scroll custom-scroll"
                style="scrollbar-width: none; -ms-overflow-style: none;"
                onmousedown="handleBrandMouseDown(event)"
                onmouseup="handleBrandMouseUp(event)"
                onmouseleave="handleBrandMouseUp(event)"
                onmousemove="handleBrandMouseMove(event)">

                <!-- All brands button -->
                <button class="btn btn-{{ !$selectedBrand ? 'primary' : 'outline-secondary' }} btn-brand flex-shrink-0 rounded-pill"
                    wire:click="filterByBrand(null)">
                    <i class="bi bi-grid-fill me-1"></i> Toutes
                </button>

                <!-- Brand buttons -->
                @foreach ($brands as $brand)
                    <button class="btn btn-{{ $selectedBrand == $brand->id ? 'primary' : 'outline-secondary' }} btn-brand flex-shrink-0 rounded-pill d-flex align-items-center"
                        wire:click="filterByBrand({{ $brand->id }})">
                        @if($brand->logo)
                            <img src="{{ asset($brand->logo) }}" alt="{{ $brand->marque }}" class="me-2 brand-logo">
                        @endif
                        {{ $brand->marque }}
                    </button>
                @endforeach
            </div>

            <!-- Gradient overlay indicators -->
            <div class="fade-overlay start-0"></div>
            <div class="fade-overlay end-0"></div>
        </div>
    </div>

    <style>
        .brand-filter-container {
            position: relative;
            padding: 0.5rem 0;
        }

        .btn-brand {
            padding: 0.5rem 1rem;
            min-width: 120px;
            transition: all 0.2s ease;
            white-space: nowrap;
            border-width: 2px;
        }

        .brand-logo {
            width: 20px;
            height: 20px;
            object-fit: contain;
        }

        /* Fade overlay effect */
        .fade-overlay {
            position: absolute;
            top: 0;
            bottom: 0;
            width: 40px;
            pointer-events: none;
            background: linear-gradient(90deg, rgba(255,255,255,0) 0%, rgba(255,255,255,1) 100%);
        }

        .fade-overlay.start-0 {
            left: 0;
            background: linear-gradient(90deg, rgba(255,255,255,1) 0%, rgba(255,255,255,0) 100%);
        }

        /* Custom scrollbar styling */
        .custom-scroll::-webkit-scrollbar {
            height: 4px;
            background-color: transparent;
        }

        .custom-scroll::-webkit-scrollbar-thumb {
            background-color: rgba(0,0,0,0.1);
            border-radius: 4px;
        }

        /* Dragging state */
        .drag-scroll.grabbing {
            cursor: grabbing;
            user-select: none;
        }
    </style>

    <script>
        // Brand filter specific drag-scroll functionality
        let isBrandDragging = false;
        let brandStartX, brandScrollLeft;

        function handleBrandMouseDown(e) {
            isBrandDragging = true;
            const slider = e.currentTarget;
            slider.classList.add('grabbing');
            brandStartX = e.pageX - slider.offsetLeft;
            brandScrollLeft = slider.scrollLeft;
        }

        function handleBrandMouseUp(e) {
            isBrandDragging = false;
            const slider = e.currentTarget;
            slider.classList.remove('grabbing');
        }

        function handleBrandMouseMove(e) {
            if(!isBrandDragging) return;
            const slider = e.currentTarget;
            const x = e.pageX - slider.offsetLeft;
            const walk = (x - brandStartX) * 2; // Scroll speed multiplier
            slider.scrollLeft = brandScrollLeft - walk;
        }
    </script>
</div>
