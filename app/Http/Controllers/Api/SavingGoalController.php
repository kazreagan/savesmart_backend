<?php
// app/Http/Controllers/Api/SavingGoalController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SavingGoal;
use Carbon\Carbon;

class SavingGoalController extends Controller
{
    /**
     * Get all saving goals for the authenticated user
     */
    public function index(Request $request)
    {
        // Get user ID from request or auth
        $userId = $request->query('user_id') ?? auth()->id();
        
        // Get saving goals
        $goals = SavingGoal::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();
            
        // Calculate progress percentage for each goal
        $formattedGoals = $goals->map(function ($goal) {
            $progressPercentage = 0;
            if ($goal->target_amount > 0) {
                $progressPercentage = ($goal->current_amount / $goal->target_amount) * 100;
            }
            
            // Calculate days remaining
            $daysRemaining = null;
            if ($goal->target_date) {
                $targetDate = Carbon::parse($goal->target_date);
                $daysRemaining = $targetDate->diffInDays(Carbon::now(), false);
                // If days remaining is negative, target date has passed
                $daysRemaining = max(0, $daysRemaining);
            }
            
            return [
                'id' => $goal->id,
                'name' => $goal->name,
                'description' => $goal->description,
                'target_amount' => $goal->target_amount,
                'current_amount' => $goal->current_amount,
                'progress_percentage' => round($progressPercentage, 2),
                'target_date' => $goal->target_date,
                'days_remaining' => $daysRemaining,
                'created_at' => $goal->created_at->format('Y-m-d'),
            ];
        });
        
        return response()->json($formattedGoals);
    }
    
    /**
     * Create a new saving goal
     */
    public function store(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'target_amount' => 'required|numeric|min:1',
            'current_amount' => 'nullable|numeric|min:0',
            'target_date' => 'nullable|date|after:today',
        ]);
        
        // Set user ID
        $validated['user_id'] = auth()->id();
        
        // Default current amount to 0 if not provided
        if (!isset($validated['current_amount'])) {
            $validated['current_amount'] = 0;
        }
        
        // Create the saving goal
        $goal = SavingGoal::create($validated);
        
        return response()->json($goal, 201);
    }
    
    /**
     * Update a saving goal's progress
     */
    public function updateProgress(Request $request, $id)
    {
        // Find the goal
        $goal = SavingGoal::findOrFail($id);
        
        // Check ownership
        if ($goal->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        
        // Validate request
        $validated = $request->validate([
            'amount_added' => 'required|numeric',
        ]);
        
        // Update current amount
        $goal->current_amount += $validated['amount_added'];
        $goal->save();
        
        // Calculate progress percentage
        $progressPercentage = 0;
        if ($goal->target_amount > 0) {
            $progressPercentage = ($goal->current_amount / $goal->target_amount) * 100;
        }
        
        return response()->json([
            'current_amount' => $goal->current_amount,
            'progress_percentage' => round($progressPercentage, 2),
        ]);
    }
    
    /**
     * Get summary statistics for saving goals
     */
    public function summary()
    {
        $userId = auth()->id();
        
        // Get total number of goals
        $totalGoals = SavingGoal::where('user_id', $userId)->count();
        
        // Get goals in progress (not completed)
        $goalsInProgress = SavingGoal::where('user_id', $userId)
            ->whereRaw('current_amount < target_amount')
            ->count();
            
        // Get completed goals
        $completedGoals = SavingGoal::where('user_id', $userId)
            ->whereRaw('current_amount >= target_amount')
            ->count();
            
        // Get total amount saved across all goals
        $totalSaved = SavingGoal::where('user_id', $userId)
            ->sum('current_amount');
            
        // Get total target amount
        $totalTarget = SavingGoal::where('user_id', $userId)
            ->sum('target_amount');
            
        // Calculate overall progress percentage
        $overallProgress = 0;
        if ($totalTarget > 0) {
            $overallProgress = ($totalSaved / $totalTarget) * 100;
        }
        
        return response()->json([
            'total_goals' => $totalGoals,
            'goals_in_progress' => $goalsInProgress,
            'completed_goals' => $completedGoals,
            'total_saved' => $totalSaved,
            'total_target' => $totalTarget,
            'overall_progress' => round($overallProgress, 2),
        ]);
    }
}