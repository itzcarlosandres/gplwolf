<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class Recaptcha implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('services.recaptcha.secret'),
            'response' => $value,
            'remoteip' => request()->ip(),
        ]);

        if (! $response->json('success')) {
            $errorCodes = $response->json('error-codes', []);
            
            // Log the error for monitoring
            Log::error('reCAPTCHA verification failed', [
                'error_codes' => $errorCodes,
                'ip' => request()->ip(),
            ]);

            $fail('La verificación de reCAPTCHA falló. Por favor, inténtalo de nuevo.');
            return;
        }
    }
}
