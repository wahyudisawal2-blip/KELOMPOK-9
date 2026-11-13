<?php
declare(strict_types=1);
namespace App;

/** Pembantu untuk mengirim respons JSON. */
final class Response
{
    public static function json(array $data, int $code = 200): void
    {
        http_response_code($code);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }

    public static function error(string $message, int $code): void
    {
        self::json(['ok' => false, 'error' => $message], $code);
    }
}
