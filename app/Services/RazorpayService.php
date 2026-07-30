<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Log;

class RazorpayService
{
    protected string $keyId;
    protected string $keySecret;
    protected bool $isSandbox;

    public function __construct()
    {
        $this->keyId = config('services.razorpay.key', '');
        $this->keySecret = config('services.razorpay.secret', '');

        // Sandbox mode when keys are empty or still set to placeholder values
        $this->isSandbox = empty($this->keyId)
            || empty($this->keySecret)
            || str_starts_with($this->keyId, 'rzp_test_sample');
    }

    /**
     * Check if running in sandbox / demo mode.
     */
    public function isSandboxMode(): bool
    {
        return $this->isSandbox;
    }

    /**
     * Create Razorpay Order via cURL HTTP API.
     * In sandbox mode, returns a mock order that the frontend can use.
     */
    public function createOrder(float $amount, string $receiptId, string $currency = 'INR'): array
    {
        // In sandbox mode, return a demo order immediately
        if ($this->isSandbox) {
            Log::info('RazorpayService: Sandbox mode — generating demo order', [
                'amount' => $amount,
                'receipt' => $receiptId,
            ]);

            return [
                'id' => 'order_demo_' . substr(md5($receiptId . time()), 0, 14),
                'entity' => 'order',
                'amount' => (int) ($amount * 100),
                'amount_paid' => 0,
                'amount_due' => (int) ($amount * 100),
                'currency' => $currency,
                'receipt' => $receiptId,
                'status' => 'created',
                '_sandbox' => true,
            ];
        }

        // Production: call the real Razorpay API
        $url = 'https://api.razorpay.com/v1/orders';

        $data = [
            'amount' => (int) ($amount * 100), // Amount in paise
            'currency' => $currency,
            'receipt' => $receiptId,
            'payment_capture' => 1,
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERPWD, $this->keyId . ':' . $this->keySecret);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($httpCode === 200 && $response) {
            $decoded = json_decode($response, true);
            if ($decoded && isset($decoded['id'])) {
                return $decoded;
            }
        }

        Log::error('RazorpayService: Order creation failed', [
            'http_code' => $httpCode,
            'response' => $response,
            'curl_error' => $curlError,
        ]);

        throw new Exception('Unable to create Razorpay payment order. Please try again later.');
    }

    /**
     * Verify Razorpay Payment Signature.
     * In sandbox mode, accepts any demo payment ID as valid.
     */
    public function verifySignature(string $orderId, string $paymentId, string $signature): bool
    {
        if (empty($paymentId)) {
            return false;
        }

        // In sandbox mode, accept demo payment IDs as verified
        if ($this->isSandbox && str_starts_with($paymentId, 'pay_demo_')) {
            Log::info('RazorpayService: Sandbox payment verified', [
                'order_id' => $orderId,
                'payment_id' => $paymentId,
            ]);
            return true;
        }

        // Production: verify HMAC signature
        if (empty($signature)) {
            return false;
        }

        $generatedSignature = hash_hmac('sha256', $orderId . '|' . $paymentId, $this->keySecret);
        return hash_equals($generatedSignature, $signature);
    }
}
