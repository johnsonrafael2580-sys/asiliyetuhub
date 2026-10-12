<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

   
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    
    public function build()
    {
        $subject = $this->data['title'] ?? 'Notification from AsiliYetuHub';
        return $this->subject($subject)
                    ->view('emails.notification')
                    ->with(['data' => $this->data]);
    }
}
