<?php
declare(strict_types=1);

spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    if (str_starts_with($class, $prefix)) {
        $path = __DIR__ . '/../src/' . str_replace('\\', '/', substr($class, strlen($prefix))) . '.php';
        if (file_exists($path)) {
            require $path;
        }
    }
});

use App\Config;
use App\Logger;
use App\Webhook\Signature;
use App\Webhook\Storage;

Config::loadEnv(__DIR__ . '/../.env');

$logger = new Logger(Config::get('LOG_PATH', 'storage/logs/app.log'));

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method Not Allowed']);
    exit;
}

$payload = file_get_contents('php://input');
$signatureHeader = $_SERVER['HTTP_X_SIGNATURE'] ?? '';
$secret = Config::get('WEBHOOK_SECRET');

if (!Signature::validate($payload, $signatureHeader, $secret)) {
    $logger->error('Invalid signature');
    http_response_code(401);
    echo json_encode(['error' => 'Invalid signature']);
    exit;
}

$decoded = json_decode($payload, true);
if (!is_array($decoded)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid JSON']);
    exit;
}

$storage = new Storage(Config::get('PAYLOAD_STORAGE_PATH', 'storage/payloads'));
$file = $storage->save($payload);

$logger->info('Webhook received', ['file' => $file]);

http_response_code(200);
echo json_encode(['status' => 'ok']);