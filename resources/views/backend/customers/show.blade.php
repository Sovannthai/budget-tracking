    <style>
        body {
            background-color: #f5f7fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .customer-profile {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #fff;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        }

        .modal-content {
            border-radius: 15px;
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .customer-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #eaedf2;
            padding: 24px;
        }

        .detail-row {
            padding: 12px 0;
            border-bottom: 1px solid #eaedf2;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            color: #6c757d;
            font-weight: 500;
            font-size: 0.875rem;
        }

        .detail-value {
            font-weight: 500;
            color: #212529;
        }

        .gender-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .gender-male {
            background-color: #e7f1ff;
            color: #0d6efd;
        }

        .gender-female {
            background-color: #ffebf6;
            color: #d63384;
        }

        .close-button {
            position: absolute;
            right: 20px;
            top: 20px;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 50%;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
        }

        .close-button:hover {
            background-color: rgba(0, 0, 0, 0.1);
        }

        .modal-body {
            padding: 24px;
        }

        .info-section {
            background-color: #fff;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            margin-bottom: 20px;
        }

        .section-title {
            font-weight: 600;
            color: #344767;
            margin-bottom: 20px;
            font-size: 1.1rem;
            position: relative;
            padding-bottom: 12px;
        }

        .section-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 40px;
            height: 3px;
            background-color: #0d6efd;
            border-radius: 10px;
        }

        .contact-info i {
            width: 20px;
            color: #6c757d;
        }

        .financial-card {
            border-radius: 10px;
            padding: 15px;
            height: 100%;
            transition: all 0.3s ease;
        }

        .financial-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .financial-icon {
            width: 45px;
            height: 45px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
        }

        .financial-title {
            font-size: 0.85rem;
            color: #6c757d;
            margin-bottom: 5px;
        }

        .financial-value {
            font-size: 1.25rem;
            font-weight: 600;
        }

        .income-bg {
            background-color: rgba(25, 135, 84, 0.1);
            color: #198754;
        }

        .expense-bg {
            background-color: rgba(220, 53, 69, 0.1);
            color: #dc3545;
        }

        .budget-bg {
            background-color: rgba(13, 110, 253, 0.1);
            color: #0d6efd;
        }

        .orders-bg {
            background-color: rgba(255, 193, 7, 0.1);
            color: #ffc107;
        }

        .progress {
            height: 8px;
            margin-top: 10px;
            background-color: #e9ecef;
        }

        .budget-progress {
            display: flex;
            justify-content: space-between;
            font-size: 0.8rem;
            color: #6c757d;
            margin-top: 5px;
        }
    </style>
<div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
        <!-- Close Button -->
        <button type="button" class="close-button" data-bs-dismiss="modal" aria-label="Close">
            <i class="bi bi-x"></i>
        </button>

        <!-- Customer Header -->
        <div class="customer-header">
            <div class="row align-items-center">
                <div class="col-md-3 col-sm-4 text-center text-sm-start mb-3 mb-sm-0">
                    @include('backend.components.table.show_image_table',[
                            'field_name' => $customer->image,
                            'id'         => $customer->id,
                            'image_path' => 'uploads/all_photo/',
                        ])
                </div>
                <div class="col-md-9 col-sm-8">
                    <h4 class="mb-1">{{ $customer->first_name }} {{ $customer->last_name }}</h4>
                    <p class="text-muted mb-2">Customer ID: #{{ $customer->contact_id }}</p>
                    <span class="gender-badge gender-male text-capitalize">
                        <i class="bi bi-gender-male me-1"></i> {{ $customer->gender }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Customer Details -->
        <div class="modal-body">
            <!-- Financial Information -->
            <div class="info-section mb-4">
                <h5 class="section-title">Financial Overview</h5>
                <div class="row g-3">
                    <div class="col-md-4 col-6">
                        <div class="financial-card">
                            <div class="financial-icon income-bg">
                                <i class="bi bi-graph-up-arrow"></i>
                            </div>
                            <div class="financial-title">Total Income</div>
                            <div class="financial-value">$ {{ number_format($totalIcome,2) }}</div>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="financial-card">
                            <div class="financial-icon expense-bg">
                                <i class="bi bi-graph-down-arrow"></i>
                            </div>
                            <div class="financial-title">Total Expenses</div>
                            <div class="financial-value">$ {{ number_format($totalExpense,2) }}</div>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="financial-card">
                            <div class="financial-icon budget-bg">
                                <i class="bi bi-wallet2"></i>
                            </div>
                            <div class="financial-title">Budget</div>
                            <div class="financial-value">$ {{ number_format($totalBudget,2) }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Personal Information -->
                <div class="col-md-6 mb-4">
                    <div class="info-section h-100">
                        <h5 class="section-title">Personal Information</h5>

                        <div class="detail-row">
                            <div class="row">
                                <div class="col-5 detail-label">First Name</div>
                                <div class="col-7 detail-value">{{ $customer->first_name }}</div>
                            </div>
                        </div>

                        <div class="detail-row">
                            <div class="row">
                                <div class="col-5 detail-label">Last Name</div>
                                <div class="col-7 detail-value">{{ $customer->last_name }}</div>
                            </div>
                        </div>

                        <div class="detail-row">
                            <div class="row">
                                <div class="col-5 detail-label">Gender</div>
                                <div class="col-7 detail-value text-capitalize">{{ $customer->gender }}</div>
                            </div>
                        </div>

                        <div class="detail-row">
                            <div class="row">
                                <div class="col-5 detail-label">Date of Birth</div>
                                <div class="col-7 detail-value">{{ $customer->dob ? date('d M Y', strtotime($customer->dob)) : '' }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="col-md-6 mb-4">
                    <div class="info-section h-100">
                        <h5 class="section-title">Contact Information</h5>

                        <div class="detail-row">
                            <div class="contact-info mb-2">
                                <i class="bi bi-envelope"></i>
                                <span class="detail-value">{{ $customer->email }}</span>
                            </div>
                        </div>

                        <div class="detail-row">
                            <div class="contact-info mb-2">
                                <i class="bi bi-telephone"></i>
                                <span class="detail-value">+(855) {{ $customer->phone }}</span>
                            </div>
                        </div>

                        <div class="detail-row">
                            <div class="contact-info">
                                <i class="bi bi-geo-alt"></i>
                                <span class="detail-value">{{ $customer->address }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Account Information -->
                <div class="col-12">
                    <div class="info-section">
                        <h5 class="section-title">Account Information</h5>
                        <div class="row g-3">
                            <div class="col-md-4 col-6">
                                <div class="text-muted small">Customer Since</div>
                                <div class="detail-value">{{ $customer->created_at ? date('d M Y, H:i a', strtotime($customer->created_at)) : '' }}</div>
                            </div>
                            <div class="col-md-4 col-6">
                                <div class="text-muted small">Status</div>
                                <div>
                                    @if($customer->status == 1)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </div>    </div>
                            <div class="col-md-4 col-6">
                                <div class="text-muted small">Last Updated</div>
                                <div class="detail-value">{{ $customer->updated_at ? date('d M Y, H:i a', strtotime($customer->updated_at)) : '' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Footer -->
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
        </div>
    </div>
</div>
