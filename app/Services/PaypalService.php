<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaypalService
{
    protected $clientId;
    protected $secret;
    protected $baseUrl;

    public function __construct()
    {
        $settings = Setting::whereIn('key', ['paypal_client_id', 'paypal_secret', 'paypal_mode'])->pluck('value', 'key');
        
        $this->clientId = $settings['paypal_client_id'] ?? env('PAYPAL_CLIENT_ID');
        $this->secret = $settings['paypal_secret'] ?? env('PAYPAL_SECRET');
        $mode = $settings['paypal_mode'] ?? 'sandbox';
        
        $this->baseUrl = ($mode === 'live') 
            ? 'https://api-m.paypal.com' 
            : 'https://api-m.sandbox.paypal.com';
    }

    protected function getAccessToken()
    {
        $response = Http::withoutVerifying()
            ->asForm()
            ->withBasicAuth($this->clientId, $this->secret)
            ->post("{$this->baseUrl}/v1/oauth2/token", [
                'grant_type' => 'client_credentials',
            ]);

        if ($response->failed()) {
            Log::error('PayPal Auth Failed: ' . $response->body());
            return null;
        }

        return $response->json()['access_token'];
    }

    public function createOrder($amount, $orderNumber)
    {
        $accessToken = $this->getAccessToken();
        if (!$accessToken) return null;

        $response = Http::withoutVerifying()
            ->withToken($accessToken)
            ->post("{$this->baseUrl}/v2/checkout/orders", [
                'intent' => 'CAPTURE',
                'purchase_units' => [
                    [
                        'reference_id' => $orderNumber,
                        'amount' => [
                            'currency_code' => 'USD',
                            'value' => number_format($amount, 2, '.', ''),
                        ],
                    ],
                ],
                'application_context' => [
                    'return_url' => route('paypal.success'),
                    'cancel_url' => route('paypal.cancel'),
                ],
            ]);

        if ($response->failed()) {
            Log::error('PayPal Order Creation Failed: ' . $response->body());
            return null;
        }

        return $response->json();
    }

    public function captureOrder($paypalOrderId)
    {
        $accessToken = $this->getAccessToken();
        if (!$accessToken) return null;

        $response = Http::withoutVerifying()
            ->withToken($accessToken)
            ->post("{$this->baseUrl}/v2/checkout/orders/{$paypalOrderId}/capture");

        if ($response->failed()) {
            Log::error('PayPal Capture Failed: ' . $response->body());
            return null;
        }

        return $response->json();
    }
}
