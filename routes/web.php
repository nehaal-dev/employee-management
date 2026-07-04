<?php

use App\Http\Controllers\EmployeeProfileController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('admin/employees', [EmployeeProfileController::class, 'adminIndex'])->name('admin.employees.index');
    Route::get('admin/employees/{id}', [EmployeeProfileController::class, 'adminShow'])->name('admin.employees.show');
});

Route::middleware(['auth', 'role:employee'])->group(function () {
    Route::get('employees/create', [EmployeeProfileController::class, 'create'])->name('employees.create');
    Route::post('employees', [EmployeeProfileController::class, 'store'])->name('employees.store');
    Route::get('employees/edit', [EmployeeProfileController::class, 'edit'])->name('employees.edit');
    Route::patch('employees', [EmployeeProfileController::class, 'update'])->name('employees.update');
    Route::get('employees/profile', [EmployeeProfileController::class, 'show'])->name('employees.show');
});

require __DIR__.'/auth.php';