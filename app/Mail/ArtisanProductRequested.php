<?php 
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ArtisanProductRequested extends Mailable
{
    use Queueable, SerializesModels;

    public $productRequest;

    public function __construct($productRequest)
    {
        $this->productRequest = $productRequest;
    }

    public function build()
    {
        return $this->subject('Ombi Jipya la Bidhaa - Asili Yetu Hub')
                    ->view('emails.artisan-product-requested');
    }
}