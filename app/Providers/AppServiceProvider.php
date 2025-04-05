<?php

namespace App\Providers;

use App\Models\Income;
use App\Models\Expense;
use App\Observers\IncomeObserver;
use App\Observers\ExpenseObserver;
use Illuminate\Pagination\Paginator;
use App\Observers\PermissionObserver;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Permission;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (!request()->hasCookie('dark_mode')) {
            config(['app.dark_mode' => config('app.theme')]);
        } else {
            if (request()->cookie('dark_mode') == 1) {
                config(['app.dark_mode' => 1]);
            } else {
                config(['app.dark_mode' => 0]);
            }
        }
        Schema::defaultStringLength(191);
        Paginator::useBootstrap();
        Permission::observe(PermissionObserver::class);
        Income::observe(IncomeObserver::class);
        Expense::observe(ExpenseObserver::class);
    }
}
