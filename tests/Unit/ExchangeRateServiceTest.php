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
            'api.exchangerate-api.com/*' => Http::response([
                'rates' => ['USD' => 1.08],
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
            'api.exchangerate-api.com/*' => Http::response([
                'rates' => ['USD' => 1.08],
            ]),
        ]);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Currency XYZ not supported.');

        $service = new ExchangeRateService;
        $service->getRate('XYZ');
    }
}
