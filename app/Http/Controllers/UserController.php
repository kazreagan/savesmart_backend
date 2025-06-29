<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::latest()->paginate(10);
        
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(User::$rules);
        
        $input = $request->all();
        
        // Hash the password
        $input['password'] = Hash::make($input['password']);
        
        // Generate account number for new user
        $input['account_number'] = User::generateAccountNumber();
        
        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            $input['profile_image'] = $this->uploadImage($request->file('profile_image'));
        }
        
        User::create($input);
        
        return redirect()->route('admin.users.index')
            ->with('success', __('User created successfully'));
    }

    /**
     * Display the specified user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        // Modify validation rules for update
        $rules = User::$rules;
        $rules['email'] = 'required|email|unique:users,email,' . $id;
        $rules['password'] = 'nullable|string|min:8'; // Password is optional during update
        
        $request->validate($rules);
        
        $input = $request->all();
        
        // Only update password if provided
        if (empty($input['password'])) {
            unset($input['password']);
        } else {
            $input['password'] = Hash::make($input['password']);
        }
        
        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            // Delete previous image if exists
            if ($user->profile_image) {
                Storage::delete('public/profile_images/' . basename($user->profile_image));
            }
            
            $input['profile_image'] = $this->uploadImage($request->file('profile_image'));
        }
        
        $user->update($input);
        
        return redirect()->route('admin.users.index')
            ->with('success', __('User updated successfully'));
    }

    /**
     * Remove the specified user from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Do not allow deleting own account
        if (auth()->id() == $id) {
            return redirect()->route('admin.users.index')
                ->with('error', __('You cannot delete your own account'));
        }
        
        // Delete user's profile image if exists
        if ($user->profile_image) {
            Storage::delete('public/profile_images/' . basename($user->profile_image));
        }
        
        $user->delete();
        
        return redirect()->route('admin.users.index')
            ->with('success', __('User deleted successfully'));
    }
    
    /**
     * Upload profile image and return path
     *
     * @param  \Illuminate\Http\UploadedFile  $file
     * @return string
     */
    private function uploadImage($file)
    {
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('public/profile_images', $filename);
        
        return asset('storage/profile_images/' . $filename);
    }
}