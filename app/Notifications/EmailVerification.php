<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmailVerification extends Notification
{
    use Queueable;

    public $record;
    public $grade;
     
    public function __construct($record, $grade) {
        $this->record = $record;
        $this->grade = $grade;
    }
    
    public function via($notifiable)
    {
        return ['mail'];
    }
    
    public function toMail($notifiable)
    {
        $fullname = $this->record->first_name.' '.$this->record->middle_name.' '.$this->record->last_name;
        $guardian = $this->record->guardian_first_name.' '.$this->record->guardian_middle_name.' '.$this->record->guardian_last_name;
        return (new MailMessage)
                    ->line("Fullname: " . $fullname)
                    ->line("Address: " . $this->record->current_address)
                    ->line("Contact No.: " . $this->record->contact_number)
                    ->line("Grade Level/Course-Level: " . $this->grade)
                    ->line("Parent/Guardian: " . $guardian)
                    ->line('Your Reference No. is ' . $this->record->reference_number);
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
