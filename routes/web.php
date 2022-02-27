<?php

use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;
use App\Services\UrlGen;
use App\Http\Controllers\AuthorizationController;

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

Route::get(UrlGen::index(), [SiteController::class, 'index']);
Route::get(UrlGen::about(), [SiteController::class, 'about']);
Route::get(UrlGen::contact(), [SiteController::class, 'contact']);
Route::get(UrlGen::catalog(), [SiteController::class, 'catalog']);
Route::get(UrlGen::newsletter(), [SiteController::class, 'newsletter']);

Route::get(UrlGen::login(), [AuthorizationController::class, 'login']);
Route::get(UrlGen::register(), [AuthorizationController::class, 'register']);
