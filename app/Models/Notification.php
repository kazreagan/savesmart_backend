<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Notification
 * @package App\Models
 * @version April 16, 2025, 10:05 pm UTC
 *
 * @property integer|null $user_id
 * @property string $title
 * @property string $message
 * @property string $type
 * @property boolean $is_read
 * @property boolean $is_broadcast
 */
class Notification extends Model
{
    use SoftDeletes;
    use HasFactory;

    public $table = 'notifications';
    
    protected $dates = ['deleted_at'];
    
    public $fillable = [
        'user_id',
        'title',
        'message',
        'type',
        'is_read',
        'is_broadcast'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'title' => 'string',
        'message' => 'string',
        'type' => 'string',
        'is_read' => 'boolean',
        'is_broadcast' => 'boolean'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_id' => 'nullable|integer|exists:users,id',
        'title' => 'required|string',
        'message' => 'required|string',
        'type' => 'required|string',
        'is_read' => 'boolean',
        'is_broadcast' => 'boolean'
    ];
    
    /**
     * Get the user that the notification belongs to
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}