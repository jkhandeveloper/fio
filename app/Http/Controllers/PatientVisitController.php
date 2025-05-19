<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\PatientVisit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientVisitController extends Controller
{
    // Step 1: Show appointments ready for check-in
    public function index()
    {
        $appointments = Appointment::with(['patient', 'slot.doctor'])
            ->where('visit_status', 'scheduled')
            ->whereHas('slot', function($query) {
                $query->where('date', today());
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('staff.visits.index', compact('appointments'));
    }

    // Step 2: Verify and check-in patient
    public function verify(Appointment $appointment)
    {
        return view('staff.visits.verify', compact('appointment'));
    }

    public function checkIn(Request $request, Appointment $appointment)
    {
        // Create patient visit record
        $visit = PatientVisit::create([
            'appointment_id' => $appointment->id,
            'patient_id' => $appointment->patient_id,
            'staff_id' => Auth::guard('staff')->id(),
            'checkin_time' => now(),
            'status' => 'checked_in'
        ]);

        // Update appointment status
        $appointment->update(['visit_status' => 'checked_in']);

        return redirect()->route('staff.visits.active')
            ->with('success', 'Patient checked in successfully');
    }

    // Step 3: Show active visits
    public function activeVisits()
    {
        $visits = PatientVisit::with(['patient', 'appointment.slot.doctor'])
            ->where('status', '!=', 'checked_out')
            ->orderBy('checkin_time')
            ->paginate(10);

        return view('staff.visits.active', compact('visits'));
    }

    // Step 4: Send to doctor
    public function sendToDoctor(PatientVisit $visit)
    {
        $visit->update(['status' => 'in_treatment']);
        $visit->appointment->update(['visit_status' => 'with_doctor']);

        return back()->with('success', 'Patient sent to doctor');
    }

    // Step 5: Checkout patient
    public function checkOut(PatientVisit $visit)
    {
        $aaa = $visit->update([
            'checkout_time' => now(),
            'status' => 'checked_out'
        ]);
        $bbb = $visit->appointment->update(['status' => 'completed', 'visit_status' => 'completed']);
        return redirect()->route('staff.visits.active')
            ->with('success', 'Patient checked out successfully');
    }

    public function completed()
    {
        $visits = PatientVisit::with(['patient', 'appointment.slot.doctor', 'medicalRecord'])
            ->where('status', 'checked_out')
            ->orderBy('checkout_time', 'desc')
            ->paginate(10);

        return view('staff.visits.completed', compact('visits'));
    }
}