<?php


namespace ProofRegistry\Domain\Shared\Services;


interface SharesSnapshotRepository
{
    public function save(string $hash, array $shares): void;

    public function sharesOfHash(string $hash): array;
}
