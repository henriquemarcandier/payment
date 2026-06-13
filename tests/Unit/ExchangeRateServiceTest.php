<?php

namespace Tests\Unit;

use App\Services\ExchangeRateService;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ExchangeRateServiceTest extends TestCase
{
    public function test_returns_rate_for_valid_currency(): void
    {
        Http::fake([
            'v6.exchangerate-api.com/v6/*' => Http::response([
                'result'           => 'success',
                'base_code'        => 'EUR',
                'conversion_rates' => ['USD' => 1.08, 'EUR' => 1],
                'time_last_update_utc' => '2024-01-01 00:00:00',
            ]),
        ]);

        $service = new ExchangeRateService;
        $result = $service->getRate('USD');

        $this->assertArrayHasKey('rate', $result);
        $this->assertEquals(1.08, $result['rate']);
        $this->assertArrayHasKey('source', $result);
        $this->assertArrayHasKey('timestamp', $result);
    }

    public function test_throws_exception_for_invalid_currency(): void
    {
        Http::fake([
            'v6.exchangerate-api.com/v6/*' => Http::response([
                'result'           => 'success',
                'base_code'        => 'EUR',
                'conversion_rates' => ['USD' => 1.08, 'EUR' => 1],
            ]),
        ]);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Currency XYZ not supported.');

        $service = new ExchangeRateService;
        $service->getRate('XYZ');
    }
}
