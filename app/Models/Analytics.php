<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Analytics
 * @package App\Models
 * @version May 2, 2025, 2:46 pm UTC
 *
 * @property integer $user_id
 * @property number $total_savings
 * @property string $last_activity
 */
class Analytics extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'analytics';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'user_id',
        'total_savings',
        'last_activity'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'total_savings' => 'decimal:2',
        'last_activity' => 'date'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_id' => 'required',
        'total_savings' => 'required',
        'last_activity' => 'required'
    ];

    
}
