<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    public function index()
    {
        $staff = Staff::latest()->paginate(10);
        return view('staff.index', compact('staff'));
    }

    public function create()
    {
        return view('staff.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:staff,email',
            'phone' => 'required|string|max:20',
            'position' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'salary' => 'nullable|numeric',
            'hire_date' => 'required|date',
        ]);

        // Staff::create($request->all());
        Staff::create([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'position' => $request['position'],
            'department' => $request['department'],
            'salary' => $request['salary'],
            'hire_date' => $request['hire_date'],
            'password' => Hash::make($request['password']),
        ]);

        return redirect()->route('staff.index')
            ->with('success', 'Staff member created successfully.');
    }

    public function show(Staff $staff)
    {
        return view('staff.show', compact('staff'));
    }

    public function edit(Staff $staff)
    {
        return view('staff.edit', compact('staff'));
    }

    public function update(Request $request, Staff $staff)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:staff,email,'.$staff->id,
            'phone' => 'required|string|max:20',
            'position' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'salary' => 'nullable|numeric',
            'hire_date' => 'required|date',
        ]);

        $staff->update($request->all());

        return redirect()->route('staff.index')
            ->with('success', 'Staff member updated successfully');
    }

    public function destroy(Staff $staff)
    {
        $staff->delete();

        return redirect()->route('staff.index')
            ->with('success', 'Staff member deleted successfully');
    }
}