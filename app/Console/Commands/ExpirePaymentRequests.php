<?php

namespace App\Console\Commands;

use App\Models\PaymentRequest;
use Illuminate\Console\Command;

class ExpirePaymentRequests extends Command
{
    protected $signature = 'payments:expire';
    protected $description = 'Expire payment requests pending for more than 48 hours';

    public function handle(): void
    {
        $expired = PaymentRequest::where('status', 'pending')
            ->where('created_at', '<', now()->subHours(48))
            ->update(['status' => 'expired']);

        $this->info("Expired {$expired} payment request(s).");
    }
}
