<?php

namespace Tests\Feature;

use App\Models\PaymentRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Laravel\Passport\Passport;
use Tests\TestCase;

class PaymentRequestTest extends TestCase
{
    use RefreshDatabase;

    private User $employee;
    private User $finance;

    protected function setUp(): void
    {
        parent::setUp();

        Http::preventStrayRequests();

        Http::fake([
            'v6.exchangerate-api.com/v6/*' => Http::response([
                'result'           => 'success',
                'base_code'        => 'EUR',
                'conversion_rates' => [
                    'USD' => 1.08,
                    'EUR' => 1,
                    'BRL' => 5.40,
                    'GBP' => 0.86,
                    'JPY' => 162.50,
                ],
                'time_last_update_utc' => '2024-01-01 00:00:00',
            ]),
        ]);

        $this->employee = User::factory()->create([
            'role'     => 'employee',
            'currency' => 'USD',
        ]);

        $this->finance = User::factory()->create([
            'role'     => 'finance',
            'currency' => 'EUR',
        ]);
    }

    public function test_employee_can_create_payment_request(): void
    {
        Passport::actingAs($this->employee);

        $response = $this->postJson('/api/payment-requests', [
            'amount'      => 100.00,
            'currency'    => 'USD',
            'description' => 'Office supplies',
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'id', 'amount', 'currency', 'exchange_rate',
                'amount_eur', 'status', 'exchange_rate_source',
                'exchange_rate_timestamp',
            ]);
    }

    public function test_employee_can_list_own_requests(): void
    {
        PaymentRequest::factory()->count(3)->create([
            'user_id' => $this->employee->id,
        ]);

        Passport::actingAs($this->employee);

        $response = $this->getJson('/api/payment-requests');

        $response->assertOk()
            ->assertJsonCount(3, 'data');
    }

    public function test_finance_can_list_all_requests(): void
    {
        PaymentRequest::factory()->count(2)->create([
            'user_id' => $this->employee->id,
        ]);

        Passport::actingAs($this->finance);

        $response = $this->getJson('/api/payment-requests');

        $response->assertOk()
            ->assertJsonCount(2, 'data');
    }

    public function test_finance_can_filter_by_status(): void
    {
        PaymentRequest::factory()->create([
            'user_id' => $this->employee->id,
            'status'  => 'pending',
        ]);

        PaymentRequest::factory()->create([
            'user_id' => $this->employee->id,
            'status'  => 'approved',
        ]);

        Passport::actingAs($this->finance);

        $response = $this->getJson('/api/payment-requests?status=pending');

        $response->assertOk()
            ->assertJsonCount(1, 'data');
    }

    public function test_finance_can_approve_request(): void
    {
        $paymentRequest = PaymentRequest::factory()->create([
            'user_id' => $this->employee->id,
            'status'  => 'pending',
        ]);

        Passport::actingAs($this->finance);

        $response = $this->putJson("/api/payment-requests/{$paymentRequest->id}", [
            'status' => 'approved',
        ]);

        $response->assertOk()
            ->assertJsonPath('status', 'approved');
    }

    public function test_employee_cannot_approve_request(): void
    {
        $paymentRequest = PaymentRequest::factory()->create([
            'user_id' => $this->employee->id,
            'status'  => 'pending',
        ]);

        Passport::actingAs($this->employee);

        $response = $this->putJson("/api/payment-requests/{$paymentRequest->id}", [
            'status' => 'approved',
        ]);

        $response->assertStatus(403);
    }

    public function test_employee_can_see_own_request_detail(): void
    {
        $paymentRequest = PaymentRequest::factory()->create([
            'user_id' => $this->employee->id,
        ]);

        Passport::actingAs($this->employee);

        $response = $this->getJson("/api/payment-requests/{$paymentRequest->id}");

        $response->assertOk()
            ->assertJsonPath('id', $paymentRequest->id);
    }

    public function test_employee_cannot_see_other_request(): void
    {
        $otherUser = User::factory()->create();
        $paymentRequest = PaymentRequest::factory()->create([
            'user_id' => $otherUser->id,
        ]);

        Passport::actingAs($this->employee);

        $response = $this->getJson("/api/payment-requests/{$paymentRequest->id}");

        $response->assertStatus(403);
    }

    public function test_validation_requires_valid_currency(): void
    {
        Passport::actingAs($this->employee);

        $response = $this->postJson('/api/payment-requests', [
            'amount'      => 100,
            'currency'    => 'INVALID',
            'description' => 'Test',
        ]);

        $response->assertStatus(422);
    }
}
