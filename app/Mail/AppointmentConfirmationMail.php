<?php


namespace App\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\Appointment;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppointmentConfirmationMail extends Mailable
{
    use SerializesModels;

    public $appointment;

    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    public function build()
    {
        return $this->subject('Appointment Confirmation - ' . config('app.name'))
                    ->view('emails.appointment_confirmation')
                    ->with([
                        'appointment' => $this->appointment,
                    ]);
    }
}