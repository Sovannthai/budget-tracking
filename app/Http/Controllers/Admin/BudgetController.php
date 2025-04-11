<?php

namespace App\Http\Controllers\Admin;

use App\Models\Income;
use App\Models\Expense;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BudgetController extends Controller
{
    public function index()
    {
        $totalIncomes  = Income::sum('amount');
        $totalExpenses = Expense::sum('amount');
        $totalBudget   = $totalIncomes - $totalExpenses;

        $incomesByCustomer = Income::selectRaw('incomes.customer_id, customers.first_name, customers.last_name, customers.image, sum(incomes.amount) as total')
            ->join('customers', 'customers.id', '=', 'incomes.customer_id')
            ->groupBy('incomes.customer_id', 'customers.first_name', 'customers.last_name', 'customers.image')
            ->get()
            ->keyBy('customer_id');
        $expensesByCustomer = Expense::selectRaw('expenses.customer_id, customers.first_name, customers.last_name, customers.image, sum(expenses.amount) as total')
            ->join('customers', 'customers.id', '=', 'expenses.customer_id')
            ->groupBy('expenses.customer_id', 'customers.first_name', 'customers.last_name', 'customers.image')
            ->get()
            ->keyBy('customer_id');

        $customerBudgetDetails = [];
        $allCustomerIds = $incomesByCustomer->keys()->merge($expensesByCustomer->keys())->unique();
        
        foreach ($allCustomerIds as $customerId) {
            $income    = $incomesByCustomer->get($customerId);
            $expense   = $expensesByCustomer->get($customerId);
            $firstName = $income->first_name ?? $expense->first_name ?? '';
            $lastName  = $income->last_name ?? $expense->last_name ?? '';
            
            $incomeAmount  = $income->total ?? 0;
            $expenseAmount = $expense->total ?? 0;
            $balance       = $incomeAmount - $expenseAmount;
            
            $customerBudgetDetails[$customerId] = [
            'customer_id' => $customerId,
            'image'      => $income->image ?? $expense->image ?? '',
            'first_name' => $firstName,
            'last_name'  => $lastName,
            'income'     => $incomeAmount,
            'expense'    => $expenseAmount,
            'balance'    => $balance
            ];
        }
        return view('backend.budget.index', compact(
            'totalIncomes', 
            'totalExpenses', 
            'totalBudget', 
            'incomesByCustomer', 
            'expensesByCustomer', 
            'customerBudgetDetails'
        ));
    }
}
