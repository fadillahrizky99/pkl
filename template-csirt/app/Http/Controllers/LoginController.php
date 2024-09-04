<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Footer;
use App\Models\Category;
use App\Models\File;
use App\Models\Profil;
use App\Models\ImageProperty;
use App\Models\Key;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\ThrottlesLogins;


class LoginController extends Controller
{
    protected $maxAttempts = 2; // Default is 5
    protected $decayMinutes = 1; // Default is 1
    public function index()
    {
        $profileData = Profil::getProfileData();

        return view('login.index', array_merge([
            "includeHero" => false,
            'properties' => ImageProperty::where('property', 'Logo')->latest()->get(),
            'propertiez' => ImageProperty::where('property', 'Banner')->latest()->get(),
        ], $profileData));
    }

    public function authenticate(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if(Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ])){
            Auth::logoutOtherDevices(request('password'));
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        } 
        return back()->with('loginError', 'Login Failed');
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
