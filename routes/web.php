<?php

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


Route::get('/', [\App\Http\Controllers\EmployeeController::class, 'index'])->name('dashboard');
Route::get('add-employees', [\App\Http\Controllers\EmployeeController::class, 'create'])->name('employee.create');
Route::post('add-employees', [\App\Http\Controllers\EmployeeController::class, 'store'])->name('employee.store');
Route::delete('user/{id}', [\App\Http\Controllers\EmployeeController::class, 'destroy'])->name('employee.destroy');
Route::get('employee-datatable', [\App\Http\Controllers\EmployeeController::class, 'employeeTableAjax'])->name('employee.datatable');
Route::post('delete-employee', [\App\Http\Controllers\EmployeeController::class, 'delete'])->name('employee.delete');
Route::post('show-employee', [\App\Http\Controllers\EmployeeController::class, 'employeeDetails'])->name('employee.details');
Route::post('update-employee', [\App\Http\Controllers\EmployeeController::class, 'update'])->name('employee.update');
