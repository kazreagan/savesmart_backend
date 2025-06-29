<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_image',
        'phone_number',
        'account_number',
        'role',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:8',
        'phone_number' => 'nullable|string|max:20',
        'role' => 'required|in:user,admin',
        'status' => 'nullable|in:active,inactive',
        'profile_image' => 'nullable|image|max:2048',
    ];

    /**
 * Generate a unique account number for new users
 *
 * @return string
 */
   public static function generateAccountNumber()
   {
        // Generate a random 10-digit number
        $accountNumber = 'ACC' . mt_rand(100000, 999999);
    
        // Keep generating until we find a unique one
        while (self::where('account_number', $accountNumber)->exists()) {
            $accountNumber = 'ACC' . mt_rand(100000, 999999);
        }
    
        return $accountNumber;
    }
    /**
     * Check if user is admin
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}