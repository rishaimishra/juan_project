<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Spatie\Async\Pool;
use Illuminate\Support\Facades\Log; // Add this

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $emailAddresses;
    protected $loginUrl;
    protected $emailContent;
    protected $text_email_asunto_invitacion_oct; // Add this line

    // ... other variables

    public function __construct($emailAddresses, $loginUrl, $emailContent, $text_email_asunto_invitacion_oct)
    {
        $this->emailAddresses = $emailAddresses;
        $this->loginUrl = $loginUrl;
        $this->emailContent = $emailContent;
        $this->text_email_asunto_invitacion_oct = $text_email_asunto_invitacion_oct;
        // ...
    }

    public function handle()
    {
        foreach ($this->emailAddresses as $email) {
            $pool = Pool::create();
            // ***Crucially, pass $email to the closure using 'use ($email)'***
            $pool->add(function () use ($email) {  // <-- Corrected line
                try {
                    Mail::send([], [], function ($message) use ($email) { // Pass $email to this closure too
                        $message->to($email)
                            ->subject($this->text_email_asunto_invitacion_oct)
                            ->setBody($this->emailContent, 'text/plain');
                    });
                    Log::info("Email sent successfully to: " . $email);
                } catch (\Exception $e) {
                    Log::error("Error sending email to " . $email . ": " . $e->getMessage());
                }
            });

            $pool->wait();
        }
    }
}
