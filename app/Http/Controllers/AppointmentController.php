<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Slot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\AppointmentConfirmationMail;
use Illuminate\Support\Facades\Mail;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with(['slot.doctor'])
                        ->where('patient_id', Auth::guard('patient')->id())
                        ->orderBy('created_at', 'desc')
                        ->paginate(10);
        
        return view('patients.appointments.index', compact('appointments'));
    }

    public function create()
    {
        $doctors = Doctor::get();
        return view('patients.appointments.create-step1', compact('doctors'));
    }

    public function createStep2(Doctor $doctor)
    {
        $availableSlots = Slot::where('doctor_id', $doctor->id)
                            ->where('date', '>=', now()->format('Y-m-d'))
                            ->whereDoesntHave('appointment')
                            ->orderBy('date')
                            ->orderBy('start_time')
                            ->get();
        
        return view('patients.appointments.create-step2', [
            'doctor' => $doctor,
            'availableSlots' => $availableSlots
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'slot_id' => 'required|exists:slots,id',
            'reason' => 'nullable|string|max:500',
        ]);

        // Verify slot is still available
        $slot = Slot::findOrFail($validated['slot_id']);
        
        if (!$slot->isAvailable()) {
            return back()->with('error', 'This slot is no longer available');
        }

        $appointment = Appointment::create([
            'slot_id' => $validated['slot_id'],
            'patient_id' => Auth::guard('patient')->id(),
            'reason' => $validated['reason'],
        ]);
        Mail::to($appointment->patient->email)
        ->send(new AppointmentConfirmationMail($appointment));
        return redirect()->route('patient.appointments.index')
                         ->with('success', 'Appointment booked successfully');
    }

    public function destroy(Appointment $appointment)
    {
        if ($appointment->patient_id !== Auth::guard('patient')->id()) {
            abort(403);
        }

        $appointment->delete();
        return back()->with('success', 'Appointment cancelled successfully');
    }
}