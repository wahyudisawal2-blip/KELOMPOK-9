<?php
declare(strict_types=1);
namespace App;

/** Entitas satu karya seni, sekaligus tempat validasi input. */
final class Karya
{
    public function __construct(
        public ?int $id,
        public string $url,
        public string $title,
        public string $year = '',
        public string $artist = '',
        public string $life = '',
        public string $quote = '',
        public string $medium = '',
        public string $size = '',
        public string $av = '',
        public bool $fav = false,
    ) {}

    /** Membuat objek dari input pengguna; melempar InvalidArgumentException bila tidak valid. */
    public static function fromInput(array $in, ?int $id = null): self
    {
        $url   = self::text($in['url'] ?? '', 1000);
        $title = self::text($in['title'] ?? '', 200);
        $av    = self::text($in['av'] ?? '', 1000);

        if ($title === '' || !self::isUrl($url, true) || !self::isUrl($av, false)) {
            throw new \InvalidArgumentException('URL gambar dan judul wajib diisi dengan benar (URL harus diawali http:// atau https://).');
        }
        return new self(
            $id, $url, $title,
            self::text($in['year'] ?? '', 50),
            self::text($in['artist'] ?? '', 150),
            self::text($in['life'] ?? '', 200),
            self::text($in['quote'] ?? '', 1000),
            self::text($in['medium'] ?? '', 150),
            self::text($in['size'] ?? '', 100),
            $av,
        );
    }

    public static function fromRow(array $r): self
    {
        return new self(
            (int)$r['id'], $r['url'], $r['title'], $r['year'], $r['artist'], $r['life'],
            (string)$r['quote'], $r['medium'], $r['size'], $r['av'], (bool)$r['fav']
        );
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }

    private static function text(mixed $v, int $max): string
    {
        return mb_substr(trim((string)$v), 0, $max);
    }

    private static function isUrl(string $u, bool $required): bool
    {
        if ($u === '') return !$required;
        return filter_var($u, FILTER_VALIDATE_URL) !== false && preg_match('~^https?://~i', $u) === 1;
    }
}
