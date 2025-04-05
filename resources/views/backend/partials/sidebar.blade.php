<aside
    class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 ps bg-white"
    id="sidenav-main" data-color="danger">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="{{ route('dashboard') }}">
            <img src="{{ asset('uploads/images/logo.png') }}" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-1 font-weight-bold">Simple FN</span>
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse w-auto h-auto ps" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <!-- Dashboard -->
            <li class="nav-item">
                <a class="nav-link @if (Route::is('dashboard')) active @endif" href="{{ route('dashboard') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <img src="{{ asset('uploads/images/dashboard.png') }}" id="icon-sidebar" alt="dashboard">
                    </div>
                    <span class="nav-link-text ms-1">{{ __('Dashboard') }}</span>
                </a>
            </li>
            <!-- User Management -->
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#users" role="button" 
                    aria-expanded="@if (Route::is('user.*')) true @else false @endif" 
                    aria-controls="users">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <img src="{{ asset('uploads/images/users.png') }}" id="icon-sidebar" alt="users">
                    </div>
                    <span class="nav-link-text ms-1">{{ __('User') }}</span>
                </a>
                <div class="collapse sub-sidebar @if (Route::is('user.*')||Route::is('role.*')||Route::is('permission.*')) show @endif" id="users">
                    <ul class="nav ms-4">
                        <li class="nav-item">
                            <a class="nav-link @if (Route::is('user.index')) active @endif" href="{{ route('user.index') }}">
                                <span class="sidenav-normal">{{ __('User List') }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if (Route::is('role.index')) active @endif" href="{{ route('role.index') }}">
                                <span class="sidenav-normal">{{ __('Roles') }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if (Route::is('permission.index')) active @endif" href="{{ route('permission.index') }}">
                                <span class="sidenav-normal">{{ __('Permission') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            {{-- Customers --}}
            <li class="nav-item">
                <a class="nav-link @if (Route::is('customers.*')) active @endif" href="{{ route('customers.index') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <img src="{{ asset('uploads/images/customers.png') }}" id="icon-sidebar" alt="dashboard">
                    </div>
                    <span class="nav-link-text ms-1">{{ __('Customers') }}</span>
                </a>
            </li>
            {{-- Budget --}}
            <li class="nav-item">
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <img src="{{ asset('uploads/images/budget.png') }}" id="icon-sidebar" alt="dashboard">
                    </div>
                    <span class="nav-link-text ms-1">{{ __('Budgets') }}</span>
                </a>
            </li>
            {{-- Income --}}
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#income" role="button" aria-expanded="false"
                    aria-controls="income">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <img src="{{ asset('uploads/images/income.png') }}" id="icon-sidebar" alt="">
                    </div>
                    <span class="nav-link-text ms-1">{{ __('Income') }}</span>
                </a>
                <div class="collapse sub-sidebar @if (Route::is('income-types.*') || Route::is('incomes.*')) show @endif" id="income">
                    <ul class="nav ms-4">
                        <li class="nav-item">
                            <a class="nav-link @if (Route::is('incomes.*')) active @endif" href="{{ route('incomes.index') }}">
                                <span class="sidenav-normal">{{ __('Income List') }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if (Route::is('income-types.*')) active @endif"
                                href="{{ route('income-types.index') }}">
                                <span class="sidenav-normal">{{ __('Income Type') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            {{-- Expense --}}
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#expenses" role="button"
                    aria-expanded="false" aria-controls="expenses">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <img src="{{ asset('uploads/images/expense.png') }}" id="icon-sidebar" alt="">
                    </div>
                    <span class="nav-link-text ms-1">{{ __('Expenses') }}</span>
                </a>
                <div class="collapse sub-sidebar @if (Route::is('expense-types.*')||Route::is('expenses.index')) show @endif" id="expenses">
                    <ul class="nav ms-4">
                        <li class="nav-item">
                            <a class="nav-link @if (Route::is('expenses.*')) active @endif" href="{{ route('expenses.index') }}">
                                <span class="sidenav-normal">{{ __('Expenses List') }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if (Route::is('expense-types.*')) active @endif" href="{{ route('expense-types.index') }}">
                                <span class="sidenav-normal">{{ __('Expenses Type') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            {{-- Report --}}
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#reports" role="button"
                    aria-expanded="false" aria-controls="reports">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <img src="{{ asset('uploads/images/report.png') }}" id="icon-sidebar" alt="">
                    </div>
                    <span class="nav-link-text ms-1">{{ __('Reports') }}</span>
                </a>
                <div class="collapse sub-sidebar" id="reports">
                    <ul class="nav ms-4">
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <span class="sidenav-normal">{{ __('Income Report') }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <span class="sidenav-normal">{{ __('Expenses Report') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            {{-- Settings --}}
            <li class="nav-item">
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <img src="{{ asset('uploads/images/settings.png') }}" id="icon-sidebar" alt="dashboard">
                    </div>
                    <span class="nav-link-text ms-1">{{ __('Settings') }}</span>
                </a>
            </li>
            {{-- Logout --}}
            <li class="nav-item">
                <form action="{{ route('logout') }}" method="POST" class="nav-link">
                    @csrf
                    <button type="submit" class="btn btn-link p-0 m-0 d-flex align-items-center">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-button-power text-danger text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Logout</span>
                    </button>
                </form>
            </li>
        </ul>
        <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
            <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
        </div>
        <div class="ps__rail-y" style="top: 0px; right: 0px;">
            <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div>
        </div>
    </div>
    <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
        <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
    </div>
    <div class="ps__rail-y" style="top: 0px; height: 688px; right: 0px;">
        <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 427px;"></div>
    </div>
</aside>
