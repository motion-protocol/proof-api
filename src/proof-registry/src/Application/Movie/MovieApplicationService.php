<?php


namespace ProofRegistry\Application\Movie;


use ProofRegistry\Application\ApplicationServiceLifeCycle;
use ProofRegistry\Application\Movie\DTOs\MovieDTO;
use ProofRegistry\Application\Movie\DTOs\RightsHolderDTO;
use ProofRegistry\Application\Movie\Exceptions\MovieAlreadyAddedException;
use ProofRegistry\Application\Movie\Exceptions\MovieNotFoundException;
use ProofRegistry\Domain\Movie\ImdbId;
use ProofRegistry\Domain\Movie\Movie;
use ProofRegistry\Domain\Movie\MovieRepository;
use ProofRegistry\Domain\Movie\Share;
use ProofRegistry\Domain\RightsHolder\Address;
use ProofRegistry\Domain\RightsHolder\RightsHolder;
use ProofRegistry\Domain\RightsHolder\RightsHolderRepository;
use ProofRegistry\Domain\Shared\Services\SnapshotService;
use ProofRegistry\Domain\Shared\TokenId;

class MovieApplicationService
{
    /**
     * @var SnapshotService
     */
    private $signatureService;
    /**
     * @var MovieRepository
     */
    private $movieRepository;
    /**
     * @var RightsHolderRepository
     */
    private $rightsHolderRepository;
    /**
     * @var ApplicationServiceLifeCycle
     */
    private $applicationServiceLifeCycle;

    /**
     * MovieApplicationService constructor.
     * @param SnapshotService $signatureService
     * @param MovieRepository $movieRepository
     * @param RightsHolderRepository $rightsHolderRepository
     * @param ApplicationServiceLifeCycle $applicationServiceLifeCycle
     */
    public function __construct(
        SnapshotService $signatureService,
        MovieRepository $movieRepository,
        RightsHolderRepository $rightsHolderRepository,
        ApplicationServiceLifeCycle $applicationServiceLifeCycle
    )
    {
        $this->signatureService = $signatureService;
        $this->movieRepository = $movieRepository;
        $this->rightsHolderRepository = $rightsHolderRepository;
        $this->applicationServiceLifeCycle = $applicationServiceLifeCycle;
    }

    /**
     * @param NewMovieCommand $command
     * @throws MovieAlreadyAddedException
     */
    public function newMovie(NewMovieCommand $command): void
    {
        $this->applicationServiceLifeCycle->begin();

        $imdbId = new ImdbId($command->imdbId());
        $tokenId = new TokenId($command->tokenId());
        $movieWithTheSameImdbId = $this->movieRepository->movieOfImdbId($imdbId);
        $movieWithTheSameTokenId = $this->movieRepository->movieOfTokenId($tokenId);

        if ($movieWithTheSameImdbId || $movieWithTheSameTokenId) {
            throw new MovieAlreadyAddedException();
        }

        $movie = new Movie($imdbId, $tokenId);
        $this->movieRepository->save($movie);


        $this->applicationServiceLifeCycle->success();
    }


    /**
     * @param MovieOfTokenIdQuery $query
     * @return MovieDTO
     * @throws MovieNotFoundException
     */
    public function movieOfTokenId(MovieOfTokenIdQuery $query): MovieDTO
    {
        $this->applicationServiceLifeCycle->begin();

        $tokenId = new TokenId($query->tokenId());
        $movie = $this->movieRepository->movieOfTokenId($tokenId);
        if (!$movie) {
            throw new MovieNotFoundException();
        }
        $this->applicationServiceLifeCycle->success();

        return new MovieDTO($movie);
    }

    /**
     * @param MovieOfImdbIdQuery $query
     * @return MovieDTO
     * @throws MovieNotFoundException
     */
    public function movieOfImdbId(MovieOfImdbIdQuery $query): MovieDTO
    {
        $this->applicationServiceLifeCycle->begin();

        $imdbId = new ImdbId($query->imdbId());
        $movie = $this->movieRepository->movieOfImdbId($imdbId);
        if (!$movie) {
            throw new MovieNotFoundException();
        }
        $this->applicationServiceLifeCycle->success();

        return new MovieDTO($movie);
    }

    /**
     * @param AddRightHolderCommand $command
     * @throws MovieNotFoundException
     */
    public function addRightsHolder(AddRightHolderCommand $command)
    {
        $this->applicationServiceLifeCycle->begin();

        $address = new Address($command->address());
        $tokenId = new TokenId($command->tokenId());
        $amount = $command->amount();
        $name = $command->name();

        $movie = $this->movieRepository->movieOfTokenId($tokenId);
        if (!$movie) {
            throw new MovieNotFoundException();
        }
        $rightsHolder = $this->rightsHolderRepository->rightsHolderOfAddress($address);
        if (!$rightsHolder) {
            $rightsHolder = new RightsHolder($address, $name);
        }
        $rightsHolder->addRight($movie, $amount);
        $movie->addShares($rightsHolder, $amount);

        $this->rightsHolderRepository->save($rightsHolder);
        $this->movieRepository->save($movie);
        $this->signatureService->snapshotShares($movie->shares());

        $this->applicationServiceLifeCycle->success();

    }

    /**
     * @param MovieRightsHoldersQuery $query
     * @return array
     * @throws MovieNotFoundException
     */
    public function movieRightsHolders(MovieRightsHoldersQuery $query): array
    {
        $this->applicationServiceLifeCycle->begin();

        $tokenId = new TokenId($query->tokenId());
        $movie = $this->movieRepository->movieOfTokenId($tokenId);
        if (!$movie) {
            throw new MovieNotFoundException();
        }
        $shares = $movie->shares();
        $rightsHoldersAddresses = array_map(function (Share $shares) {
            return $shares->rightsHolderAddress();
        }, $shares);

        $rightsHolders = $this->rightsHolderRepository->rightsHoldersOfAddresses($rightsHoldersAddresses);

        $this->applicationServiceLifeCycle->success();

        return $this->createMovieSharesDTO($shares, $rightsHolders);
    }

    /**
     * @param Share[] $shares
     * @param RightsHolder[] $rightsHolders
     * @return array
     */
    private function createMovieSharesDTO(array $shares, array $rightsHolders)
    {
        return array_map(function (Share $share) use ($rightsHolders) {
            $rightsHolder = $this->findRightsHolderByAddress($rightsHolders, $share->rightsHolderAddress());
            return $this->createRightsHolderDTO($share, $rightsHolder);
        }, $shares);
    }

    /**
     * @param array $rightsHolders
     * @param Address $rightsHolderAddress
     * @return RightsHolder|null
     */
    private function findRightsHolderByAddress(array $rightsHolders, Address $rightsHolderAddress): ?RightsHolder
    {
        foreach ($rightsHolders as $rightsHolder) {
            if ($rightsHolderAddress->equals($rightsHolder->address())) {
                return $rightsHolder;
            }
        }

        return null;
    }

    /**
     * @param Share $share
     * @param RightsHolder|null $rightsHolder
     * @return RightsHolderDTO
     */
    private function createRightsHolderDTO(Share $share, ?RightsHolder $rightsHolder): RightsHolderDTO
    {
        $name = 'Unknown';
        if ($rightsHolder) {
            $name = $rightsHolder->name();
        }

        return new RightsHolderDTO($share->rightsHolderAddress()->address(), $name, $share->percentage(), $share->amount());
    }
}
