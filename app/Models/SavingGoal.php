<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

/**
 * Class SavingGoal
 * @package App\Models
 * @version April 16, 2025, 9:56 pm UTC
 *
 * @property integer $user_id
 * @property number $target_amount
 * @property number $current_amount
 * @property string $title
 * @property string $description
 * @property string $deadline
 * @property boolean $is_completed
 */
class SavingGoal extends Model
{
    use SoftDeletes;
    use HasFactory;

    public $table = 'saving_goals';
    
    protected $dates = ['deleted_at', 'deadline'];
    
    public $fillable = [
        'user_id',
        'title',
        'description',
        'target_amount',
        'current_amount',
        'deadline',
        'is_completed'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'title' => 'string',
        'description' => 'string',
        'target_amount' => 'decimal:2',
        'current_amount' => 'decimal:2',
        'deadline' => 'date',
        'is_completed' => 'boolean'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_id' => 'required|exists:users,id',
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'target_amount' => 'required|numeric|min:0',
        'current_amount' => 'nullable|numeric|min:0',
        'deadline' => 'required|date|after:today',
        'is_completed' => 'boolean'
    ];

    /**
     * Get the user that owns the saving goal.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Calculate percentage of goal completion
     * 
     * @return float
     */
    public function getCompletionPercentageAttribute()
    {
        if ($this->target_amount <= 0) {
            return 0;
        }
        
        return min(100, round(($this->current_amount / $this->target_amount) * 100, 2));
    }

    /**
     * Get days remaining until deadline
     * 
     * @return int
     */
    public function getDaysRemainingAttribute()
    {
        $now = now();
        if ($now->gt($this->deadline)) {
            return 0;
        }
        
        return $now->diffInDays($this->deadline);
    }
}