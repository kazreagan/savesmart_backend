<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Saving
 * @package App\Models
 * @version May 2, 2025, 2:38 pm UTC
 *
 * @property string $name
 * @property number $target_amount
 * @property number $current_amount
 * @property string $target_date
 * @property string $description
 * @property integer $user_id
 */
class Saving extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'savings';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'target_amount',
        'current_amount',
        'target_date',
        'description',
        'user_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'target_amount' => 'decimal:2',
        'current_amount' => 'decimal:2',
        'target_date' => 'date',
        'description' => 'string',
        'user_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'target_amount' => 'required|numeric',
        'current_amount' => 'required|numeric',
        'target_date' => 'required',
        'user_id' => 'required'
    ];

    
}
