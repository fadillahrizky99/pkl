<?php

use App\Models\Post;
use App\Models\Footer;
use App\Models\Profil;
use App\Models\Category;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\FooterController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\DashboardPostController;
use App\Http\Controllers\GuidanceController;
use App\Http\Controllers\ImagePropertyController;
use App\Http\Controllers\KeyController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\HomeController;
use App\Models\File;
use App\Models\Guidance;
use App\Models\ImageProperty;
use App\Models\Key;
use App\Models\Service;
use Spatie\Csp\AddCspHeaders;

Route::get('/', [HomeController::class, 'index'])->name('home')->middleware(Spatie\Csp\AddCspHeaders::class);
Route::get('/profil', [ProfilController::class, 'index1'])->name('profil')->middleware(Spatie\Csp\AddCspHeaders::class);
Route::get('/file', [FileController::class, 'index1'])->middleware(Spatie\Csp\AddCspHeaders::class);
Route::get('/service', [ServiceController::class, 'index1'])->middleware(Spatie\Csp\AddCspHeaders::class);
Route::get('/guidance', [GuidanceController::class, 'index1'])->middleware(Spatie\Csp\AddCspHeaders::class);
Route::resource('/posts', PostController::class)->only(['index', 'show'])->middleware(Spatie\Csp\AddCspHeaders::class);

Route::get('/login-admin', [LoginController::class, 'index'])->name('login')->middleware('white.list','guest',Spatie\Csp\AddCspHeaders::class);
Route::post('/login', [LoginController::class, 'authenticate']);
Route::get('/login/reload-captcha', [LoginController::class, 'reloadCaptcha']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::get('/register', [RegisterController::class, 'index'])->name('register')->middleware('auth', 'admin');
Route::get('/register/showChangePasswordGet', [RegisterController::class, 'showChangePasswordGet'])->middleware(Spatie\Csp\AddCspHeaders::class,'auth');
Route::post('/register/showChangePasswordGet', [RegisterController::class, 'changePasswordUser'])->middleware('auth');
Route::post('/register', [RegisterController::class, 'store']);

Route::get('/dashboard', function(){
    $profileData = Profil::getProfileData();
    return view('dashboard.index', array_merge([
        'properties' => ImageProperty::where('property', 'Logo')->latest()->get(),
        'profils' => Profil::latest()->get(),
    ], $profileData));
})->middleware('auth');
Route::get('/dashboard/posts/checkSlug', [DashboardPostController::class, 'checkSlug'])->middleware('auth');
Route::resource('/dashboard/posts', DashboardPostController::class)->middleware('auth');
Route::get('/dashboard/categories/checkSlug', [AdminCategoryController::class, 'checkSlug'])->middleware('auth');
Route::resource('/dashboard/categories', AdminCategoryController::class)->except('show')->middleware('auth', 'admin');
Route::resource('/dashboard/properties', ImagePropertyController::class)->except('show')->middleware('auth', 'admin'); 
Route::get('/dashboard/profils/', [ProfilController::class, 'editLatest'])->name('profils.editLatest')->middleware('auth', 'admin');
Route::put('/dashboard/profils/{name}', [ProfilController::class, 'update'])->middleware('auth', 'admin');
Route::resource('/dashboard/files', FileController::class)->only(['index', 'create', 'store', 'destroy'])->middleware('auth', 'admin');
Route::resource('/dashboard/users', UserManagementController::class)->only(['index', 'edit', 'update'])->middleware('auth', 'admin');
Route::resource('/dashboard/services', ServiceController::class)->middleware('auth', 'admin');
Route::resource('/dashboard/keys', KeyController::class)->only(['index', 'create', 'store', 'destroy'])->middleware('auth', 'admin');
Route::resource('/dashboard/guidances', GuidanceController::class)->except('show')->middleware('auth', 'admin');
