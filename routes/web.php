<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\RentCarController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'registerForm']);
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/verification/{user}/{token}', [AuthController::class, 'verification']);

Route::middleware(['auth', 'verified'])->group(function(){
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/dashboard', [AuthController::class, 'dashboard']);

    Route::get('/cars', [CarController::class, 'index']);
    Route::get('/cars/create', [CarController::class, 'create']);
    Route::post('/cars', [CarController::class, 'store'])->name('cars.store');
    Route::get('/cars/edit/{car}', [CarController::class, 'edit'])->name('cars.edit');
    Route::put('/cars/{car}', [CarController::class, 'update'])->name('cars.update');
    Route::delete('/cars/{car}', [CarController::class, 'destroy'])->name('cars.delete');

    Route::get('/cars/rent/{car}', [RentCarController::class, 'create'])->name('cars.rent.create');
    Route::post('/cars/rent/{car}', [RentCarController::class, 'store'])->name('cars.rent.store');



    Route::get('/rent',[RentalController::class, 'index']);
    // Route::get('/rent/create', [RentalController::class, 'create']);
    Route::get('/rent/create/{car?}', [RentalController::class, 'create'])->name('rent.create');
    Route::post('/rent', [RentalController::class, 'store'])->name('rent.store');
    Route::get('/rent/edit/{rent}', [RentalController::class, 'edit'])->name('rent.edit');
    Route::put('/rent/{rent}', [RentalController::class, 'update'])->name('rent.update');
    Route::delete('/rent/{rent}', [RentalController::class, 'destroy'])->name('rent.delete');

    Route::get('/customers',[CustomerController::class, 'index']);
    Route::get('/customers/create', [CustomerController::class, 'create']);
    Route::post('/customers', [CustomerController::class, 'store'])->name('customer.store');
    Route::get('/customers/edit/{customer}', [CustomerController::class, 'edit'])->name('customer.edit');
    Route::put('/customers/{customer}', [CustomerController::class, 'update'])->name('customer.update');
    Route::delete('/customers/{customer}', [CustomerController::class, 'destroy'])->name('customer.delete');

    Route::get('/logs', [LogController::class, 'index'])->name('logs.index');
});
