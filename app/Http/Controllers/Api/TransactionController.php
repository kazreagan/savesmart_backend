<?php
// app/Http/Controllers/Api/TransactionController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use Carbon\Carbon;

class TransactionController extends Controller
{
    /**
     * Get recent transactions
     */
    public function recent(Request $request)
    {
        // Get query parameters with defaults
        $limit = $request->query('limit', 10);
        $userId = $request->query('user_id'); // Optional user filter
        
        // Start query
        $query = Transaction::with('user')
            ->orderBy('created_at', 'desc');
            
        // Apply user filter if provided
        if ($userId) {
            $query->where('user_id', $userId);
        }
        
        // Get transactions
        $transactions = $query->take($limit)->get();
        
        // Format the response
        $formattedTransactions = $transactions->map(function ($transaction) {
            return [
                'id' => $transaction->id,
                'amount' => $transaction->amount,
                'type' => $transaction->type,
                'description' => $transaction->description,
                'status' => $transaction->status,
                'date' => $transaction->created_at->format('Y-m-d H:i:s'),
                'user' => [
                    'id' => $transaction->user->id,
                    'name' => $transaction->user->name,
                ],
            ];
        });
        
        return response()->json($formattedTransactions);
    }
    
    /**
     * Store a new transaction
     */
    public function store(Request $request)
    {
        // Validate request data
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0',
            'type' => 'required|in:deposit,withdrawal,transfer',
            'description' => 'nullable|string|max:255',
        ]);
        
        // Create the transaction
        $transaction = Transaction::create($validated);
        
        return response()->json($transaction, 201);
    }
    
    /**
     * Get transaction statistics
     */
    public function statistics()
    {
        // Get today's transactions
        $today = Carbon::today();
        $todayTotal = Transaction::whereDate('created_at', $today)->sum('amount');
        $todayCount = Transaction::whereDate('created_at', $today)->count();
        
        // Get this week's transactions
        $weekStart = Carbon::now()->startOfWeek();
        $weekTotal = Transaction::whereBetween('created_at', [$weekStart, Carbon::now()])->sum('amount');
        
        // Get this month's transactions
        $monthStart = Carbon::now()->startOfMonth();
        $monthTotal = Transaction::whereBetween('created_at', [$monthStart, Carbon::now()])->sum('amount');
        
        // Get transaction counts by type this month
        $typeBreakdown = Transaction::whereBetween('created_at', [$monthStart, Carbon::now()])
            ->selectRaw('type, count(*) as count, sum(amount) as total')
            ->groupBy('type')
            ->get();
        
        return response()->json([
            'today' => [
                'total' => $todayTotal,
                'count' => $todayCount
            ],
            'week' => [
                'total' => $weekTotal
            ],
            'month' => [
                'total' => $monthTotal
            ],
            'type_breakdown' => $typeBreakdown
        ]);
    }
}