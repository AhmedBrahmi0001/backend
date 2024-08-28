<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DriverPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $driver;
    public $password;

    /**
     * Create a new message instance.
     */
    public function __construct($driver, $password)
    {
        $this->driver = $driver;
        $this->password = $password;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->view('emails.driver_password')
                    ->with([
                        'driverName' => $this->driver->name,
                        'email' => $this->driver->user->email,
                        'password' => $this->password,
                    ])
                    ->subject('Your Driver Account Details');
    }
}
