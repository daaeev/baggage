<?php

use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;
use App\Services\UrlGen;
use App\Http\Controllers\AuthorizationController;
use App\Http\Controllers\AdminPanelController;

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

Route::get('/', [SiteController::class, 'index'])->name('home');
Route::get('/about', [SiteController::class, 'about'])->name('about');
Route::get('/contact', [SiteController::class, 'contact'])->name('contact');
Route::get('/catalog', [SiteController::class, 'catalog'])->name('catalog');
Route::get('/newsletter', [SiteController::class, 'newsletter'])->name('newsletter');
Route::get('/catalog/{bag:slug}', [SiteController::class, 'single'])->name('single');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [SiteController::class, 'profile'])->name('profile');
});

Auth::routes(['verify' => true]);

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/users', [AdminPanelController::class, 'usersList'])->name('admin.users');
    Route::get('/admin/user/role', [AdminPanelController::class, 'setRole'])->name('admin.users.role');

    Route::get('/admin/bags', [AdminPanelController::class, 'bagsList'])->name('admin.bags');
});
