<?php

namespace Tests\Unit;

use App\Console\Commands\ExpirePaymentRequests;
use App\Models\PaymentRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExpirePaymentRequestsTest extends TestCase
{
    use RefreshDatabase;

    public function test_expires_old_pending_requests(): void
    {
        $freshRequest = PaymentRequest::factory()->create([
            'status'     => 'pending',
            'created_at' => now()->subHours(24),
        ]);

        $oldRequest = PaymentRequest::factory()->create([
            'status'     => 'pending',
            'created_at' => now()->subHours(72),
        ]);

        $this->artisan('payments:expire')
            ->assertSuccessful()
            ->expectsOutput('Expired 1 payment request(s).');

        $this->assertEquals('expired', $oldRequest->fresh()->status);
        $this->assertEquals('pending', $freshRequest->fresh()->status);
    }
}
