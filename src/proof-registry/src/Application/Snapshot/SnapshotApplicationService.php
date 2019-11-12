<?php


namespace ProofRegistry\Application\Snapshot;


use ProofRegistry\Application\Movie\DTOs\ShareDTO;
use ProofRegistry\Domain\Movie\Share;
use ProofRegistry\Domain\Shared\Services\SharesSnapshotRepository;

class SnapshotApplicationService
{
    /**
     * @var SharesSnapshotRepository
     */
    private $sharesSnapshotRepo;


    /**
     * SnapshotApplicationService constructor.
     * @param SharesSnapshotRepository $sharesSnapshotRepo
     */
    public function __construct(SharesSnapshotRepository $sharesSnapshotRepo)
    {
        $this->sharesSnapshotRepo = $sharesSnapshotRepo;
    }

    public function sharesOfHash(SharesOfHashQuery $query)
    {
        $hash = $query->hash();
        $shares = $this->sharesSnapshotRepo->sharesOfHash($hash);

        return $this->getSharesDto($shares);
    }

    /**
     * @param array $shares
     * @return array
     */
    private function getSharesDto(array $shares): array
    {
        return array_map(function (Share $share) {
            $address = $share->rightsHolderAddress()->address();
            $percentage = (string)$share->percentage();
            $amount = (string)$share->amount();

            return new ShareDTO($address, $amount, $percentage);
        }, $shares);
    }
}
