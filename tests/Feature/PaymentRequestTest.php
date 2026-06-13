<?php

namespace Tests\Feature;

use App\Models\PaymentRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaymentRequestTest extends TestCase
{
    use RefreshDatabase;

    private User $employee;
    private User $finance;
    private string $token;

    protected function setUp(): void
    {
        parent::setUp();

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
        $token = $this->employee->createToken('api-token')->plainTextToken;

        $response = $this->withToken($token)
            ->postJson('/api/payment-requests', [
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

        $token = $this->employee->createToken('api-token')->plainTextToken;

        $response = $this->withToken($token)
            ->getJson('/api/payment-requests');

        $response->assertOk()
            ->assertJsonCount(3, 'data');
    }

    public function test_finance_can_list_all_requests(): void
    {
        PaymentRequest::factory()->count(2)->create([
            'user_id' => $this->employee->id,
        ]);

        $token = $this->finance->createToken('api-token')->plainTextToken;

        $response = $this->withToken($token)
            ->getJson('/api/payment-requests');

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

        $token = $this->finance->createToken('api-token')->plainTextToken;

        $response = $this->withToken($token)
            ->getJson('/api/payment-requests?status=pending');

        $response->assertOk()
            ->assertJsonCount(1, 'data');
    }

    public function test_finance_can_approve_request(): void
    {
        $paymentRequest = PaymentRequest::factory()->create([
            'user_id' => $this->employee->id,
            'status'  => 'pending',
        ]);

        $token = $this->finance->createToken('api-token')->plainTextToken;

        $response = $this->withToken($token)
            ->putJson("/api/payment-requests/{$paymentRequest->id}", [
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

        $token = $this->employee->createToken('api-token')->plainTextToken;

        $response = $this->withToken($token)
            ->putJson("/api/payment-requests/{$paymentRequest->id}", [
                'status' => 'approved',
            ]);

        $response->assertStatus(403);
    }

    public function test_employee_can_see_own_request_detail(): void
    {
        $paymentRequest = PaymentRequest::factory()->create([
            'user_id' => $this->employee->id,
        ]);

        $token = $this->employee->createToken('api-token')->plainTextToken;

        $response = $this->withToken($token)
            ->getJson("/api/payment-requests/{$paymentRequest->id}");

        $response->assertOk()
            ->assertJsonPath('id', $paymentRequest->id);
    }

    public function test_employee_cannot_see_other_request(): void
    {
        $otherUser = User::factory()->create();
        $paymentRequest = PaymentRequest::factory()->create([
            'user_id' => $otherUser->id,
        ]);

        $token = $this->employee->createToken('api-token')->plainTextToken;

        $response = $this->withToken($token)
            ->getJson("/api/payment-requests/{$paymentRequest->id}");

        $response->assertStatus(403);
    }

    public function test_validation_requires_valid_currency(): void
    {
        $token = $this->employee->createToken('api-token')->plainTextToken;

        $response = $this->withToken($token)
            ->postJson('/api/payment-requests', [
                'amount'      => 100,
                'currency'    => 'INVALID',
                'description' => 'Test',
            ]);

        $response->assertStatus(422);
    }
}
