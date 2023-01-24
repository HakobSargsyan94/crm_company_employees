<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeesController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
});

Auth::routes(['register' => false]);

Route::post('company/update/{id}', [CompanyController::class, 'update'])->name('companies.update')->middleware('auth');
Route::post('employees/update/{id}', [EmployeesController::class, 'update'])->name('employees.update')->middleware('auth');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('company', CompanyController::class)->middleware('auth');
Route::resource('employees', EmployeesController::class)->middleware('auth');
Route::get('company/destroy/{id}', [CompanyController::class, 'destroy'])->name('companies.destroy')->middleware('auth');
Route::get('employees/destroy/{id}', [EmployeesController::class, 'destroy'])->name('employees.destroy')->middleware('auth');
