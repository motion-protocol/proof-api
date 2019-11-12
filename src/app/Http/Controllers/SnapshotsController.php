<?php


namespace App\Http\Controllers;

use ProofRegistry\Application\Snapshot\SharesOfHashQuery;
use ProofRegistry\Application\Snapshot\SnapshotApplicationService;

class SnapshotsController extends Controller
{
    /**
     * @var SnapshotApplicationService
     */
    private $snapshotApplicationService;


    /**
     * SignatureController constructor.
     * @param SnapshotApplicationService $snapshotApplicationService
     */
    public function __construct(SnapshotApplicationService $snapshotApplicationService)
    {
        $this->snapshotApplicationService = $snapshotApplicationService;
    }

    public function getSharesByHash(string $hash)
    {
        $query = new SharesOfHashQuery($hash);
        $sharesDTO = $this->snapshotApplicationService->sharesOfHash($query);

        return response()->json($sharesDTO);
    }


}
