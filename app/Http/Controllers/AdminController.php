<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Transaction;
use App\Models\SavingGoal;
use App\Models\Notification;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }
    
    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        // Fetch some basic statistics for the admin dashboard
        $stats = [
            'users_count' => User::count(),
            'transactions_count' => Transaction::count(),
            'savings_goals_count' => SavingGoal::count(),
            'notifications_count' => Notification::count(),
        ];
        
        // Get recent users
        $recentUsers = User::latest()->take(5)->get();
        
        // Get recent transactions
        $recentTransactions = Transaction::with('user')->latest()->take(5)->get();
        
        return view('admin.dashboard', compact('stats', 'recentUsers', 'recentTransactions'));
    }
    
    /**
     * Display a listing of all users.
     *
     * @return \Illuminate\View\View
     */
    public function users()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }
    
    /**
     * Show statistics and overview of system activity.
     *
     * @return \Illuminate\View\View
     */
    public function statistics()
    {
        // Monthly transaction counts
        $monthlyTransactions = Transaction::selectRaw('COUNT(*) as count, MONTH(created_at) as month')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->get();
        
        // Total savings amount
        $totalSavings = SavingGoal::sum('target_amount');
        
        // Active vs completed goals
        $activeGoals = SavingGoal::where('is_completed', false)->count();
        $completedGoals = SavingGoal::where('is_completed', true)->count();
        
        return view('admin.statistics', compact('monthlyTransactions', 'totalSavings', 'activeGoals', 'completedGoals'));
    }
}