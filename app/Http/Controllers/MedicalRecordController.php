<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\MedicalRecord;
use App\Models\PatientVisit;
use Illuminate\Http\Request;

class MedicalRecordController extends Controller
{
    public function create(PatientVisit $visit)
    {
        $doctors = Doctor::get(); // Get list of active doctors
        return view('staff.medical_records.create', compact('visit', 'doctors'));
    }

    public function store(Request $request, PatientVisit $visit)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'diagnosis' => 'required|string',
            'treatment' => 'required|string',
            'prescription' => 'nullable|string',
            'notes' => 'nullable|string'
        ]);

        MedicalRecord::create([
            'patient_visit_id' => $visit->id,
            'doctor_id' => $request->doctor_id,
            'diagnosis' => $request->diagnosis,
            'treatment' => $request->treatment,
            'prescription' => $request->prescription,
            'notes' => $request->notes
        ]);

        return redirect()->route('staff.visits.active')
            ->with('success', 'Medical record added successfully');
    }

    public function index(Request $request)
{
    $records = MedicalRecord::with(['patientVisit.patient', 'doctor'])
        ->whereHas('patientVisit')
        ->orderBy('created_at', 'desc')
        ->paginate(10);

    return view('staff.medical_records.index', compact('records'));
}

public function show(MedicalRecord $record)
{
    if (!$record->patientVisit) {
        abort(404, 'Associated visit not found');
    }

    return view('staff.medical_records.show', compact('record'));
}
}