@extends('backend.layouts.app')
@section('title', __('Expense Report'))
@section('content')
    @include('backend.report.partial._expense_style')
    <div class="container">
        <div class="dashboard">
            <div class="card">
                <div class="card-title">
                    <div class="icon icon-primary animated-icon">
                        <i class="fas fa-wallet"></i>
                    </div>
                    Total Expense
                </div>
                <div class="card-value" id="total-expense">$ {{ number_format($totalExpense, 2) }}</div>
                <div class="card-change positive" id="total-change">
                    <i class="fas fa-arrow-up me-1"></i> {{ $totalChange }} % from last period
                </div>
            </div>

            <div class="card">
                <div class="card-title">
                    <div class="icon icon-secondary animated-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    Average Monthly
                </div>
                <div class="card-value" id="average-monthly">$ {{ number_format($averageMonthly, 2) }}</div>
                <div class="card-change positive" id="avg-change">
                    <i class="fas fa-arrow-up me-1"></i> {{ $avgChange }} % from last period
                </div>
            </div>

            <div class="card">
                <div class="card-title">
                    <div class="icon icon-success animated-icon">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    Highest Expense
                </div>
                <div class="card-value" id="highest-expense">$ {{ number_format($highestExpense, 2) }}</div>
                <div class="card-change negative" id="highest-change">
                    <i class="fas fa-arrow-down me-1"></i> {{ $highestChange }} % from last period
                </div>
            </div>
        </div>

        <div class="filter-container mb-4">
            <form id="filter-form" action="{{ route('expense-report') }}" method="GET">
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <select name="customer_id" class="form-select select2">
                            <option value="">-- Select Customer --</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}" {{ $customerId == $customer->id ? 'selected' : '' }}>
                                        @if ($customer->first_name && $customer->last_name)
                                            {{ $customer->first_name }} {{ $customer->last_name }}
                                        @elseif ($customer->phone)
                                            {{ $customer->phone }}
                                        @elseif ($customer->email)
                                            {{ $customer->email }}
                                        @else
                                            No customer information
                                        @endif
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-2">
                        <select name="expense_type_id" class="form-select select2">
                            <option value="">-- Select Expense Type --</option>
                            @foreach ($expenseTypes as $type)
                                <option value="{{ $type->id }}" {{ $expenseTypeId == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-2">
                        <input type="date" name="start_date" class="form-control flatpickr-date" placeholder="Start Date"
                            value="{{ $startDate ?? '' }}">
                    </div>
                    <div class="col-md-3 mb-2">
                        <input type="date" name="end_date" class="form-control flatpickr-date" placeholder="End Date"
                            value="{{ $endDate ?? '' }}">
                    </div>
                    <div class="col-md-9 mb-2">
                        <input type="text" name="search" id="search-input" class="form-control"
                            placeholder="Search by description, customer name or expense type..."
                            value="{{ $search ?? '' }}">
                    </div>
                    <div class="col-md-3 mb-2">
                        <div class="d-flex">
                            <a href="{{ route('expense-report') }}" type="button" id="reset-button" class="btn btn-lg btn-secondary">Reset</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="table-container">
            <div id="expense-data">
                <table class="table text-nowrap table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Customer</th>
                            <th>Description</th>
                            <th>Expense Type</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($expense_reports as $row)
                            <tr>
                                <td class="date">{{ $row->date ? date('d M Y', strtotime($row->date)) : '' }}</td>
                                <td>
                                <span>
                                    <a class="example-image-link"
                                        href="{{ optional($row->customer)->image ? asset('uploads/all_photo/' . optional($row->customer)->image) : asset('uploads/images/default.png') }}"
                                        data-lightbox="lightbox-{{ $row->id }}">
                                        <img class="avatar rounded-circle"
                                            src="{{ optional($row->customer)->image ? asset('uploads/all_photo/' . optional($row->customer)->image) : asset('uploads/images/default.png') }}"
                                            alt="profile" width="50px" height="50px" style="cursor:pointer" />
                                    </a>
                                </span>
                                    {{ optional($row->customer)->first_name }} {{ optional($row->customer)->last_name }}
                                </td>
                                <td>{{ $row->description ?? 'No description' }}</td>
                                <td>
                                    <span class="expense-type type-salary">
                                        {{ optional($row->expenseType)->icon }} {{ optional($row->expenseType)->name }}
                                    </span>
                                </td>
                                <td class="amount">$ {{ number_format($row->amount, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @include('backend.components.table.paginate', [
                    'items' => $expense_reports,
                ])
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            // Card animation
            $('.card').on({
                mouseenter: function() {
                    $(this).find('.icon').css('animationPlayState', 'running');
                },
                mouseleave: function() {
                    $(this).find('.icon').css('animationPlayState', 'paused');
                }
            });

            // Function to load data via AJAX
            function loadData() {
                $.ajax({
                    url: "{{ route('expense-report') }}",
                    type: "GET",
                    data: $('#filter-form').serialize(),
                    dataType: "json",
                    success: function(response) {
                        // Update the data container with new HTML
                        $('#expense-data').html(response.html);

                        // Update statistics
                        $('#total-expense').html('$ ' + response.totalExpense);
                        $('#average-monthly').html('$ ' + response.averageMonthly);
                        $('#highest-expense').html('$ ' + response.highestExpense);

                        // Update percent changes
                        updateChangeElement('#total-change', response.totalChange);
                        updateChangeElement('#avg-change', response.avgChange);
                        updateChangeElement('#highest-change', response.highestChange);

                        // Update URL with new parameters without refreshing page
                        window.history.pushState({}, '', '{{ route('expense-report') }}?' + $(
                            '#filter-form').serialize());
                    },
                    error: function(xhr) {
                        console.error('Error loading data:', xhr);
                    }
                });
            }

            // Helper function to update change elements with correct icon and class
            function updateChangeElement(selector, value) {
                let element = $(selector);
                element.removeClass('positive negative');

                if (value >= 0) {
                    element.addClass('positive');
                    element.html('<i class="fas fa-arrow-up me-1"></i> ' + value + ' % from last period');
                } else {
                    element.addClass('negative');
                    element.html('<i class="fas fa-arrow-down me-1"></i> ' + Math.abs(value) +
                        ' % from last period');
                }
            }

            // Prevent default form submission and use AJAX instead
            $('#filter-form').on('submit', function(e) {
                e.preventDefault();
                loadData();
            });

            // Search with keyup function
            let typingTimer;
            const doneTypingInterval = 100; // Wait 500ms after user stops typing

            $('#search-input').on('keyup', function() {
                clearTimeout(typingTimer);
                typingTimer = setTimeout(function() {
                    loadData();
                }, doneTypingInterval);
            });

            // Clear timeout on keydown
            $('#search-input').on('keydown', function() {
                clearTimeout(typingTimer);
            });

            // Auto-submit on select change
            $('select[name="customer_id"], select[name="expense_type_id"]').on('change', function() {
                loadData();
            });

            // Auto-submit on date change
            $('input[name="start_date"], input[name="end_date"]').on('change', function() {
                loadData();
            });

            // Reset button
            $('#reset-button').on('click', function() {
                $('#filter-form')[0].reset();
                loadData();
            });

            // Pagination links - delegate event to handle dynamically loaded content
            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();
                let url = $(this).attr('href');
                $.ajax({
                    url: url,
                    type: "GET",
                    data: $('#filter-form').serialize(),
                    dataType: "json",
                    success: function(response) {
                        $('#expense-data').html(response.html);
                    },
                    error: function(xhr) {
                        console.error('Error loading data:', xhr);
                    }
                });
            });
        });
    </script>
@endpush
