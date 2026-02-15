<?php
declare(strict_types=1);

namespace App\Webhook;

final class Storage
{
    public function __construct(private string $path) {}

    public function save(string $payload): string
    {
        if (!is_dir($this->path)) {
            mkdir($this->path, 0775, true);
        }

        $filename = $this->path . '/' . time() . '_' . bin2hex(random_bytes(4)) . '.json';

        file_put_contents($filename, $payload);

        return $filename;
    }
}