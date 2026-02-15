<?php
$payload = json_encode([
    'event' => 'order.created',
    'id' => 12345,
    'timestamp' => time()
]);

$secret = 'super_secret_key_here';
$signature = hash_hmac('sha256', $payload, $secret);

$ch = curl_init('http://127.0.0.1:8000');
curl_setopt_array($ch, [
    CURLOPT_POST => true,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        'Content-Type: application/json',
        'X-Signature: ' . $signature
    ],
    CURLOPT_POSTFIELDS => $payload
]);

$response = curl_exec($ch);
curl_close($ch);

echo $response;