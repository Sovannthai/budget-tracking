<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Budget;
use App\Models\Customer;
use App\Models\Expense;
use App\Models\Income;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalIncome       = Income::sum('amount');
        $totalExpenses     = Expense::sum('amount');
        $totalCustomers    = Customer::count();
        $totalBudgets      = Budget::sum('balance');
        $totalIncomeByType = Income::with('incomeType')
            ->selectRaw('sum(amount) as total, income_type_id')
            ->groupBy('income_type_id')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($item) {
            return [
                'icon'  => $item->incomeType->icon,
                'type'  => $item->incomeType->name,
                'total' => $item->total,
            ];
            });

        $totalExpensesByType = Expense::with('expenseType')
            ->selectRaw('sum(amount) as total, expense_type_id')
            ->groupBy('expense_type_id')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                return [
                    'icon'  => $item->expenseType->icon,
                    'type'  => $item->expenseType->name,
                    'total' => $item->total,
                ];
            });
        // Get transaction expenses and income all in one query
        $transactions = collect();

        $expenseTransactions = Expense::with('expenseType')
            ->select('id', 'amount', 'description', 'expense_type_id', 'date')
            ->orderBy('date', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($item) {
                return [
                    'id'               => $item->id,
                    'icon'             => $item->expenseType->icon,
                    'type'             => $item->expenseType->name,
                    'amount'           => $item->amount,
                    'description'      => $item->description,
                    'date'             => $item->date,
                    'transaction_type' => 'expense'
                ];
            });

        $incomeTransactions = Income::with('incomeType')
            ->select('id', 'amount', 'description', 'income_type_id', 'date')
            ->orderBy('date', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($item) {
                return [
                    'id'               => $item->id,
                    'icon'             => $item->incomeType->icon,
                    'type'             => $item->incomeType->name,
                    'amount'           => $item->amount,
                    'description'      => $item->description,
                    'date'             => $item->date,
                    'transaction_type' => 'income'
                ];
            });

        $transactions = $expenseTransactions->concat($incomeTransactions)
            ->sortByDesc('date')
            ->take(8)
            ->values();
            
        return view('backend.dashboard.index',compact(
            'totalIncome', 
            'totalExpenses', 
            'totalCustomers', 
            'totalBudgets', 
            'totalIncomeByType', 
            'totalExpensesByType',
            'transactions'
        ));
    }
}
