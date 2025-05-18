<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\StaffController;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Doctor Routes
Route::prefix('doctors')->group(function () {
    Route::get('/', [DoctorController::class, 'index'])->name('doctors.index');
    
    Route::get('/create', [\App\Http\Controllers\DoctorController::class, 'create'])->name('doctors.create');
    Route::get('/{doctor}', [\App\Http\Controllers\DoctorController::class, 'show'])->name('doctors.show');
    Route::get('/{doctor}/edit', [\App\Http\Controllers\DoctorController::class, 'edit'])->name('doctors.edit');
    Route::delete('/{doctor}', [\App\Http\Controllers\DoctorController::class, 'destroy'])->name('doctors.destroy');
    Route::post('', [\App\Http\Controllers\DoctorController::class, 'store'])->name('doctors.store');
    Route::put('/{doctor}', [\App\Http\Controllers\DoctorController::class, 'update'])->name('doctors.update');
});
// Patient Routes
Route::prefix('patients')->group(function () {
    Route::get('/', [PatientController::class, 'index'])->name('patients.index');
    
    Route::get('/create', [\App\Http\Controllers\PatientController::class, 'create'])->name('patients.create');
    Route::get('/{patient}', [\App\Http\Controllers\PatientController::class, 'show'])->name('patients.show');
    Route::get('/{patient}/edit', [\App\Http\Controllers\PatientController::class, 'edit'])->name('patients.edit');
    Route::delete('/{patient}', [\App\Http\Controllers\PatientController::class, 'destroy'])->name('patients.destroy');
    Route::post('', [\App\Http\Controllers\PatientController::class, 'store'])->name('patients.store');
    Route::put('/{patient}', [\App\Http\Controllers\PatientController::class, 'update'])->name('patients.update');
});
// Staff Routes
Route::prefix('staff')->group(function () {
    Route::get('/', [StaffController::class, 'index'])->name('staff.index');
    
    Route::get('/create', [\App\Http\Controllers\StaffController::class, 'create'])->name('staff.create');
    Route::get('/{staff}', [\App\Http\Controllers\StaffController::class, 'show'])->name('staff.show');
    Route::get('/{staff}/edit', [\App\Http\Controllers\StaffController::class, 'edit'])->name('staff.edit');
    Route::delete('/{staff}', [\App\Http\Controllers\StaffController::class, 'destroy'])->name('staff.destroy');
    Route::post('', [\App\Http\Controllers\StaffController::class, 'store'])->name('staff.store');
    Route::put('/{staff}', [\App\Http\Controllers\StaffController::class, 'update'])->name('staff.update');
});
