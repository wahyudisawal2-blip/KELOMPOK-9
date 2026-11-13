<?php
declare(strict_types=1);
namespace App;

use PDO;

/** Semua operasi CRUD ke tabel karya. */
final class KaryaRepository
{
    public function __construct(private PDO $pdo) {}

    /** READ: semua karya. @return Karya[] */
    public function all(): array
    {
        $rows = $this->pdo->query('SELECT * FROM karya ORDER BY id ASC')->fetchAll();
        return array_map([Karya::class, 'fromRow'], $rows);
    }

    /** READ: satu karya. */
    public function find(int $id): Karya
    {
        $st = $this->pdo->prepare('SELECT * FROM karya WHERE id = ?');
        $st->execute([$id]);
        $row = $st->fetch();
        if (!$row) throw new NotFoundException('Karya tidak ditemukan.');
        return Karya::fromRow($row);
    }

    /** CREATE */
    public function create(Karya $k): Karya
    {
        $this->pdo->prepare(
            'INSERT INTO karya (url,title,`year`,artist,life,quote,medium,`size`,av) VALUES (?,?,?,?,?,?,?,?,?)'
        )->execute([$k->url, $k->title, $k->year, $k->artist, $k->life, $k->quote, $k->medium, $k->size, $k->av]);
        return $this->find((int)$this->pdo->lastInsertId());
    }

    /** UPDATE: ubah seluruh data karya. */
    public function update(Karya $k): Karya
    {
        $this->find((int)$k->id); // pastikan ada
        $this->pdo->prepare(
            'UPDATE karya SET url=?,title=?,`year`=?,artist=?,life=?,quote=?,medium=?,`size`=?,av=? WHERE id=?'
        )->execute([$k->url, $k->title, $k->year, $k->artist, $k->life, $k->quote, $k->medium, $k->size, $k->av, $k->id]);
        return $this->find((int)$k->id);
    }

    /** UPDATE: tandai / batalkan favorit. */
    public function setFavorite(int $id, bool $fav): void
    {
        $this->pdo->prepare('UPDATE karya SET fav = ? WHERE id = ?')->execute([$fav ? 1 : 0, $id]);
    }

    /** DELETE */
    public function delete(int $id): void
    {
        $this->pdo->prepare('DELETE FROM karya WHERE id = ?')->execute([$id]);
    }
}
