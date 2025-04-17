<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Income;
use App\Models\Customer;
use App\Models\IncomeType;
use Illuminate\Http\Request;

class IncomeReportController extends Controller
{
    /**
     * Income report
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Get filter parameters
        $customerId   = $request->input('customer_id');
        $incomeTypeId = $request->input('income_type_id');
        $startDate    = $request->input('start_date');
        $endDate      = $request->input('end_date');
        $search       = $request->input('search');

        // Base query
        $query = Income::query()->latest();

        // Apply filters
        if ($customerId) {
            $query->where('customer_id', $customerId);
        }

        if ($incomeTypeId) {
            $query->where('income_type_id', $incomeTypeId);
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
                  ->orWhereHas('incomeType', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Get paginated results
        $income_reports = $query->paginate($this->limit());

        // Calculate total income based on filters
        $totalIncomeQuery = clone $query;
        $totalIncome      = $totalIncomeQuery->sum('amount');

        // Calculate average monthly income based on filters
        $averageMonthlyQuery = clone $query;
        $averageMonthly      = $averageMonthlyQuery->avg('amount') ?: 0;

        // Get highest income based on filters
        $highestIncomeQuery = clone $query;
        $highestIncome      = $highestIncomeQuery->max('amount') ?: 0;

        // Get the last period's total, average, and highest income
        $lastPeriodQuery = Income::query();
        
        if ($customerId) {
            $lastPeriodQuery->where('customer_id', $customerId);
        }

        if ($incomeTypeId) {
            $lastPeriodQuery->where('income_type_id', $incomeTypeId);
        }
        
        $lastPeriodQuery->where('created_at', '<', now()->startOfMonth())
            ->where('created_at', '>=', now()->subMonths(2)->startOfMonth());
            
        $lastPeriodTotal   = $lastPeriodQuery->sum('amount');
        $lastPeriodAvg     = $lastPeriodQuery->avg('amount') ?: 0;
        $lastPeriodHighest = $lastPeriodQuery->max('amount') ?: 0;
            
        $totalChange   = $lastPeriodTotal ? (($totalIncome - $lastPeriodTotal) / $lastPeriodTotal) * 100 : 0;
        $avgChange     = $lastPeriodAvg ? (($averageMonthly - $lastPeriodAvg) / $lastPeriodAvg) * 100 : 0;
        $highestChange = $lastPeriodHighest ? (($highestIncome - $lastPeriodHighest) / $lastPeriodHighest) * 100 : 0;

        // Get customers and income types for filter dropdowns
        $customers = Customer::orderBy('first_name')->get();
        $incomeTypes = IncomeType::orderBy('name')->get();

        // Format numbers for display
        $formattedTotalIncome    = number_format($totalIncome, 2);
        $formattedAverageMonthly = number_format($averageMonthly, 2);
        $formattedHighestIncome  = number_format($highestIncome, 2);

        if ($request->ajax()) {
            $html = view('backend.report.partial._income_table', compact(
                'income_reports'
            ))->render();

            return response()->json([
                'html'          => $html,
                'totalIncome'   => $formattedTotalIncome,
                'averageMonthly'=> $formattedAverageMonthly,
                'highestIncome' => $formattedHighestIncome,
                'totalChange'   => round($totalChange, 2),
                'avgChange'     => round($avgChange, 2),
                'highestChange' => round($highestChange, 2),
            ]);
        }

        return view('backend.report.income_report', compact(
            'income_reports',
            'totalIncome', 
            'averageMonthly', 
            'highestIncome', 
            'totalChange', 
            'avgChange', 
            'highestChange',
            'customers',
            'incomeTypes',
            'customerId',
            'incomeTypeId',
            'startDate',
            'endDate',
            'search'
        ));
    }
}
