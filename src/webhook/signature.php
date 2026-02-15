<?php
declare(strict_types=1);

namespace App\Webhook;

final class Signature
{
    public static function validate(string $payload, string $headerSignature, string $secret): bool
    {
        if (!$headerSignature) {
            return false;
        }

        $computed = hash_hmac('sha256', $payload, $secret);

        return hash_equals($computed, $headerSignature);
    }
}