<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentRequestFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id'                => User::factory(),
            'amount'                 => fake()->randomFloat(2, 10, 5000),
            'currency'               => fake()->randomElement(['USD', 'EUR', 'GBP', 'JPY', 'BRL']),
            'exchange_rate'          => fake()->randomFloat(6, 0.5, 2.0),
            'amount_eur'             => fake()->randomFloat(2, 10, 5000),
            'description'            => fake()->sentence(),
            'status'                 => 'pending',
            'exchange_rate_source'   => 'https://api.exchangerate-api.com/v4/latest/EUR',
            'exchange_rate_timestamp'=> now(),
        ];
    }
}
