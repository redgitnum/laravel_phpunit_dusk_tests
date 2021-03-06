<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Models\Product;

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

Route::get('/', function () {
    return view('home');
})->middleware('guest');

Route::get('/dashboard', function () {
    return view('dashboard', [
        'products' => Product::all()
    ]);
})->middleware(['auth'])->name('dashboard');

Route::post('/dashboard/add', [ProductController::class, 'store'])->middleware('auth')->name('dashboard.add');
Route::delete('/dashboard/delete', [ProductController::class, 'delete'])->middleware('auth')->name('dashboard.delete');

require __DIR__.'/auth.php';
