@extends('backend.layouts.app')
@section('title', __('Budget Management'))

@section('styles')
    <style>
        .summary-card {
            transition: all 0.3s ease;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .summary-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }

        .user-card {
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            border-radius: 16px;
            overflow: hidden;
            margin-bottom: 1.5rem;
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            position: relative;
        }

        .user-card:hover {
            transform: translateX(8px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .user-card::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background: linear-gradient(to bottom, #007bff, #6610f2);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .user-card:hover::before {
            opacity: 1;
        }

        .profile-img {
            width: 65px;
            height: 65px;
            border-radius: 15px;
            object-fit: cover;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border: 3px solid #fff;
            transition: all 0.4s ease;
        }

        .user-card:hover .profile-img {
            border-radius: 50%;
            transform: scale(1.05);
        }

        .user-info-wrapper {
            position: relative;
            padding: 1.5rem;
            border-radius: 16px;
            background: #fff;
        }

        .budget-stat {
            display: inline-flex;
            align-items: center;
            padding: 0.4rem 0.8rem;
            border-radius: 30px;
            font-weight: 500;
            font-size: 0.85rem;
            margin-right: 0.5rem;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .budget-stat:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .budget-income {
            background: rgba(40, 167, 69, 0.1);
            color: #28a745;
        }

        .budget-expense {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
        }

        .budget-total {
            background: rgba(0, 123, 255, 0.1);
            color: #007bff;
        }

        .progress {
            height: 10px;
            border-radius: 5px;
            background: rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .progress-bar {
            position: relative;
            overflow: hidden;
        }

        .progress-bar::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(90deg,
                    rgba(255, 255, 255, 0) 0%,
                    rgba(255, 255, 255, 0.4) 50%,
                    rgba(255, 255, 255, 0) 100%);
            animation: progress-shine 2s infinite;
        }

        @keyframes progress-shine {
            0% {
                transform: translateX(-100%);
            }

            100% {
                transform: translateX(100%);
            }
        }

        .user-type-badge {
            padding: 0.35rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .user-type-badge i {
            margin-right: 0.35rem;
            font-size: 0.7rem;
        }

        .budget-details {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-top: 0.75rem;
        }

        .remaining-budget {
            font-weight: 600;
            color: #212529;
            display: inline-flex;
            align-items: center;
            background: rgba(0, 0, 0, 0.03);
            padding: 0.35rem 0.75rem;
            border-radius: 20px;
            font-size: 0.85rem;
        }

        .remaining-budget i {
            margin-right: 0.35rem;
            color: #6c757d;
        }

        .usage-percentage {
            font-size: 0.85rem;
            color: #6c757d;
            display: inline-flex;
            align-items: center;
        }

        .usage-percentage i {
            margin-right: 0.35rem;
        }

        .animate-on-scroll {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.6s ease;
        }

        .animate-on-scroll.visible {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="mb-4">Budget Dashboard</h1>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="row mb-5">
            <!-- Total Income Card -->
            <div class="col-md-4 mb-4">
                <div class="card summary-card animate-on-scroll">
                    <div class="card-body bg-success-subtle">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted">Total Income</h6>
                                <h2 class="mb-0">$ {{ number_format($totalIncomes, 2) }}</h2>
                            </div>
                            <div class="rounded-circle bg-success bg-opacity-25 p-3">
                                <i class="fa fa-arrow-up fa-2x text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Expense Card -->
            <div class="col-md-4 mb-4">
                <div class="card summary-card animate-on-scroll" style="animation-delay: 0.2s">
                    <div class="card-body bg-danger-subtle">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted">Total Expense</h6>
                                <h2 class="mb-0">$ {{ number_format($totalExpenses, 2) }}</h2>
                            </div>
                            <div class="rounded-circle bg-danger bg-opacity-25 p-3">
                                <i class="fa fa-arrow-down fa-2x text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Budget Status Card -->
            <div class="col-md-4 mb-4">
                <div class="card summary-card animate-on-scroll" style="animation-delay: 0.4s">
                    <div class="card-body bg-primary-subtle">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted">Budget</h6>
                                <h2 class="mb-0">$ {{ number_format($totalBudget, 2) }}</h2>
                            </div>
                            <div class="rounded-circle bg-primary bg-opacity-25 p-3">
                                <i class="fa fa-wallet fa-2x text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Users Budget List -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">User Budget Details</h5>
                    </div>
                    <div class="card-body p-4">
                        @forelse ($customerBudgetDetails as $row)
                            <div class="user-card animate-on-scroll mb-3">
                                <div class="user-info-wrapper">
                                    <div class="d-flex align-items-center">
                                        <a class="example-image-link p-2"
                                           href="{{ $row['image'] ? asset('uploads/all_photo/' . $row['image']) : asset('uploads/images/defualt.png') }}"
                                           data-lightbox="lightbox-{{ $row['id'] ?? 'user' }}">
                                            <img class="profile-img rounded-circle"
                                                 src="{{ $row['image'] ? asset('uploads/all_photo/' . $row['image']) : asset('uploads/images/defualt.png') }}"
                                                 alt="User" width="150" height="150" style="cursor:pointer" />
                                        </a>
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <div>
                                                    <h5 class="mb-1 fw-bold">{{ $row['first_name'] }} {{ $row['last_name'] }}</h5>
                                                </div>
                                                <div class="budget-total" hidden>
                                                    <i class="fas fa-wallet me-1"></i> Budget: $ {{ number_format($row['balance'], 2) }}
                                                </div>
                                            </div>

                                            <div class="budget-details">
                                                <span class="budget-stat budget-income text-success">
                                                    <i class="fas fa-arrow-up me-1"></i> Income: $ {{ number_format($row['income'],2) }}
                                                </span>
                                                <span class="budget-stat budget-expense text-danger">
                                                    <i class="fas fa-arrow-down me-1"></i> Expense: $ {{ number_format($row['expense'],2) }}
                                                </span>
                                                <span class="budget-stat budget-expense text-info me-2">
                                                    <i class="fas fa-wallet me-1"></i> Budget: $ {{ number_format($row['balance'], 2) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div>
                                <p class="text-center">No budget data available.</p>
                                <p class="text-center">Please add some budgets to see the details.</p>
                            </div>
                        @endforelse
                    </div>
                    @include('backend.components.table.paginate', ['paginatedArray' => $customerBudgetDetails])
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Animation on scroll
        document.addEventListener('DOMContentLoaded', function() {
            const animateElements = document.querySelectorAll('.animate-on-scroll');

            // Initial check
            checkVisibility();

            // Check on scroll
            window.addEventListener('scroll', checkVisibility);

            function checkVisibility() {
                animateElements.forEach(element => {
                    const elementTop = element.getBoundingClientRect().top;
                    const elementVisible = 150;

                    if (elementTop < window.innerHeight - elementVisible) {
                        element.classList.add('visible');
                    }
                });
            }

            // Add hover effects for budget stats
            const budgetStats = document.querySelectorAll('.budget-stat');
            budgetStats.forEach(stat => {
                stat.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-5px) scale(1.05)';
                });

                stat.addEventListener('mouseleave', function() {
                    this.style.transform = '';
                });
            });
        });
    </script>
@endsection
