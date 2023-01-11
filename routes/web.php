<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Auth\LoginController;
use \App\Http\Controllers\Auth\ForgotPasswordController;
use \App\Http\Controllers\UserController;
use \App\Http\Controllers\DashboardController;
use \App\Http\Controllers\GejalaController;
use \App\Http\Controllers\PenyakitController;
use \App\Http\Controllers\HasilController;
use \App\Http\Controllers\Main\TestController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/login',  [LoginController::class, 'index'])->name('login');
Route::post('/login',  [LoginController::class, 'login']); 

Route::get('/sosmed/{param}',  [LoginController::class, 'sosmed']);
Route::get('/session/facebook/callback', [LoginController::class, 'facebook_callback']); 
Route::get('/session/google/callback', [LoginController::class, 'google_callback']); 

Route::get('/forgot-password',  [ForgotPasswordController::class, 'index']);
Route::post('/forgot-password',  [ForgotPasswordController::class, 'send_email']); 

Route::middleware(['auth'])->group(function () {
     
    Route::get('/',  [DashboardController::class, 'index'])->name('home');
    Route::get('/dashboard',  [DashboardController::class, 'index']);
   
    Route::post('/user/dt',  [UserController::class, 'dt']);
    Route::resource('/user',  UserController::class);

    Route::post('/gejala/dt',  [GejalaController::class, 'dt']);
    Route::resource('/gejala',  GejalaController::class);

    Route::post('/penyakit/dt',  [PenyakitController::class, 'dt']);
    Route::resource('/penyakit',  PenyakitController::class);
    Route::post('/penyakit/validate-gejala',  [PenyakitController::class, 'validate_gejala']);
    Route::get('/penyakit/add-from/select2-gejala',  [PenyakitController::class, 'select2_gejala']);

    Route::prefix('/test')->group(function () {
        Route::get('/', [TestController::class, 'step_one'])->name('test');
        Route::post('/', [TestController::class, 'post_step_one']); 

        Route::get('/detail/{id}', [TestController::class, 'detail']);
    }); 

    Route::post('/hasil/dt',  [HasilController::class, 'dt']);
    Route::resource('/hasil',  HasilController::class);

    Route::get('/logout',  [LoginController::class, 'logout'])->name('logout');
});