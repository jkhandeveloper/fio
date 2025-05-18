<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PatientController extends Controller
{
    public function index()
    {
        $patients = Patient::latest()->paginate(10);
        return view('patients.index', compact('patients'));
    }

    public function create()
    {
        return view('patients.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|string|in:male,female,other',
            'email' => 'required|email|unique:patients,email',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string',
            'medical_history' => 'nullable|string',
            'allergies' => 'nullable|string',
            'password' => 'required|string|min:8',
        ]);

        // Patient::create($request->all());
        Patient::create([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'date_of_birth' => $request['date_of_birth'],
            'license_number' => $request['license_number'],
            'gender' => $request['gender'],
            'medical_history' => $request['medical_history'],
            'allergies' => $request['allergies'],
            'address' => $request['address'],
            'password' => Hash::make($request['password']),
        ]);

        return redirect()->route('patients.index')
            ->with('success', 'Patient created successfully.');
    }

    public function show(Patient $patient)
    {
        return view('patients.show', compact('patient'));
    }

    public function edit(Patient $patient)
    {
        return view('patients.edit', compact('patient'));
    }

    public function update(Request $request, Patient $patient)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|string|in:male,female,other',
            'email' => 'required|email|unique:patients,email,'.$patient->id,
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string',
            'medical_history' => 'nullable|string',
            'allergies' => 'nullable|string',
        ]);

        $patient->update($request->all());

        return redirect()->route('patients.index')
            ->with('success', 'Patient updated successfully');
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();

        return redirect()->route('patients.index')
            ->with('success', 'Patient deleted successfully');
    }
}