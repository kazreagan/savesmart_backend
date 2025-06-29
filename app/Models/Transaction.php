<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Transaction
 * @package App\Models
 * @version April 16, 2025, 10:02 pm UTC
 *
 * @property integer $user_id
 * @property integer $goal_id
 * @property number $amount
 * @property string $description
 * @property string $transaction_type
 */
class Transaction extends Model
{
    use SoftDeletes;
    use HasFactory;

    public $table = 'transactions';
    
    protected $dates = ['deleted_at'];

    public $fillable = [
        'user_id',
        'goal_id',
        'amount',
        'description',
        'transaction_type'  // Added this field
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'goal_id' => 'integer',
        'amount' => 'decimal:2',
        'description' => 'string',
        'transaction_type' => 'string'  // Added this field
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_id' => 'required|integer|exists:users,id',
        'goal_id' => 'required|integer|exists:saving_goals,id',
        'amount' => 'required|numeric',
        'description' => 'required|string',
        'transaction_type' => 'required|string|in:income,expense,withdrawal,deposit,transfer,savings'  // Added this field with validation
    ];
    
    /**
     * Get the user that owns the transaction.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Get the saving goal that the transaction belongs to.
     */
    public function savingGoal()
    {
        return $this->belongsTo(SavingGoal::class, 'goal_id');
    }
}