<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MakerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UnitController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// AppServiceProvider.phpに記載
// Inertia::share([
//     'userRole' => function(){
//         return Auth::check() ? Auth::user()->getRoleNames() : [];
//     },
//     'flashMessage' => [
//         'message' => Session::get('message'),
//     ],
// ]);

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
});

Route::middleware(['auth'])->group(function(){

    //role:User
    Route::middleware('role:User')->group(function(){
        Route::get('/dashboard',function(){
            return Inertia::render('User/Dashboard');
        })->name('user.dashboard');

        //ここからUserのControllerを書く
    });

    //role:Admin
    Route::prefix('admin')->middleware('role:Admin')->group(function(){
        Route::get('/dashboard',function(){
            return Inertia::render('Admin/Dashboard');
        })->name('admin.dashboard');

        //ここからAdminのControllerを書く
        Route::resource('units',UnitController::class);
        Route::resource('categories',CategoryController::class);
        Route::resource('makers',MakerController::class);
    });

    //role:Super Admin
    Route::prefix('superadmin')->middleware('role:Super Admin')->group(function(){
        Route::get('/dashboard',function(){
            return Inertia::render('SuperAdmin/Dashboard');
        })->name('superadmin.dashboard');

        //ここからSuperAdminのcontrollerを書く
    });
});



//Route::get('/dashboard', function () {
//    return Inertia::render('Dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
