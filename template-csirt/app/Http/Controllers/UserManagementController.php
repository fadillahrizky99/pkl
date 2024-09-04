<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profil;
use Illuminate\Http\Request;
use App\Models\ImageProperty;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserManagementController extends Controller
{
    public function index()
    {
        $profileData = Profil::getProfileData();
        return view('dashboard.users.index', array_merge([
            'users' => User::all(),
            'properties' => ImageProperty::where('property', 'Logo')->latest()->get()
        ], $profileData));
    }

    public function edit(User $user)
    {
        $profileData = Profil::getProfileData();
        return view('dashboard.users.edit', array_merge([
            'user' => $user,
            'users' => User::all(),
            'properties' => ImageProperty::where('property', 'Logo')->latest()->get()
        ], $profileData));
    }

    public function update(Request $request, User $user)
    {

        $rules = [
            'name' => 'required|max:255'
        ];

        if($request->username != $user->username) {
            $rules['username'] = ['required', 'min:3', 'max:255', 'unique:users', 'regex:/^([a-z])+?(-|_|.)([a-z])+$/i'];
        }

        if($request->email != $user->email) {
            $rules['email'] = 'required|email:dns|unique:users';
        }

        if (!$user->is_superadmin) {
            $rules['password'] = [
                'required',
                Password::min(8)
                    ->mixedCase()
                    ->letters()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(), 
            ];
        }

        $validatedData = $request->validate($rules);

        if($request->has('is_admin') || $user->is_superadmin){
            $validatedData['is_admin'] = true;
        } else {
            $validatedData['is_admin'] = false;
        }

        if($request->has('password')) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        }
 
        User::where('id', $user->id)->update($validatedData);

        return redirect('/dashboard/users')->with('success', 'User has been updated!');
    }

}
