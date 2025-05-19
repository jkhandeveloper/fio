<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\PatientVisit;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class StaffDashboardController extends Controller
{
    public function index()
    {
        $staffId = Auth::guard('staff')->id();
        $today = Carbon::today();

        // Today's appointments
        $todaysAppointments = Appointment::with(['patient', 'slot.doctor'])
            ->whereHas('slot', function($query) use ($today) {
                $query->where('date', $today);
            })
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Active visits (checked in but not checked out)
        $activeVisits = PatientVisit::with(['patient', 'appointment.slot.doctor'])
            ->where('staff_id', $staffId)
            ->whereDate('checkin_time', $today)
            ->whereNull('checkout_time')
            ->orderBy('checkin_time')
            ->limit(5)
            ->get();

        // Recent completed visits
        $recentCompleted = PatientVisit::with(['patient', 'appointment.slot.doctor'])
            ->where('staff_id', $staffId)
            ->whereDate('checkin_time', $today)
            ->whereNotNull('checkout_time')
            ->orderBy('checkout_time', 'desc')
            ->limit(5)
            ->get();

        // Counts for dashboard cards
        $counts = [
            'todays_appointments' => Appointment::whereHas('slot', fn($q) => $q->where('date', $today))->count(),
            'active_visits' => PatientVisit::where('staff_id', $staffId)
                                ->whereDate('checkin_time', $today)
                                ->whereNull('checkout_time')
                                ->count(),
            'completed_visits' => PatientVisit::where('staff_id', $staffId)
                                ->whereDate('checkin_time', $today)
                                ->whereNotNull('checkout_time')
                                ->count(),
        ];

        return view('staff.dashboard', compact(
            'todaysAppointments',
            'activeVisits',
            'recentCompleted',
            'counts'
        ));
    }
}