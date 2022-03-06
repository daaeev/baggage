<?php

use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminPanelController;
use App\Http\Controllers\crud\UserController;
use App\Http\Controllers\crud\BagController;

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

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/product/check/{id}', [BagController::class, 'productCheck'])->name('product.check');
    Route::get('/product/order/{bag_slug}/form', [SiteController::class, 'orderForm'])->name('product.order.form');
    Route::post('/product/order/create', [BagController::class, 'createOrder'])->name('product.order.create');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [SiteController::class, 'profile'])->name('profile');
});

Auth::routes(['verify' => true]);

Route::middleware(['auth', 'admin'])->group(function () {

    // CRUD routes
    Route::post('/admin/user/role', [UserController::class, 'setRole'])->name('admin.users.role');
    Route::post('/admin/bags/create', [BagController::class, 'create'])->name('admin.bags.create');
    Route::post('/admin/bags/edit', [BagController::class, 'edit'])->name('admin.bags.edit');
    Route::post('/admin/bags/delete', [BagController::class, 'delete'])->name('admin.bags.delete');
    // !CRUD routes

    Route::get('/admin/users', [AdminPanelController::class, 'usersList'])->name('admin.users');

    Route::get('/admin/bags', [AdminPanelController::class, 'bagsList'])->name('admin.bags');
    Route::get('/admin/bags/create/form', [AdminPanelController::class, 'bagCreateForm'])->name('admin.bags.create.form');
    Route::get('/admin/bags/edit/form', [AdminPanelController::class, 'bagEditForm'])->name('admin.bags.edit.form');
});
