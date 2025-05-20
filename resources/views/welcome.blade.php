@extends('layouts.app') {{-- or your custom layout --}}

@section('content')
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>POS System</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        @livewireStyles
          <style>
        :root {
            --primary: #6a1e96;
            --primary-hover: #e3d1ee;
            --primary-text-color: #ffffff;
            --primary-text-hover-color: #44016b;
            --primary-border-color: #290041;
            --primary-outline: #c390e0;
            --left-panel-width: 30%;
            --splitter-width: 8px;
            --header-height: 180px;
        }

        body {
            overflow-x: hidden;
            height: 100vh;
            margin: 0;
        }

        .pos-container {
            height: 100vh;
            width: 100vw;
            overflow: hidden;
            display: flex;
        }

        .left-panel {
            background: #f8f9fa;
            border-right: 2px solid #dee2e6;
            height: 100%;
            width: var(--left-panel-width);
            min-width: 300px;
            max-width: 50%;
            display: flex;
            flex-direction: column;
            position: relative;
        }

        .right-panel {
            flex: 1;
            height: 100%;
            min-width: 50%;
            display: flex;
            flex-direction: column;
        }

        .panel-content {
            padding: 1rem;
        }

        /* Splitter handle */
        .splitter {
            width: var(--splitter-width);
            height: 100%;
            background-color: #ddd;
            cursor: col-resize;
            position: absolute;
            right: 0;
            top: 0;
            z-index: 100;
            transition: background-color 0.2s;
        }

        .splitter:hover, .splitter.active {
            background-color: var(--primary);
        }

        /* Right panel layout */
        .right-panel-header {
            height: var(--header-height);
            overflow-y: auto;
            flex-shrink: 0;
        }

        .product-grid-container {
            flex: 1;
            overflow: auto;
            min-height: 0; /* Fix for Firefox */
        }

        /* Custom scrollbars */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb {
            background: #c0c0c0;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #a0a0a0;
        }

        /* Product grid styling */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 1rem;
            padding: 1rem 0;
        }

        .product-card {
            cursor: pointer;
            transition: all 0.2s ease;
            border: 1px solid #eee;
            border-radius: 8px;
            overflow: hidden;
        }

        .product-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        /* Responsive adjustments */
        @media (max-width: 992px) {
            :root {
                --left-panel-width: 40%;
                --header-height: 220px;
            }

            .product-grid {
                grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            }
        }

        @media (max-width: 768px) {
            .pos-container {
                flex-direction: column;
            }

            .left-panel, .right-panel {
                width: 100% !important;
                max-width: 100%;
                min-width: 100%;
                height: 50%;
            }

            .splitter {
                width: 100%;
                height: 8px;
                top: auto;
                bottom: 0;
                cursor: row-resize;
            }

            .right-panel-header {
                height: auto;
                max-height: 40%;
            }

            .product-grid {
                grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            }
        }
    </style>
    </head>

    <body>


        <div class="pos-container">
            <!-- Left Panel -->
            <div class="left-panel" id="leftPanel">
                <div class="panel-content">
                    <div class="scrollable-section">
                        @livewire('client-warehouse-selector')
                        @livewire('product-cart')
                    </div>
                    <div class="totals-section">
                        @livewire('totals-section')
                        @livewire('cart-actions')
                    </div>
                </div>
                <div class="splitter" id="splitter"></div>
            </div>

            <!-- Right Panel -->
            <div class="right-panel">
                <div class="right-panel-header panel-content">
                    @livewire('product-search-and-buttons')
                    @livewire('category-list')
                    @livewire('brand-list')
                </div>
                <div class="product-grid-container panel-content">
                    @livewire('product-grid')
                </div>
            </div>
        </div>

        @livewireScripts

        <!-- Resize & drag scroll scripts -->
           <script>
        // Panel resizing functionality
        document.addEventListener('DOMContentLoaded', function() {
            const splitter = document.getElementById('splitter');
            const leftPanel = document.getElementById('leftPanel');
            const posContainer = document.querySelector('.pos-container');
            let isDragging = false;
            let startPosition = 0;
            let startWidth = 0;

            splitter.addEventListener('mousedown', function(e) {
                isDragging = true;
                splitter.classList.add('active');

                if (window.innerWidth > 768) {
                    // Horizontal resize
                    document.body.style.cursor = 'col-resize';
                    startPosition = e.clientX;
                    startWidth = leftPanel.offsetWidth;
                } else {
                    // Vertical resize
                    document.body.style.cursor = 'row-resize';
                    startPosition = e.clientY;
                    startWidth = leftPanel.offsetHeight;
                }

                document.addEventListener('mousemove', handleDrag);
                document.addEventListener('mouseup', stopDrag);
                e.preventDefault();
            });

            function handleDrag(e) {
                if (!isDragging) return;

                if (window.innerWidth > 768) {
                    // Horizontal resize
                    const containerWidth = posContainer.offsetWidth;
                    const newWidth = startWidth + (e.clientX - startPosition);
                    const minWidth = 300;
                    const maxWidth = containerWidth * 0.5;

                    if (newWidth >= minWidth && newWidth <= maxWidth) {
                        leftPanel.style.width = `${newWidth}px`;
                    }
                } else {
                    // Vertical resize
                    const containerHeight = posContainer.offsetHeight;
                    const newHeight = startWidth + (e.clientY - startPosition);
                    const minHeight = 200;
                    const maxHeight = containerHeight - 200;

                    if (newHeight >= minHeight && newHeight <= maxHeight) {
                        leftPanel.style.height = `${newHeight}px`;
                    }
                }
            }

            function stopDrag() {
                isDragging = false;
                splitter.classList.remove('active');
                document.body.style.cursor = '';
                document.removeEventListener('mousemove', handleDrag);
                document.removeEventListener('mouseup', stopDrag);
            }

            // Initialize drag-to-scroll for product grids
            initializeDragScroll('.scrollable-section');
            initializeDragScroll('.product-grid-container');

            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth <= 768) {
                    leftPanel.style.width = '100%';
                    leftPanel.style.height = '50%';
                } else {
                    leftPanel.style.height = '100%';
                }
            });

            // SweetAlert notifications
            window.addEventListener('cartUpdated', (event) => {
                if (event.detail.type) {
                    Swal.fire({
                        toast: true,
                        position: "bottom-end",
                        icon: event.detail.type,
                        title: event.detail.title,
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true,
                    });
                }
            });
        });

        function initializeDragScroll(selector) {
            const elements = document.querySelectorAll(selector);

            elements.forEach(element => {
                let isDown = false;
                let startX;
                let scrollLeft;
                let startY;
                let scrollTop;

                element.addEventListener('mousedown', (e) => {
                    isDown = true;
                    startX = e.pageX - element.offsetLeft;
                    scrollLeft = element.scrollLeft;
                    startY = e.pageY - element.offsetTop;
                    scrollTop = element.scrollTop;
                    element.style.cursor = 'grabbing';
                });

                element.addEventListener('mouseleave', () => {
                    isDown = false;
                    element.style.cursor = '';
                });

                element.addEventListener('mouseup', () => {
                    isDown = false;
                    element.style.cursor = '';
                });

                element.addEventListener('mousemove', (e) => {
                    if(!isDown) return;
                    e.preventDefault();

                    // Horizontal scrolling
                    const x = e.pageX - element.offsetLeft;
                    const walkX = (x - startX) * 2;
                    element.scrollLeft = scrollLeft - walkX;

                    // Vertical scrolling
                    const y = e.pageY - element.offsetTop;
                    const walkY = (y - startY) * 2;
                    element.scrollTop = scrollTop - walkY;
                });
            });
        }
    </script>

 <script>
            // Your full JavaScript goes here (already correct in your code)
        </script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>

    </html>
@endsection
