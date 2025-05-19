<?php
// app/Models/Appointment.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = ['slot_id', 'patient_id', 'reason', 'status','visit_status'];
    
    public function slot()
    {
        return $this->belongsTo(Slot::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
    public function visit()
    {
        return $this->hasOne(PatientVisit::class);
    }
}
