<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::latest()->paginate(10);
        return view('doctors.index', compact('doctors'));
    }

    public function create()
    {
        return view('doctors.create');
    }

    public function store(Request $request)
    {
        $request->password = Hash::make($request->password);
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:doctors,email',
            'phone' => 'required|string|max:20',
            'specialization' => 'required|string|max:255',
            'license_number' => 'nullable|string|unique:doctors,license_number',
            'address' => 'nullable|string',
            'password' => 'required|string|min:8',
        ]);
        // Doctor::create($request->all());
        Doctor::create([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'specialization' => $request['specialization'],
            'license_number' => $request['license_number'],
            'address' => $request['address'],
            'password' => Hash::make($request['password']),
        ]);

        return redirect()->route('doctors.index')
            ->with('success', 'Doctor created successfully.');
    }

    public function show(Doctor $doctor)
    {
        return view('doctors.show', compact('doctor'));
    }

    public function edit(Doctor $doctor)
    {
        return view('doctors.edit', compact('doctor'));
    }

    public function update(Request $request, Doctor $doctor)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:doctors,email,'.$doctor->id,
            'phone' => 'required|string|max:20',
            'specialization' => 'required|string|max:255',
            'license_number' => 'required|string|unique:doctors,license_number,'.$doctor->id,
            'address' => 'nullable|string',
        ]);

        $doctor->update($request->all());

        return redirect()->route('doctors.index')
            ->with('success', 'Doctor updated successfully');
    }

    public function destroy(Doctor $doctor)
    {
        $doctor->delete();

        return redirect()->route('doctors.index')
            ->with('success', 'Doctor deleted successfully');
    }
}