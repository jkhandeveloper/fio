<?php
// app/Http/Controllers/Doctor/DashboardController.php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Slot;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DoctorDashboardController extends Controller
{
    public function index()
    {
        $doctorId = Auth::guard('doctor')->id();
        
        // Today's appointments
        $todayAppointments = Appointment::with(['patient', 'slot'])
            ->whereHas('slot', function($query) use ($doctorId) {
                $query->where('doctor_id', $doctorId)
                      ->where('date', Carbon::today());
            })
            ->orderBy('created_at', 'desc')
            ->get();

        // Upcoming appointments
        $upcomingAppointments = Appointment::with(['patient', 'slot'])
            ->whereHas('slot', function($query) use ($doctorId) {
                $query->where('doctor_id', $doctorId)
                      ->where('date', '>', Carbon::today());
            })
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Recent slots
        $recentSlots = Slot::where('doctor_id', $doctorId)
            ->where('date', '>=', Carbon::today())
            ->orderBy('date')
            ->orderBy('start_time')
            ->limit(5)
            ->get();

        // Statistics
        $stats = [
            'total_appointments' => Appointment::whereHas('slot', fn($q) => $q->where('doctor_id', $doctorId))->count(),
            'today_appointments' => $todayAppointments->count(),
            'available_slots' => Slot::where('doctor_id', $doctorId)
                                ->where('date', '>=', Carbon::today())
                                ->whereDoesntHave('appointment')
                                ->count(),
        ];

        return view('doctors.dashboard', compact(
            'todayAppointments',
            'upcomingAppointments',
            'recentSlots',
            'stats'
        ));
    }
}