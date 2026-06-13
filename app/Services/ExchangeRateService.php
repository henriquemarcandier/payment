<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class ExchangeRateService
{
    private string $apiUrl;

    public function __construct()
    {
        $this->apiUrl = env('EXCHANGE_RATE_API_URL', 'https://api.exchangerate-api.com/v4/latest/EUR');
    }

    public function getRate(string $targetCurrency): array
    {
        $response = Http::get($this->apiUrl);

        if ($response->failed()) {
            throw new RuntimeException('Failed to fetch exchange rates from API.');
        }

        $data = $response->json();

        if (!isset($data['rates'][$targetCurrency])) {
            throw new RuntimeException("Currency {$targetCurrency} not supported.");
        }

        return [
            'rate'      => $data['rates'][$targetCurrency],
            'source'    => $this->apiUrl,
            'timestamp' => now(),
        ];
    }

    public function convertToEur(float $amount, string $targetCurrency): array
    {
        $rateData = $this->getRate($targetCurrency);

        $amountEur = $amount / $rateData['rate'];

        return [
            'amount_eur'     => round($amountEur, 2),
            'exchange_rate'  => $rateData['rate'],
            'source'         => $rateData['source'],
            'rate_timestamp' => $rateData['timestamp'],
        ];
    }
}
