<?php
declare(strict_types=1);
namespace App;

/** Menerima permintaan dari api.php dan meneruskannya ke repository. */
final class KaryaController
{
    public function __construct(private KaryaRepository $repo, private string $adminKey = '') {}

    public function handle(): void
    {
        try {
            $action = $_GET['action'] ?? 'list';

            if ($action === 'list') {
                Response::json(['ok' => true, 'data' => array_map(fn(Karya $k) => $k->toArray(), $this->repo->all())]);
            }
            if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
                Response::error('Metode tidak valid.', 405);
            }
            if (!$this->authorized()) {
                Response::error('Kata sandi admin salah.', 401);
            }

            $in = json_decode(file_get_contents('php://input') ?: '', true);
            if (!is_array($in)) $in = [];

            match ($action) {
                'add'    => $this->add($in),
                'update' => $this->update($in),
                'fav'    => $this->favorite($in),
                'delete' => $this->delete($in),
                default  => Response::error('Aksi tidak dikenal.', 400),
            };
        } catch (\InvalidArgumentException $e) {
            Response::error($e->getMessage(), 422);
        } catch (NotFoundException $e) {
            Response::error($e->getMessage(), 404);
        } catch (\Throwable $e) {
            error_log($e->getMessage());
            Response::error('Terjadi kesalahan di server.', 500);
        }
    }

    private function add(array $in): void
    {
        $item = $this->repo->create(Karya::fromInput($in));
        Response::json(['ok' => true, 'item' => $item->toArray()]);
    }

    private function update(array $in): void
    {
        $item = $this->repo->update(Karya::fromInput($in, (int)($in['id'] ?? 0)));
        Response::json(['ok' => true, 'item' => $item->toArray()]);
    }

    private function favorite(array $in): void
    {
        $this->repo->setFavorite((int)($in['id'] ?? 0), !empty($in['fav']));
        Response::json(['ok' => true]);
    }

    private function delete(array $in): void
    {
        $this->repo->delete((int)($in['id'] ?? 0));
        Response::json(['ok' => true]);
    }

    private function authorized(): bool
    {
        return $this->adminKey === '' || hash_equals($this->adminKey, $_SERVER['HTTP_X_ADMIN_KEY'] ?? '');
    }
}
