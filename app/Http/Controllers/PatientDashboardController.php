<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PatientDashboardController extends Controller
{
    public function index()
    {
        $patientId = Auth::guard('patient')->id();
        
        // Today's appointments
        $todayAppointments = Appointment::with(['slot.doctor'])
            ->where('patient_id', $patientId)
            ->whereHas('slot', function($query) {
                $query->where('date', Carbon::today());
            })
            ->orderBy('created_at', 'desc')
            ->get();

        // Upcoming appointments
        $upcomingAppointments = Appointment::with(['slot.doctor'])
            ->where('patient_id', $patientId)
            ->whereHas('slot', function($query) {
                $query->where('date', '>', Carbon::today());
            })
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Recent doctors
        $recentDoctors = Appointment::with(['slot.doctor'])
            ->where('patient_id', $patientId)
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get()
            ->pluck('slot.doctor')
            ->unique();

        // Statistics
        $stats = [
            'total_appointments' => Appointment::where('patient_id', $patientId)->count(),
            'today_appointments' => $todayAppointments->count(),
            'upcoming_appointments' => Appointment::where('patient_id', $patientId)
                                        ->whereHas('slot', fn($q) => $q->where('date', '>', Carbon::today()))
                                        ->count(),
        ];

        return view('patients.dashboard', compact(
            'todayAppointments',
            'upcomingAppointments',
            'recentDoctors',
            'stats'
        ));
    }
}