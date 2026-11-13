<?php
declare(strict_types=1);
namespace App;

use PDO;

/** Mengelola koneksi PDO dan membuat tabel bila belum ada. */
final class Database
{
    private ?PDO $pdo = null;

    public function __construct(private array $cfg) {}

    public function pdo(): PDO
    {
        if ($this->pdo === null) {
            $this->pdo = new PDO(
                "mysql:host={$this->cfg['host']};dbname={$this->cfg['name']};charset=utf8mb4",
                $this->cfg['user'],
                $this->cfg['pass'],
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
            );
            $this->migrate($this->pdo);
        }
        return $this->pdo;
    }

    private function migrate(PDO $pdo): void
    {
        $pdo->exec("CREATE TABLE IF NOT EXISTS karya (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            url VARCHAR(1000) NOT NULL,
            title VARCHAR(200) NOT NULL,
            `year` VARCHAR(50) NOT NULL DEFAULT '',
            artist VARCHAR(150) NOT NULL DEFAULT '',
            life VARCHAR(200) NOT NULL DEFAULT '',
            quote TEXT,
            medium VARCHAR(150) NOT NULL DEFAULT '',
            `size` VARCHAR(100) NOT NULL DEFAULT '',
            av VARCHAR(1000) NOT NULL DEFAULT '',
            fav TINYINT(1) NOT NULL DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) CHARACTER SET utf8mb4");

        if ((int)$pdo->query('SELECT COUNT(*) FROM karya')->fetchColumn() === 0) {
            $seed = $pdo->prepare('INSERT INTO karya (url,title,`year`,artist,life,quote,medium,`size`) VALUES (?,?,?,?,?,?,?,?)');
            $seed->execute([
                'https://upload.wikimedia.org/wikipedia/commons/thumb/e/ea/Van_Gogh_-_Starry_Night_-_Google_Art_Project.jpg/1280px-Van_Gogh_-_Starry_Night_-_Google_Art_Project.jpg',
                'The Starry Night', 'Juni 1889', 'Vincent van Gogh', '1853 – 1890 · Zundert, Belanda',
                'Aku menatap bintang-bintang dan merasa bagian dari salah satunya.',
                'Cat minyak di kanvas', '73,7 × 92,1 cm',
            ]);
            $seed->execute([
                'https://picsum.photos/seed/senja/900/700', 'Senja di Ladang', '2021', 'Seniman Contoh',
                'Jambi, Indonesia', 'Cahaya terakhir selalu paling jujur.', 'Akrilik di kanvas', '60 × 80 cm',
            ]);
        }
    }
}
