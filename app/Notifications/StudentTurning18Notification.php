<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class StudentTurning18Notification extends Notification
{
    protected $student;
    protected $mensaje;

    public function __construct($student, $mensaje)
    {
        $this->student = $student;
        $this->mensaje = $mensaje;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'student_id' => $this->student->id,
            'nombre' => $this->student->first_name . ' ' . $this->student->last_name,
            'mensaje' => $this->mensaje,
            'fecha' => now()
        ];
    }
}