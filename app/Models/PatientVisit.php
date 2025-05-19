<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientVisit extends Model
{
    protected $fillable = [
        'appointment_id', 'patient_id', 'staff_id', 'checkin_time', 'checkout_time', 'status', 'notes'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function medicalRecord()
    {
        return $this->hasOne(MedicalRecord::class);
    }
}