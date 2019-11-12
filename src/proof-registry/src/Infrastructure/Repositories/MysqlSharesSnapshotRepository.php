<?php


namespace ProofRegistry\Infrastructure\Repositories;


use ProofRegistry\Domain\Shared\Services\SharesSnapshotRepository;
use ProofRegistry\Infrastructure\Repositories\DBModels\SharesSnapshot;

class MysqlSharesSnapshotRepository implements SharesSnapshotRepository
{

    public function save(string $hash, array $shares): void
    {
        $snapshot = new SharesSnapshot([
            'hash' => $hash,
            'serialized_shares' => serialize($shares),
        ]);

        $snapshot->save();
    }

    public function sharesOfHash(string $hash): array
    {
        $snapshot = SharesSnapshot::findOrFail($hash);

        return $snapshot->shares();
    }
}
