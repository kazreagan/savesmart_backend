<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Settings
 * @package App\Models
 * @version May 2, 2025, 2:47 pm UTC
 *
 * @property string $key
 * @property string $value
 */
class Settings extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'settings';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'key',
        'value'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'key' => 'string',
        'value' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'key' => 'required|unique:settings',
        'value' => 'required'
    ];

    
}
