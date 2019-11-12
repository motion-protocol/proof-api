<?php


namespace App\Http\Controllers;


use ProofRegistry\Domain\Movie\Share;
use ProofRegistry\Domain\Shared\Services\SharesSnapshotRepository;

class SnapshotsController extends Controller
{
    /**
     * @var SharesSnapshotRepository
     */
    private $sharesSnapshotRepo;


    /**
     * SignatureController constructor.
     * @param SharesSnapshotRepository $sharesSnapshotRepo
     */
    public function __construct(SharesSnapshotRepository $sharesSnapshotRepo)
    {
        $this->sharesSnapshotRepo = $sharesSnapshotRepo;
    }

    public function getSharesByHash(string $hash)
    {
        $shares = $this->sharesSnapshotRepo->sharesOfHash($hash);

        return response()->json($this->getSharesDto($shares));
    }

    /**
     * @param array $shares
     * @return array
     */
    private function getSharesDto(array $shares): array
    {
        return array_map(function (Share $share) {
            return [
                'address' => $share->rightsHolderAddress()->address(),
                'shares' => (string) $share->percentage(),
            ];
        }, $shares);
    }
}
