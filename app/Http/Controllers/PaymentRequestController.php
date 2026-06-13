<?php

namespace App\Http\Controllers;

use App\Models\PaymentRequest;
use App\Services\ExchangeRateService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentRequestController extends Controller
{
    public function __construct(
        protected ExchangeRateService $exchangeRateService
    ) {}

    public function index(Request $request): JsonResponse
    {
        $query = PaymentRequest::with('user');

        if ($request->user()->isFinance()) {
            if ($request->has('status')) {
                $query->where('status', $request->status);
            }
        } else {
            $query->where('user_id', $request->user()->id);
        }

        $requests = $query->latest()->paginate(15);

        return response()->json($requests);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'amount'      => 'required|numeric|min:0.01',
            'currency'    => 'required|string|size:3',
            'description' => 'nullable|string|max:1000',
        ]);

        $conversion = $this->exchangeRateService->convertToEur(
            $validated['amount'],
            strtoupper($validated['currency'])
        );

        $paymentRequest = DB::transaction(function () use ($request, $validated, $conversion) {
            return PaymentRequest::create([
                'user_id'                => $request->user()->id,
                'amount'                 => $validated['amount'],
                'currency'               => strtoupper($validated['currency']),
                'description'            => $validated['description'] ?? null,
                'exchange_rate'          => $conversion['exchange_rate'],
                'amount_eur'             => $conversion['amount_eur'],
                'exchange_rate_source'   => $conversion['source'],
                'exchange_rate_timestamp'=> $conversion['rate_timestamp'],
                'status'                 => 'pending',
            ]);
        });

        return response()->json($paymentRequest->load('user'), 201);
    }

    public function show(Request $request, PaymentRequest $paymentRequest): JsonResponse
    {
        if (!$request->user()->isFinance() && $paymentRequest->user_id !== $request->user()->id) {
            throw new AuthorizationException();
        }

        return response()->json($paymentRequest->load('user', 'approver'));
    }

    public function approve(Request $request, PaymentRequest $paymentRequest): JsonResponse
    {
        if (!$request->user()->isFinance()) {
            throw new AuthorizationException('Only finance users can approve requests.');
        }

        if ($paymentRequest->status !== 'pending') {
            return response()->json([
                'message' => 'Only pending requests can be approved or rejected.',
            ], 422);
        }

        $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        $paymentRequest->update([
            'status'      => $request->status,
            'approved_by' => $request->user()->id,
            'approved_at' => now(),
        ]);

        return response()->json($paymentRequest->load('user', 'approver'));
    }
}
