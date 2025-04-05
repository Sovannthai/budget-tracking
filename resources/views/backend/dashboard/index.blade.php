@extends('backend.layouts.app')
@section('content')
    <style>
        /* Modern Animation Styles */
        .fade-in {
            animation: fadeIn 0.8s ease-in-out;
        }

        .fade-in-up {
            animation: fadeInUp 1s ease-out;
        }

        .slide-in-bottom {
            animation: slideInBottom 0.8s ease-out;
        }

        .hover-scale {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .hover-scale:hover {
            transform: translateY(-5px) scale(1.02);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .pulse {
            animation: pulse 2s infinite;
        }

        .action-card {
            transition: all 0.3s ease;
        }

        .action-card:hover {
            transform: translateY(-8px);
        }

        .action-icon {
            transition: all 0.3s ease;
        }

        .action-card:hover .action-icon {
            transform: scale(1.1);
        }

        .animate-timeline .timeline-step {
            transition: all 0.3s ease;
        }

        .animate-timeline .timeline-block:hover .timeline-step {
            transform: scale(1.15);
        }

        .animate-icon i {
            transition: all 0.3s ease;
        }

        .animate-icon:hover i {
            transform: rotate(15deg);
        }

        .btn-animated {
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-animated:after {
            content: '';
            position: absolute;
            width: 0%;
            height: 100%;
            top: 0;
            left: 0;
            background: rgba(255, 255, 255, 0.2);
            transition: width 0.3s ease;
        }

        .btn-animated:hover:after {
            width: 120%;
        }

        .table-row-hover {
            transition: all 0.2s ease;
        }

        .table-row-hover:hover {
            background-color: rgba(0, 0, 0, 0.02);
            transform: translateX(5px);
        }

        .hover-lift {
            transition: all 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .count-up {
            opacity: 0;
            animation: countUp 1s ease forwards 0.5s;
        }

        /* Keyframes */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInBottom {
            from {
                opacity: 0;
                transform: translateY(50px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }

        @keyframes countUp {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }
    </style>
    <div class="container-fluid py-4 fade-in">
        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card hover-scale">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">{{ __('Total Customer') }}</p>
                                    <h5 class="font-weight-bolder mb-0 count-up for-user">
                                        {{ $totalCustomers }}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md pulse">
                                    <i class="ni ni-single-02 text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card hover-scale">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Income</p>
                                    <h5 class="font-weight-bolder mb-0 count-up">
                                        {{ number_format($totalIncome, 2) }}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md pulse">
                                    <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card hover-scale">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Expenses</p>
                                    <h5 class="font-weight-bolder mb-0 count-up">
                                        $ {{ number_format($totalExpenses, 2) }}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-danger shadow text-center border-radius-md pulse">
                                    <i class="ni ni-cart text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card hover-scale">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">{{ __('Total Budgets') }}</p>
                                    <h5 class="font-weight-bolder mb-0 count-up">
                                        $ {{ number_format($totalBudgets, 2) }}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-success shadow text-center border-radius-md pulse">
                                    <i class="ni ni-credit-card text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Quick Actions -->
        <div class="row slide-in-bottom">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Quick Actions</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="row g-0 px-4 py-3">
                            <div class="col-xl-3 col-md-6 mb-xl-0 mb-4 p-2">
                                <div class="card card-blog card-plain action-card">
                                    <div class="position-relative">
                                        <a href="{{ route('incomes.index') }}" class="d-block border-radius-xl">
                                            <div
                                                class="card bg-gradient-success shadow-success border-radius-xl p-4 text-center action-icon">
                                                <i class="fas fa-plus-circle text-white" style="font-size: 2.5rem;"></i>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="card-body px-1 pb-0 text-center">
                                        <a href="{{ route('incomes.index') }}">
                                            <h5>Add Income</h5>
                                        </a>
                                        <p class="text-sm mb-0 text-secondary">Record a new income transaction</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6 mb-xl-0 mb-4 p-2">
                                <div class="card card-blog card-plain action-card">
                                    <div class="position-relative">
                                        <a href="{{ route('expenses.index') }}" class="d-block border-radius-xl">
                                            <div
                                                class="card bg-gradient-danger shadow-danger border-radius-xl p-4 text-center action-icon">
                                                <i class="fas fa-minus-circle text-white" style="font-size: 2.5rem;"></i>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="card-body px-1 pb-0 text-center">
                                        <a href="{{ route('expenses.index') }}">
                                            <h5>Add Expense</h5>
                                        </a>
                                        <p class="text-sm mb-0 text-secondary">Record a new expense transaction</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6 mb-xl-0 mb-4 p-2">
                                <div class="card card-blog card-plain action-card">
                                    <div class="position-relative">
                                        <a href="{{ route('expenses.index') }}" class="d-block border-radius-xl">
                                            <div
                                                class="card bg-gradient-primary shadow-primary border-radius-xl p-4 text-center action-icon">
                                                <i class="fas fa-chart-pie text-white" style="font-size: 2.5rem;"></i>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="card-body px-1 pb-0 text-center">
                                        <a href="{{ route('expenses.index') }}">
                                            <h5>Monthly Report</h5>
                                        </a>
                                        <p class="text-sm mb-0 text-secondary">View your financial reports</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6 mb-xl-0 mb-4 p-2">
                                <div class="card card-blog card-plain action-card">
                                    <div class="position-relative">
                                        <a href="#" class="d-block border-radius-xl">
                                            <div
                                                class="card bg-gradient-info shadow-info border-radius-xl p-4 text-center action-icon">
                                                <i class="fas fa-wallet text-white" style="font-size: 2.5rem;"></i>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="card-body px-1 pb-0 text-center">
                                        <a href="#">
                                            <h5>Budgets</h5>
                                        </a>
                                        <p class="text-sm mb-0 text-secondary">Manage your monthly budgets</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4 fade-in-up">
            <!-- Recent Transactions -->
            <div class="col-lg-8 col-md-6 mb-md-0 mb-4">
                <div class="card h-100">
                    <div class="card-header pb-0">
                        <div class="row">
                            <div class="col-lg-6 col-7">
                                <h6>Recent Transactions</h6>
                                <p class="text-sm mb-0">
                                </p>
                            </div>
                            <div class="col-lg-6 col-5 my-auto text-end">
                                <a href="#" class="btn btn-sm bg-gradient-primary mb-0 btn-animated">View All</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase">
                                            Icon</th>
                                        <th class="text-uppercase">
                                            Description</th>
                                        <th class="text-uppercase ps-2">
                                            Amount</th>
                                        <th class="text-uppercase ps-2">
                                            Type</th>
                                        <th class="text-uppercase ps-2">
                                            Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($transactions as $row)
                                <tr class="table-row-hover">
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div>
                                                @if ($row['icon'])
                                                {{ $row['icon'] }}
                                                @endif
                                                {{ $row['type'] }}
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $row['description'] ?? 'No description' }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="font-weight-bold mb-0 text-danger">$ {{ number_format($row['amount'],2) }}</p>
                                    </td>
                                    <td>
                                        <p class="font-weight-bold mb-0">{{ $row['transaction_type'] }}</p>
                                        <p class="text-secondary mb-0">{{ $row['type'] }}</p>
                                    </td>
                                    <td>
                                        <span class="font-weight-bold">{{ $row['date'] ? date('d M Y', strtotime($row['date'])) : '' }}</span>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Finance Summary Card -->
            <div class="col-lg-4 col-md-6">
                <div class="card h-100">
                    <div class="card-header pb-0">
                        <h6>{{ __('Income by Type') }}</h6>
                    </div>
                    <div class="card-body p-3">
                        @foreach ($totalIncomeByType as $row)
                            <div class="timeline timeline-one-side animate-timeline">
                                <div class="timeline-block mb-3">
                                    <span class="timeline-step animate-icon">
                                        {{ $row['icon'] }}
                                    </span>
                                    <div class="timeline-content">
                                        <h6 class="text-dark text-sm font-weight-bold mb-0">{{ $row['type'] }}</h6>
                                        <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                            $ {{ number_format($row['total'], 2) }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <div class="mt-4">
                            <h6 class="text-uppercase text-body text-xs font-weight-bolder mb-3">Expense by Category</h6>
                            @foreach ($totalExpensesByType as $row)
                                <div class="timeline timeline-one-side animate-timeline">
                                    <div class="timeline-block mb-3">
                                        <span class="timeline-step animate-icon">
                                            {{ $row['icon'] }}
                                        </span>
                                        <div class="timeline-content">
                                            <h6 class="text-dark text-sm font-weight-bold mb-0">{{ $row['type'] }}</h6>
                                            <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                                $ {{ number_format($row['total'], 2) }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Animate count-up effect for statistics
            $('.count-up').each(function() {
                var isUser = $(this).hasClass('for-user');
                $(this).prop('Counter', 0).animate({
                    Counter: $(this).text().replace(/[^0-9.]/g, '')
                }, {
                    duration: 1500,
                    easing: 'swing',
                    step: function(now) {
                        if (isUser) {
                            $(this).text(Math.ceil(now).toLocaleString());
                        } else {
                            $(this).text('$' + Math.ceil(now).toLocaleString());
                        }
                    }
                });
            });

            // Staggered animation for timeline elements
            $('.timeline-block').each(function(index) {
                $(this).css({
                    'animation': 'fadeInUp 0.5s ease forwards',
                    'animation-delay': (0.2 * index) + 's',
                    'opacity': '0'
                });
            });

            // Staggered animation for list items
            $('.list-group-item').each(function(index) {
                $(this).css({
                    'animation': 'fadeInUp 0.5s ease forwards',
                    'animation-delay': (0.1 * index) + 's',
                    'opacity': '0'
                });
            });

            // Table row animation
            $('tbody tr').each(function(index) {
                $(this).css({
                    'animation': 'fadeInUp 0.3s ease forwards',
                    'animation-delay': (0.1 * index) + 's',
                    'opacity': '0'
                });
            });
        });
    </script>
@endpush
