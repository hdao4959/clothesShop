<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Mail\OrderSuccess;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use PhpParser\Node\Stmt\TryCatch;

class SendMail implements ShouldQueue
{
    use InteractsWithQueue;
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderCreated $event): void
    {

        try {
            $dataUser = $event->dataUser;
            $dataOrder = $event->dataOrder;

            
            Mail::mailer()->to($dataUser['email'])
                ->send(new OrderSuccess($dataUser, $dataOrder));
                Log::info('Email sent successfully to ' . $dataUser['email']);
        } catch (\Exception $e) {
            Log::error('Error sending email: ' . $e->getMessage());
            throw $e; // Re-throw the exception to mark the job as failed
        }
    }
}
