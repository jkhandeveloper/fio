<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    protected $fillable = [
        'patient_visit_id', 'doctor_id', 'diagnosis', 'treatment', 'prescription', 'notes'
    ];

    public function patientVisit()
    {
        return $this->belongsTo(PatientVisit::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}