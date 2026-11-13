<?php
declare(strict_types=1);

use App\{Database, KaryaController, KaryaRepository};

$config = require __DIR__ . '/bootstrap.php';

try {
    $db = new Database($config['db']);
    (new KaryaController(new KaryaRepository($db->pdo()), $config['admin_key']))->handle();
} catch (Throwable $e) {
    error_log($e->getMessage());
    App\Response::error('Tidak bisa terhubung ke database. Periksa config/config.php.', 500);
}
