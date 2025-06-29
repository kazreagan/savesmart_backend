<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\SavingGoal;
use App\Models\Saving;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $typeColumn = 'transaction_type';

        // Existing calculations
        $totalSavings = Transaction::where($typeColumn, 'income')->sum('amount') -
                        Transaction::where($typeColumn, 'expense')->sum('amount');

        $lastMonthStart = Carbon::now()->subMonth()->startOfMonth();
        $lastMonthEnd = Carbon::now()->subMonth()->endOfMonth();

        $lastMonthSavings = Transaction::where($typeColumn, 'income')
                            ->whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])
                            ->sum('amount') -
                            Transaction::where($typeColumn, 'expense')
                            ->whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])
                            ->sum('amount');

        $balanceGrowth = $lastMonthSavings > 0 ? (($totalSavings - $lastMonthSavings) / $lastMonthSavings) * 100 : 0;

        $activeUsers = User::where('status', 'active')->count();

        $lastMonthUsers = User::where('created_at', '<', Carbon::now()->subMonth())->count();
        $newUsersPercentage = $lastMonthUsers > 0 ? (($activeUsers - $lastMonthUsers) / $lastMonthUsers) * 100 : 0;

        $totalWithdrawals = Transaction::where($typeColumn, 'withdrawal')
                           ->whereMonth('created_at', now()->month)
                           ->sum('amount');

        $lastMonthWithdrawals = Transaction::where($typeColumn, 'withdrawal')
                               ->whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])
                               ->sum('amount');

        $withdrawalTrend = $lastMonthWithdrawals > 0 ? (($totalWithdrawals - $lastMonthWithdrawals) / $lastMonthWithdrawals) * 100 : 0;

        $transactionCount = Transaction::count();

        $lastMonthTransactions = Transaction::whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])->count();
        $transactionTrend = $lastMonthTransactions > 0 ? (($transactionCount - $lastMonthTransactions) / $lastMonthTransactions) * 100 : 0;

        // Dynamic Weekly Data
        $weeklyData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $day = $date->format('D');
            $weeklyData[$day] = [
                'deposits' => Transaction::where($typeColumn, 'income')
                            ->whereDate('created_at', $date->format('Y-m-d'))
                            ->sum('amount'),
                'withdrawals' => Transaction::where($typeColumn, 'withdrawal')
                               ->whereDate('created_at', $date->format('Y-m-d'))
                               ->sum('amount')
            ];
        }

        // Dynamic Monthly Data
        $monthlyData = [];
        for ($i = 5; $i >= 0; $i--) {
            $monthStart = Carbon::now()->subMonths($i)->startOfMonth();
            $monthEnd = Carbon::now()->subMonths($i)->endOfMonth();
            $monthName = $monthStart->format('M');
            $monthlyData[$monthName] = [
                'deposits' => Transaction::where($typeColumn, 'income')
                            ->whereBetween('created_at', [$monthStart, $monthEnd])
                            ->sum('amount'),
                'withdrawals' => Transaction::where($typeColumn, 'withdrawal')
                               ->whereBetween('created_at', [$monthStart, $monthEnd])
                               ->sum('amount')
            ];
        }

        // Dynamic Yearly Data
        $yearlyData = [];
        for ($i = 4; $i >= 0; $i--) {
            $year = Carbon::now()->subYears($i)->year;
            $yearStart = Carbon::create($year, 1, 1)->startOfDay();
            $yearEnd = Carbon::create($year, 12, 31)->endOfDay();
            $yearlyData[$year] = [
                'deposits' => Transaction::where($typeColumn, 'income')
                            ->whereBetween('created_at', [$yearStart, $yearEnd])
                            ->sum('amount'),
                'withdrawals' => Transaction::where($typeColumn, 'withdrawal')
                               ->whereBetween('created_at', [$yearStart, $yearEnd])
                               ->sum('amount')
            ];
        }

        // Dynamic Transaction Type Data with fallback
        $transactionTypeData = [
            'deposits' => Transaction::where($typeColumn, 'income')->count(),
            'withdrawals' => Transaction::where($typeColumn, 'withdrawal')->count(),
            'transfers' => Transaction::where($typeColumn, 'transfer')->count(),
            'savings' => Transaction::where($typeColumn, 'savings')->count(),
        ];
        \Log::info('Transaction Type Data: ', $transactionTypeData);
        if (array_sum($transactionTypeData) === 0) {
            $transactionTypeData = ['deposits' => 10, 'withdrawals' => 5, 'transfers' => 3, 'savings' => 2]; // Fallback data
            \Log::warning('No transaction data found, using fallback data: ', $transactionTypeData);
        }

        $topUsers = User::limit(5)->get();

        $recentTransactions = Transaction::latest()->take(10)->get()->map(function($transaction) use ($typeColumn) {
            return [
                'id' => $transaction->id,
                'type' => $transaction->$typeColumn ?? 'unknown',
                'description' => $transaction->description ?? 'Transaction #' . $transaction->id,
                'amount' => $transaction->amount,
                'date' => $transaction->created_at,
                'category' => 'General',
                'status' => $transaction->status ?? 'completed',
                'user' => $transaction->user
            ];
        });

        $recentWithdrawals = Transaction::where($typeColumn, 'withdrawal')
                            ->latest()
                            ->take(5)
                            ->get();

        $savingGoals = SavingGoal::with('user')
                      ->latest()
                      ->take(5)
                      ->get();

        // Category Analytics
        $predefinedCategories = ['emergency', 'travel', 'education', 'car', 'house', 'other'];
        $categoryAnalytics = [];
        $allSavingGoals = SavingGoal::all();

        foreach ($predefinedCategories as $category) {
            $count = 0;
            foreach ($allSavingGoals as $goal) {
                $goalCategory = strtolower($goal->name ?? 'other');
                $matchesCategory = false;

                if (stripos($goalCategory, $category) !== false || $category === 'other') {
                    $matchesCategory = true;
                }

                if ($matchesCategory) {
                    $count++;
                }
            }
            $categoryAnalytics[$category] = $count;
        }

        // Dynamic Savings Analytics with fallback for missing created_at
        $totalTargetAmount = Saving::sum('target_amount');
        $totalCurrentAmount = Saving::sum('current_amount');
        $lastMonthTargetAmount = 0;
        $lastMonthCurrentAmount = 0;

        try {
            $lastMonthTargetAmount = Saving::whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])->sum('target_amount');
            $lastMonthCurrentAmount = Saving::whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])->sum('current_amount');
        } catch (\Exception $e) {
            $lastMonthTargetAmount = $totalTargetAmount;
            $lastMonthCurrentAmount = $totalCurrentAmount;
        }

        $savingsProgress = $totalCurrentAmount > 0 && $totalTargetAmount > 0 ?
            ($totalCurrentAmount / $totalTargetAmount) * 100 : 0;
        $savingsGrowth = $lastMonthCurrentAmount > 0 ?
            (($totalCurrentAmount - $lastMonthCurrentAmount) / $lastMonthCurrentAmount) * 100 : 0;

        // Settings Analytics (simulated)
        $settingsChangesCount = 10;
        $lastMonthSettingsChanges = 8;
        $settingsChangeTrend = $lastMonthSettingsChanges > 0 ? (($settingsChangesCount - $lastMonthSettingsChanges) / $lastMonthSettingsChanges) * 100 : 0;

        return view('home', compact(
            'totalSavings',
            'balanceGrowth',
            'transactionCount',
            'transactionTrend',
            'recentTransactions',
            'activeUsers',
            'newUsersPercentage',
            'totalWithdrawals',
            'withdrawalTrend',
            'monthlyData',
            'weeklyData',
            'yearlyData',
            'transactionTypeData',
            'topUsers',
            'recentWithdrawals',
            'savingGoals',
            'categoryAnalytics',
            'totalTargetAmount',
            'totalCurrentAmount',
            'savingsProgress',
            'savingsGrowth',
            'settingsChangesCount',
            'settingsChangeTrend'
        ));
    }
}