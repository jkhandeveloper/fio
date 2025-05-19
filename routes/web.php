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
use App\Http\Controllers\PatientVisitController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\StaffDashboardController;
;


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
Route::middleware('auth:web')->prefix('doctors')->group(function () {
    Route::get('/', [DoctorController::class, 'index'])->name('doctors.index');
    
    Route::get('/create', [DoctorController::class, 'create'])->name('doctors.create');
    Route::get('/{doctor}', [DoctorController::class, 'show'])->name('doctors.show');
    Route::get('/{doctor}/edit', [DoctorController::class, 'edit'])->name('doctors.edit');
    Route::delete('/{doctor}', [DoctorController::class, 'destroy'])->name('doctors.destroy');
    Route::post('', [DoctorController::class, 'store'])->name('doctors.store');
    Route::put('/{doctor}', [DoctorController::class, 'update'])->name('doctors.update');
});
// Patient Routes
Route::middleware('auth:web')->prefix('patients')->group(function () {
    Route::get('/', [PatientController::class, 'index'])->name('patients.index');
    
    Route::get('/create', [PatientController::class, 'create'])->name('patients.create');
    Route::get('/{patient}', [PatientController::class, 'show'])->name('patients.show');
    Route::get('/{patient}/edit', [PatientController::class, 'edit'])->name('patients.edit');
    Route::delete('/{patient}', [PatientController::class, 'destroy'])->name('patients.destroy');
    Route::post('', [PatientController::class, 'store'])->name('patients.store');
    Route::put('/{patient}', [PatientController::class, 'update'])->name('patients.update');
});
// Staff Routes
Route::middleware('auth:web')->prefix('staff')->group(function () {
    Route::get('/', [StaffController::class, 'index'])->name('staff.index');
    
    Route::get('/create', [StaffController::class, 'create'])->name('staff.create');
    Route::get('/{staff}', [StaffController::class, 'show'])->name('staff.show');
    Route::get('/{staff}/edit', [StaffController::class, 'edit'])->name('staff.edit');
    Route::delete('/{staff}', [StaffController::class, 'destroy'])->name('staff.destroy');
    Route::post('', [StaffController::class, 'store'])->name('staff.store');
    Route::put('/{staff}', [StaffController::class, 'update'])->name('staff.update');
});

// Doctor Portal Routes
Route::prefix('doctor-portal')->group(function () {
    Route::get('/', [DoctorAuthController::class, 'showLoginForm'])->name('doctor.login');
    Route::post('/login', [DoctorAuthController::class, 'login'])->name('doctor.login.submit');
    Route::post('/logout', [DoctorAuthController::class, 'logout'])->name('doctor.logout');
    
    // Protected routes
    Route::middleware('auth:doctor')->group(function () {
        Route::get('/dashboard', [DoctorDashboardController::class, 'index'])->name('doctor.dashboard');
        Route::get('/slots', [SlotController::class, 'index'])->name('doctor.slots.index');
        Route::get('/create', [SlotController::class, 'create'])->name('doctor.slots.create');
        Route::delete('/{doctor}', [SlotController::class, 'destroy'])->name('doctor.slots.destroy');
        Route::post('/', [SlotController::class, 'store'])->name('doctor.slots.store');
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
        Route::get('/dashboard', [StaffDashboardController::class, 'index'])->name('staff.dashboard');
        
       // Visit management
    Route::get('/visits', [PatientVisitController::class, 'index'])->name('staff.visits.index');
    Route::get('/visits/{appointment}/verify', [PatientVisitController::class, 'verify'])->name('staff.visits.verify');
    Route::post('/visits/{appointment}/checkin', [PatientVisitController::class, 'checkIn'])->name('staff.visits.checkin');
    Route::get('/visits/active', [PatientVisitController::class, 'activeVisits'])->name('staff.visits.active');
    Route::get('/visits/{visit}/send-to-doctor', [PatientVisitController::class, 'sendToDoctor'])
    ->name('staff.visits.send-to-doctor');
    Route::get('/visits/{visit}/checkout', [PatientVisitController::class, 'checkOut'])->name('staff.visits.checkout');
    Route::get('/visits/completed', [PatientVisitController::class, 'completed'])->name('staff.visits.completed');
    
    // Medical records
    Route::get('/visits/{visit}/medical-records/create', [MedicalRecordController::class, 'create'])->name('staff.medical-records.create');
    Route::post('/visits/{visit}/medical-records', [MedicalRecordController::class, 'store'])->name('staff.medical-records.store');
    Route::get('/medical-records', [MedicalRecordController::class, 'index'])->name('staff.medical-records.index');
    Route::get('/medical-records/{record}', [MedicalRecordController::class, 'show'])->name('staff.medical-records.show');
    });
});