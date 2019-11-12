<?php


namespace ProofRegistry\Domain\Shared\Services;


use ProofRegistry\Domain\Movie\Share;

class SnapshotService
{
    /**
     * @var Hash
     */
    private $hasher;
    /**
     * @var SharesSnapshotRepository
     */
    private $sharesSnapshotRepo;

    /**
     * SignatureService constructor.
     * @param Hash $hasher
     * @param SharesSnapshotRepository $sharesSnapshotRepo
     */
    public function __construct(Hash $hasher, SharesSnapshotRepository $sharesSnapshotRepo)
    {
        $this->hasher = $hasher;
        $this->sharesSnapshotRepo = $sharesSnapshotRepo;
    }


    /**
     * @param Share[] $shares
     */
    public function snapshotShares(array $shares): void
    {
        $addresses = array_map(function (Share $share) {
            return $share->rightsHolderAddress()->address();
        }, $shares);

        $amounts = array_map(function (Share $share) {
            return (int) ($share->percentage() * 10000);
        }, $shares);

        $hash = $this->hasher->hash($addresses, $amounts);

        $this->sharesSnapshotRepo->save($hash, $shares);
    }
}
