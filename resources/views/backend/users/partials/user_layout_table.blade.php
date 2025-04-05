<!-- filepath: c:\laragon\www\simple-finances\resources\views\backend\users\style\user_layout_table.blade.php -->
<style>
    /* Modern styling for user management */
    .card {
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    }

    .card-header {
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    .table th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
        padding: 1rem 0.75rem;
        border-bottom: 2px solid #dee2e6;
    }

    .hover-shadow:hover {
        background-color: rgba(0, 0, 0, 0.02);
        transform: translateY(-2px);
    }

    .transition-all {
        transition: all 0.2s ease;
    }

    /* Grid view specific styles */
    .user-card {
        border-radius: 0.5rem;
        overflow: hidden;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .user-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
    }

    .user-avatar {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Responsive styles */
    @media (max-width: 1199.98px) {
        .table-responsive {
            overflow-x: auto;
        }
    }

    @media (max-width: 991.98px) {
        .user-card {
            margin-bottom: 1rem;
        }
    }

    @media (max-width: 767.98px) {
        .table th {
            font-size: 0.75rem;
            padding: 0.75rem 0.5rem;
        }
        
        .user-card {
            margin-bottom: 1rem;
        }
        
        .card-header .float-right {
            float: none !important;
            margin-top: 1rem;
            display: flex;
            justify-content: center;
        }
    }

    @media (max-width: 575.98px) {
        .table th, .table td {
            font-size: 0.7rem;
            padding: 0.5rem 0.25rem;
        }
        
        .user-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1) !important;
        }
        
        .view-toggle-buttons {
            width: 100%;
            display: flex;
            justify-content: center;
            margin-bottom: 1rem;
        }
        
        .view-toggle-buttons .btn {
            flex: 1;
        }
    }
</style>
@push('scripts')
    <script>
        $(document).ready(function() {
            // Save user preference in local storage
            const savedView = localStorage.getItem('userPreferredView');
            if (savedView === 'grid') {
                showGridView();
            } else {
                showTableView();
            }
            
            // Handle window resize for responsiveness
            $(window).resize(function() {
                if ($(window).width() < 768) {
                    // On very small screens, grid view is often better
                    // But respect user's last choice
                    if (!localStorage.getItem('userPreferredView')) {
                        showGridView();
                    }
                }
            });
            
            // Run once on page load to handle initial screen size
            $(window).trigger('resize');

            $('#table-view-btn').click(function() {
                showTableView();
                localStorage.setItem('userPreferredView', 'table');
            });

            $('#grid-view-btn').click(function() {
                showGridView();
                localStorage.setItem('userPreferredView', 'grid');
            });
            
            function showTableView() {
                $('.table-view').removeClass('d-none');
                $('.grid-view').addClass('d-none');
                $('#table-view-btn').addClass('active');
                $('#grid-view-btn').removeClass('active');
            }
            
            function showGridView() {
                $('.grid-view').removeClass('d-none');
                $('.table-view').addClass('d-none');
                $('#grid-view-btn').addClass('active');
                $('#table-view-btn').removeClass('active');
            }
        });
    </script>
@endpush