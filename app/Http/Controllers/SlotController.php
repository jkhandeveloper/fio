<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Slot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SlotController extends Controller
{
    public function index()
    {
        $slots = Slot::where('doctor_id', Auth::guard('doctor')->id())
                    ->orderBy('date')
                    ->orderBy('start_time')
                    ->paginate(10);
        
        return view('doctors.slots.index', compact('slots'));
    }

    public function create()
    {
        return view('doctors.slots.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'duration' => 'required|integer|min:5|max:60',
        ]);
        
        $doctorId = Auth::guard('doctor')->id();
        $date = $validated['date'];
        $start = $validated['start_time'];
        $end = $validated['end_time'];
        $duration = $validated['duration'];
        $slotCount = 30;

        // Generate multiple slots
        for ($i = 0; $i < $slotCount; $i++) {
            $slotEnd = date('H:i', strtotime("+$duration minutes", strtotime($start)));
            
            if (strtotime($slotEnd) > strtotime($end)) break;
            
            Slot::create([
                'doctor_id' => $doctorId,
                'date' => $date,
                'start_time' => $start,
                'end_time' => $slotEnd,
            ]);
            
            $start = $slotEnd;
        }

        return redirect()->route('doctor.slots.index')->with('success', 'Slots created successfully');
    }

    public function destroy(Slot $slot)
    {
        if ($slot->doctor_id !== Auth::guard('doctor')->id()) {
            abort(403);
        }

        $slot->delete();
        return back()->with('success', 'Slot deleted successfully');
    }
}