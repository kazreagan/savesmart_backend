<?php
// app/Http/Controllers/Api/DashboardController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction; // You'll need to import your models
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Calculate total savings (could be from a user balance table or by summing transactions)
        $totalSavings = 25000000; // Replace with actual calculation
        
        // Calculate monthly balance growth percentage
        $lastMonthSavings = 22222222; // You would calculate this from your data
        $balanceGrowth = $lastMonthSavings > 0 
            ? (($totalSavings - $lastMonthSavings) / $lastMonthSavings) * 100 
            : 100;
        
        // Active users in the last 30 days
        $activeUsers = User::where('last_login_at', '>=', Carbon::now()->subDays(30))->count();
        
        // Calculate new users percentage (users who joined in the last 30 days)
        $newUsers = User::where('created_at', '>=', Carbon::now()->subDays(30))->count();
        $totalUsers = User::count();
        $newUsersPercentage = $totalUsers > 0 ? ($newUsers / $totalUsers) * 100 : 0;
        
        // Total withdrawals in current month
        $totalWithdrawals = Transaction::where('type', 'withdrawal')
            ->whereMonth('created_at', Carbon::now()->month)
            ->sum('amount');
            
        // Withdrawal trend (percent change from last month)
        $lastMonthWithdrawals = Transaction::where('type', 'withdrawal')
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->sum('amount');
        $withdrawalTrend = $lastMonthWithdrawals > 0 
            ? (($totalWithdrawals - $lastMonthWithdrawals) / $lastMonthWithdrawals) * 100 
            : 100;
            
        // Transaction count in current month
        $transactionCount = Transaction::whereMonth('created_at', Carbon::now()->month)->count();
        
        // Transaction trend (percent change from last month)
        $lastMonthTransactions = Transaction::whereMonth('created_at', Carbon::now()->subMonth()->month)->count();
        $transactionTrend = $lastMonthTransactions > 0 
            ? (($transactionCount - $lastMonthTransactions) / $lastMonthTransactions) * 100 
            : 100;
            
        // Generate monthly data for charts (last 6 months)
        $monthlyData = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthName = $date->format('M'); // Short month name (Jan, Feb, etc.)
            
            $deposits = Transaction::where('type', 'saving')
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->sum('amount');
                
            $withdrawals = Transaction::where('type', 'withdrawal')
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->sum('amount');
                
            $monthlyData[$monthName] = [
                'savings' => $deposits,
                'withdrawals' => $withdrawals
            ];
        }
        
        // Weekly data (last 4 weeks)
        $weeklyData = [];
        for ($i = 3; $i >= 0; $i--) {
            $startDate = Carbon::now()->startOfWeek()->subWeeks($i);
            $endDate = Carbon::now()->startOfWeek()->subWeeks($i)->endOfWeek();
            $weekName = 'Week ' . (4 - $i);
            
            $deposits = Transaction::where('type', 'saving')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->sum('amount');
                
            $withdrawals = Transaction::where('type', 'withdrawal')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->sum('amount');
                
            $weeklyData[$weekName] = [
                'savings' => $deposits,
                'withdrawals' => $withdrawals
            ];
        }
        
        // Yearly data (last 3 years)
        $yearlyData = [];
        for ($i = 2; $i >= 0; $i--) {
            $year = Carbon::now()->subYears($i)->year;
            
            $deposits = Transaction::where('type', 'saving')
                ->whereYear('created_at', $year)
                ->sum('amount');
                
            $withdrawals = Transaction::where('type', 'withdrawal')
                ->whereYear('created_at', $year)
                ->sum('amount');
                
            $yearlyData[$year] = [
                'savings' => $deposits,
                'withdrawals' => $withdrawals
            ];
        }
        
        // Transaction types distribution
        $transactionTypeData = DB::table('transactions')
            ->select('type', DB::raw('COUNT(*) as count'))
            ->whereMonth('created_at', Carbon::now()->month)
            ->groupBy('type')
            ->pluck('count', 'type')
            ->toArray();
        
        // Return JSON response for the Flutter app
        return response()->json([
            'overview' => [
                'totalBalance' => $totalSavings, // Note: Changed from total_balance to match Flutter model
                'balanceGrowth' => $balanceGrowth,
                'activeUsers' => $activeUsers,
                'newUsersPercentage' => $newUsersPercentage,
                'totalWithdrawals' => $totalWithdrawals,
                'withdrawalTrend' => $withdrawalTrend,
                'transactionCount' => $transactionCount,
                'transactionTrend' => $transactionTrend,
            ],
            'charts' => [
                'money_flow' => [
                    'monthly' => $monthlyData,
                    'weekly' => $weeklyData,
                    'yearly' => $yearlyData,
                ],
                'transaction_types' => $transactionTypeData,
            ],
        ]);
    }
}