<style>
    /* Modern Table Styles */
    .modern-table {
        border-collapse: separate;
        border-spacing: 0;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
        width: 100%;
    }

    .modern-table thead th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
        padding: 12px 8px;
    }

    .modern-table tbody tr {
        transition: all 0.2s ease;
    }

    .modern-table tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05);
        transform: translateY(-1px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    }

    .modern-table td {
        padding: 12px 8px;
        vertical-align: middle;
    }

    /* Grid Layout Styles */
    .customer-card {
        border-radius: 10px;
        overflow: hidden;
        transition: all 0.3s ease;
        border: 1px solid rgba(0, 0, 0, 0.075);
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .customer-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .grid-img {
        width: 60px;
        height: 60px;
        object-fit: cover;
    }

    .layout-btn.active {
        background-color: #007bff;
        color: white;
    }

    /* Responsive adjustments */
    @media (max-width: 1200px) {
        .grid-layout .col-lg-4 {
            flex: 0 0 33.333%;
            max-width: 33.333%;
        }
    }

    @media (max-width: 992px) {
        .grid-layout .col-lg-4 {
            flex: 0 0 50%;
            max-width: 50%;
        }
        
        .customer-card {
            margin-bottom: 15px;
        }
    }

    @media (max-width: 768px) {
        .grid-layout .col-md-6,
        .grid-layout .col-lg-4 {
            flex: 0 0 100%;
            max-width: 100%;
        }

        .modern-table {
            display: block;
            overflow-x: auto;
            width: 100%;
        }
        
        .modern-table thead th {
            font-size: 0.75rem;
            padding: 10px 6px;
        }
        
        .modern-table td {
            padding: 10px 6px;
            font-size: 0.9rem;
        }
        
        .layout-btn {
            width: 100%;
            margin-bottom: 10px;
            padding: 10px;
            text-align: center;
        }
        
        .grid-img {
            width: 50px;
            height: 50px;
        }
    }
    
    @media (max-width: 576px) {
        .customer-card {
            padding: 10px;
        }
        
        .modern-table td, 
        .modern-table th {
            white-space: nowrap;
        }
        
        /* Enhance touch targets for mobile */
        .customer-card, 
        .layout-btn,
        .modern-table tbody tr {
            -webkit-tap-highlight-color: transparent;
        }
        
        .modern-table tbody tr:active {
            background-color: rgba(0, 123, 255, 0.1);
        }
    }
</style>
@push('scripts')
    <script>
        $(document).ready(function() {
            const layoutButtons = $('.layout-btn');
            const tableLayout = $('.table-layout');
            const gridLayout = $('.grid-layout');
            
            const savedLayout = localStorage.getItem('customerLayoutPreference') || 'table';
            
            function applyLayout(layout) {
                layoutButtons.removeClass('active');
                layoutButtons.filter(`[data-layout="${layout}"]`).addClass('active');
                
                if (layout === 'table') {
                    tableLayout.removeClass('d-none');
                    gridLayout.addClass('d-none');
                } else {
                    tableLayout.addClass('d-none');
                    gridLayout.removeClass('d-none');
                }
                
                localStorage.setItem('customerLayoutPreference', layout);
            }
            
            applyLayout(savedLayout);

            layoutButtons.on('click', function() {
                const layout = $(this).data('layout');
                applyLayout(layout);
            });
            
            $(document).on('layout:change', function(e, layout) {
                if (layout === 'table' || layout === 'grid') {
                    applyLayout(layout);
                }
            });
        });
    </script>
@endpush
