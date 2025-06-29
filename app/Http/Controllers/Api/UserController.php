<?php
// app/Http/Controllers/Api/UserController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;

class UserController extends Controller
{
    public function activeUsers()
    {
        $activeUsers = User::where('last_login_at', '>=', Carbon::now()->subDays(30))
            ->select('id', 'name', 'email', 'last_login_at')
            ->get();
            
        return response()->json($activeUsers);
    }
}