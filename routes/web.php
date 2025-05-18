<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\Auth\DoctorAuthController;
use App\Http\Controllers\Auth\PatientAuthController;
use App\Http\Controllers\Auth\StaffAuthController;
use App\Http\Controllers\SlotController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DoctorDashboardController;
use App\Http\Controllers\PatientDashboardController;

use Illuminate\Support\Facades\Auth;

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

// Doctor Portal Routes
Route::prefix('doctor-portal')->group(function () {
    Route::get('/', [DoctorAuthController::class, 'showLoginForm'])->name('doctor.login');
    Route::post('/login', [DoctorAuthController::class, 'login'])->name('doctor.login.submit');
    Route::post('/logout', [DoctorAuthController::class, 'logout'])->name('doctor.logout');
    
    // Protected routes
    Route::middleware('auth:doctor')->group(function () {
        Route::get('/dashboard', [DoctorDashboardController::class, 'index'])->name('doctor.dashboard');
        Route::get('/slots', [\App\Http\Controllers\SlotController::class, 'index'])->name('doctor.slots.index');
        Route::get('/create', [\App\Http\Controllers\SlotController::class, 'create'])->name('doctor.slots.create');
        Route::delete('/{doctor}', [\App\Http\Controllers\SlotController::class, 'destroy'])->name('doctor.slots.destroy');
        Route::post('/', [\App\Http\Controllers\SlotController::class, 'store'])->name('doctor.slots.store');
    });
});
// Patient Portal Routes
Route::prefix('patient-portal')->group(function () {
    Route::get('/', [PatientAuthController::class, 'showLoginForm'])->name('patient.login');
    Route::post('/login', [PatientAuthController::class, 'login'])->name('patient.login.submit');
    Route::post('/logout', [PatientAuthController::class, 'logout'])->name('patient.logout');
    
    // Protected routes
    Route::middleware('auth:patient')->group(function () {

        Route::get('/dashboard', [PatientDashboardController::class, 'index'])->name('patient.dashboard');
        
        Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('patient.appointments.create');
        Route::get('/appointments/create/{doctor}', [AppointmentController::class, 'createStep2'])->name('patient.appointments.create-step2');
        Route::post('/appointments', [AppointmentController::class, 'store'])->name('patient.appointments.store');
        Route::delete('/appointments/{appointment}', [AppointmentController::class, 'destroy'])->name('patient.appointments.destroy');
        Route::get('/appointments', [AppointmentController::class, 'index'])->name('patient.appointments.index');
    });
});

// Staff Portal Routes
Route::prefix('staff-portal')->group(function () {
    Route::get('/', [StaffAuthController::class, 'showLoginForm'])->name('staff.login');
    Route::post('/login', [StaffAuthController::class, 'login'])->name('staff.login.submit');
    Route::post('/logout', [StaffAuthController::class, 'logout'])->name('staff.logout');
    
    // Protected routes
    Route::middleware('auth:staff')->group(function () {
        Route::get('/dashboard', function () {
            return view('staff.dashboard');
        })->name('staff.dashboard');
        // other staff routes
    });
});