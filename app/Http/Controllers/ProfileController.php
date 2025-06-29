<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
        ]);
        $user->update($validated);
        return redirect()->route('profile')->with('success', 'Profile updated successfully.');
    }
    
}