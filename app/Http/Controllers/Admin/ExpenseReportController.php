<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Customer;
use App\Models\ExpenseType;
use Illuminate\Http\Request;

class ExpenseReportController extends Controller
{
    /**
     * Expense report
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Get filter parameters
        $customerId    = $request->input('customer_id');
        $expenseTypeId = $request->input('expense_type_id');
        $startDate     = $request->input('start_date');
        $endDate       = $request->input('end_date');
        $search        = $request->input('search');

        // Base query
        $query = Expense::query()->latest();

        // Apply filters
        if ($customerId) {
            $query->where('customer_id', $customerId);
        }

        if ($expenseTypeId) {
            $query->where('expense_type_id', $expenseTypeId);
        }

        if ($startDate) {
            $query->whereDate('date', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('date', '<=', $endDate);
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhereHas('customer', function($q) use ($search) {
                      $q->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('expenseType', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Get paginated results
        $expense_reports = $query->paginate(10);

        // Calculate total expense based on filters
        $totalExpenseQuery = clone $query;
        $totalExpense      = $totalExpenseQuery->sum('amount');

        // Calculate average monthly expense based on filters
        $averageMonthlyQuery = clone $query;
        $averageMonthly      = $averageMonthlyQuery->avg('amount') ?: 0;

        // Get highest expense based on filters
        $highestExpenseQuery = clone $query;
        $highestExpense      = $highestExpenseQuery->max('amount') ?: 0;

        // Get the last period's total, average, and highest expense
        $lastPeriodQuery = Expense::query();
        
        if ($customerId) {
            $lastPeriodQuery->where('customer_id', $customerId);
        }

        if ($expenseTypeId) {
            $lastPeriodQuery->where('expense_type_id', $expenseTypeId);
        }
        
        $lastPeriodQuery->where('created_at', '<', now()->startOfMonth())
            ->where('created_at', '>=', now()->subMonths(2)->startOfMonth());
            
        $lastPeriodTotal   = $lastPeriodQuery->sum('amount');
        $lastPeriodAvg     = $lastPeriodQuery->avg('amount') ?: 0;
        $lastPeriodHighest = $lastPeriodQuery->max('amount') ?: 0;
            
        $totalChange   = $lastPeriodTotal ? (($totalExpense - $lastPeriodTotal) / $lastPeriodTotal) * 100 : 0;
        $avgChange     = $lastPeriodAvg ? (($averageMonthly - $lastPeriodAvg) / $lastPeriodAvg) * 100 : 0;
        $highestChange = $lastPeriodHighest ? (($highestExpense - $lastPeriodHighest) / $lastPeriodHighest) * 100 : 0;

        // Get customers and expense types for filter dropdowns
        $customers    = Customer::orderBy('first_name')->get();
        $expenseTypes = ExpenseType::orderBy('name')->get();

        // Format numbers for display
        $formattedTotalExpense    = number_format($totalExpense, 2);
        $formattedAverageMonthly  = number_format($averageMonthly, 2);
        $formattedHighestExpense  = number_format($highestExpense, 2);

        if ($request->ajax()) {
            $html = view('backend.report.partial._expense_table', compact(
                'expense_reports'
            ))->render();

            return response()->json([
                'html'           => $html,
                'totalExpense'   => $formattedTotalExpense,
                'averageMonthly' => $formattedAverageMonthly,
                'highestExpense' => $formattedHighestExpense,
                'totalChange'    => round($totalChange, 2),
                'avgChange'      => round($avgChange, 2),
                'highestChange'  => round($highestChange, 2),
            ]);
        }

        return view('backend.report.expense_report', compact(
            'expense_reports',
            'totalExpense', 
            'averageMonthly', 
            'highestExpense', 
            'totalChange', 
            'avgChange', 
            'highestChange',
            'customers',
            'expenseTypes',
            'customerId',
            'expenseTypeId',
            'startDate',
            'endDate',
            'search'
        ));
    }
}
