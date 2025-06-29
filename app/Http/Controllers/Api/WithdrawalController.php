<?php
// app/Http/Controllers/Api/WithdrawalController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;

class WithdrawalController extends Controller
{
    /**
     * Get recent withdrawals
     */
    public function recent(Request $request)
    {
        // Get query parameters with defaults
        $limit = $request->query('limit', 10);
        $userId = $request->query('user_id'); // Optional user filter
        
        // Start query for withdrawals
        $query = Transaction::with('user')
            ->where('type', 'withdrawal')
            ->orderBy('created_at', 'desc');
            
        // Apply user filter if provided
        if ($userId) {
            $query->where('user_id', $userId);
        }
        
        // Get withdrawals
        $withdrawals = $query->take($limit)->get();
        
        // Format the response
        $formattedWithdrawals = $withdrawals->map(function ($withdrawal) {
            return [
                'id' => $withdrawal->id,
                'amount' => $withdrawal->amount,
                'status' => $withdrawal->status,
                'date' => $withdrawal->created_at->format('Y-m-d H:i:s'),
                'user' => [
                    'id' => $withdrawal->user->id,
                    'name' => $withdrawal->user->name,
                ],
                'description' => $withdrawal->description ?? 'Withdrawal',
            ];
        });
        
        return response()->json($formattedWithdrawals);
    }
    
    /**
     * Request a new withdrawal
     */
    public function requestWithdrawal(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
            'description' => 'nullable|string|max:255',
        ]);
        
        $userId = auth()->id();
        $user = User::findOrFail($userId);
        
        // Check if user has enough balance
        // Assuming you have a balance field in the users table
        if ($user->balance < $validated['amount']) {
            return response()->json([
                'message' => 'Insufficient balance',
            ], 400);
        }
        
        // Create withdrawal transaction
        $withdrawal = Transaction::create([
            'user_id' => $userId,
            'amount' => $validated['amount'],
            'type' => 'withdrawal',
            'status' => 'pending', // Initial status is pending
            'description' => $validated['description'] ?? 'Withdrawal request',
        ]);
        
        // Optionally deduct from user balance
        // $user->balance -= $validated['amount'];
        // $user->save();
        
        return response()->json([
            'message' => 'Withdrawal request submitted successfully',
            'withdrawal' => $withdrawal,
        ], 201);
    }
    
    /**
     * Process a withdrawal (admin function)
     */
    public function processWithdrawal(Request $request, $id)
    {
        // Check admin permissions (you should implement your own authorization logic)
        if (!auth()->user()->isAdmin()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        
        // Validate request
        $validated = $request->validate([
            'status' => 'required|in:approved,rejected',
            'notes' => 'nullable|string',
        ]);
        
        // Find the withdrawal
        $withdrawal = Transaction::where('type', 'withdrawal')
            ->findOrFail($id);
            
        // Update status
        $withdrawal->status = $validated['status'];
        $withdrawal->admin_notes = $validated['notes'] ?? null;
        $withdrawal->processed_at = Carbon::now();
        $withdrawal->processed_by = auth()->id();
        $withdrawal->save();
        
        // If rejected, refund the amount to user balance
        if ($validated['status'] === 'rejected') {
            $user = User::findOrFail($withdrawal->user_id);
            $user->balance += $withdrawal->amount;
            $user->save();
        }
        
        return response()->json([
            'message' => "Withdrawal {$validated['status']} successfully",
            'withdrawal' => $withdrawal,
        ]);
    }
    
    /**
     * Get withdrawal statistics
     */
    public function statistics()
    {
        // Current month withdrawals
        $monthStart = Carbon::now()->startOfMonth();
        $monthEnd = Carbon::now()->endOfMonth();
        
        $totalWithdrawalsMonth = Transaction::where('type', 'withdrawal')
            ->whereBetween('created_at', [$monthStart, $monthEnd])
            ->sum('amount');
            
        $withdrawalCountMonth = Transaction::where('type', 'withdrawal')
            ->whereBetween('created_at', [$monthStart, $monthEnd])
            ->count();
            
        // Get pending withdrawals
        $pendingWithdrawals = Transaction::where('type', 'withdrawal')
            ->where('status', 'pending')
            ->count();
            
        $pendingAmount = Transaction::where('type', 'withdrawal')
            ->where('status', 'pending')
            ->sum('amount');
            
        // Monthly breakdown (last 6 months)
        $monthlyStats = [];
        for ($i = 5; $i >= 0; $i--) {
            $current = Carbon::now()->subMonths($i);
            $start = $current->copy()->startOfMonth();
            $end = $current->copy()->endOfMonth();
            
            $amount = Transaction::where('type', 'withdrawal')
                ->whereBetween('created_at', [$start, $end])
                ->sum('amount');
                
            $monthlyStats[$current->format('M Y')] = $amount;
        }
        
        return response()->json([
            'current_month' => [
                'total' => $totalWithdrawalsMonth,
                'count' => $withdrawalCountMonth,
            ],
            'pending' => [
                'count' => $pendingWithdrawals,
                'amount' => $pendingAmount,
            ],
            'monthly_breakdown' => $monthlyStats,
        ]);
    }
}