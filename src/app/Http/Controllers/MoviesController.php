<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use ProofRegistry\Application\Movie\AddRightHolderCommand;
use ProofRegistry\Application\Movie\MovieApplicationService;
use ProofRegistry\Application\Movie\MovieOfTokenIdQuery;
use ProofRegistry\Application\Movie\MovieRightsHoldersQuery;
use ProofRegistry\Application\Movie\NewMovieCommand;

class MoviesController extends Controller
{
    /**
     * @var MovieApplicationService
     */
    private $movieApplicationService;

    /**
     * MoviesController constructor.
     * @param MovieApplicationService $movieApplicationService
     */
    public function __construct(MovieApplicationService $movieApplicationService)
    {
        $this->movieApplicationService = $movieApplicationService;
    }

    public function newMovie(Request $request, string $imdbId)
    {
        $tokenId = $request->get('tokenId');
        $command = new NewMovieCommand($imdbId, $tokenId);
        $this->movieApplicationService->newMovie($command);
    }

    public function getMovieInfo(string $tokenId)
    {
        $query = new MovieOfTokenIdQuery($tokenId);
        $movieDTO = $this->movieApplicationService->movieOfTokenId($query);

        return response()->json($movieDTO);
    }

    public function addRightsHolder(Request $request, string $tokenId)
    {
        $address = $request->get('address');
        $name = $request->get('name');
        $amount = $request->get('amount');
        $command = new AddRightHolderCommand($tokenId, $address, $name, $amount);

        $this->movieApplicationService->addRightsHolder($command);
    }

    public function listRightsHolders(string $tokenId)
    {
        $query = new MovieRightsHoldersQuery($tokenId);
        $rightsHoldersDTO = $this->movieApplicationService->movieRightsHolders($query);

        return response()->json($rightsHoldersDTO);
    }
}
