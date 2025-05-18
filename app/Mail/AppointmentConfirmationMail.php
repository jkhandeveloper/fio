<?php


namespace App\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppointmentConfirmationMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

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