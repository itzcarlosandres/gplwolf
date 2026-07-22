<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CoinpalService
{
    protected $merchantNo;
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $settings = Setting::whereIn('key', ['coinpal_merchant_no', 'coinpal_api_key', 'coinpal_mode'])->pluck('value', 'key');
        
        $this->merchantNo = $settings['coinpal_merchant_no'] ?? '';
        $this->apiKey = $settings['coinpal_api_key'] ?? '';
        
        // CoinPal URL base oficial (Live)
        // Nota: CoinPal no tiene una URL de testnet pública separada en su SDK oficial.
        $this->baseUrl = 'https://pay.coinpal.io';
    }

    public function createPayment($amount, $orderNo)
    {
        if (empty($this->merchantNo) || empty($this->apiKey)) {
            Log::error('CoinPal Configuration Missing');
            return null;
        }

        // CoinPal requiere que el monto sea mayor a 0
        if ($amount <= 0) {
            Log::error('CoinPal: Amount must be greater than 0');
            return null;
        }

        // Generar un requestId único
        $requestId = uniqid('REQ-', true);

        // Convertir el monto a string con 2 decimales SIN separadores de miles
        $formattedAmount = number_format((float)$amount, 2, '.', '');

        $params = [
            'version' => '2.1',
            'requestId' => $requestId,
            'merchantNo' => $this->merchantNo,
            'orderNo' => $orderNo,
            'orderCurrencyType' => 'fiat',
            'orderCurrency' => 'USD',
            'orderAmount' => $formattedAmount,
            'payerIP' => request()->ip() ?: '127.0.0.1',
            'notifyURL' => route('coinpal.notify'),
            'redirectURL' => route('coinpal.redirect'),
        ];

        // Generar firma según el método oficial de CoinPal
        $params['sign'] = $this->generateSignature($params);

        Log::info('CoinPal Request:', $params);
        
        // Debug: Guardar en archivo separado
        file_put_contents(
            storage_path('logs/coinpal_debug.log'),
            date('Y-m-d H:i:s') . " REQUEST:\n" . json_encode($params, JSON_PRETTY_PRINT) . "\n\n",
            FILE_APPEND
        );

        // Endpoint oficial: /gateway/pay/checkout
        $response = Http::withoutVerifying()->post("{$this->baseUrl}/gateway/pay/checkout", $params);

        if ($response->failed()) {
            Log::error('CoinPal HTTP Error: ' . $response->body());
            return null;
        }

        $result = $response->json();
        Log::info('CoinPal Response:', $result ?? []);
        
        // Debug: Guardar respuesta
        file_put_contents(
            storage_path('logs/coinpal_debug.log'),
            date('Y-m-d H:i:s') . " RESPONSE:\n" . json_encode($result, JSON_PRETTY_PRINT) . "\n" . str_repeat('=', 80) . "\n\n",
            FILE_APPEND
        );

        // En CoinPal V2, el éxito se marca con respCode 200
        if (!isset($result['respCode']) || $result['respCode'] != 200) {
            Log::error('CoinPal API Error: ' . ($result['respMessage'] ?? 'Unknown Error'));
            return null;
        }

        return $result;
    }

    protected function generateSignature($params)
    {
        // Método de firma oficial de CoinPal:
        // apiKey + requestId + merchantNo + orderNo + orderAmount + orderCurrency
        $signString = $this->apiKey 
            . $params['requestId'] 
            . $params['merchantNo'] 
            . $params['orderNo'] 
            . $params['orderAmount'] 
            . $params['orderCurrency'];

        Log::info('CoinPal Sign String: ' . $signString);
        
        return hash('sha256', $signString);
    }

    public function verifyNotification($data)
    {
        if (!isset($data['sign'])) return false;

        $receivedSignature = $data['sign'];
        
        // Recrear la firma con los datos recibidos
        $calculatedSignature = $this->generateSignature($data);

        return hash_equals($receivedSignature, $calculatedSignature);
    }
}
