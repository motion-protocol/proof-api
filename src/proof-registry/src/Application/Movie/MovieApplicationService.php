<?php


namespace ProofRegistry\Application\Movie;


use ProofRegistry\Application\Movie\DTOs\MovieDTO;
use ProofRegistry\Application\Movie\DTOs\RightsHolderDTO;
use ProofRegistry\Domain\Movie\ImdbId;
use ProofRegistry\Domain\Movie\Movie;
use ProofRegistry\Domain\Movie\MovieRepository;
use ProofRegistry\Domain\Movie\Share;
use ProofRegistry\Domain\RightsHolder\Address;
use ProofRegistry\Domain\RightsHolder\RightsHolder;
use ProofRegistry\Domain\RightsHolder\RightsHolderRepository;
use ProofRegistry\Domain\Shared\TokenId;

class MovieApplicationService
{
    /**
     * @var MovieRepository
     */
    private $movieRepository;
    /**
     * @var RightsHolderRepository
     */
    private $rightsHolderRepository;

    /**
     * MovieApplicationService constructor.
     * @param MovieRepository $movieRepository
     * @param RightsHolderRepository $rightsHolderRepository
     */
    public function __construct(MovieRepository $movieRepository, RightsHolderRepository $rightsHolderRepository)
    {
        $this->movieRepository = $movieRepository;
        $this->rightsHolderRepository = $rightsHolderRepository;
    }

    /**
     * @param NewMovieCommand $command
     */
    public function newMovie(NewMovieCommand $command): void
    {
        $imdbId = new ImdbId($command->imdbId());
        $tokenId = new TokenId($command->tokenId());
        $movie = $this->movieRepository->movieOfImdbId($imdbId);
        if (!$movie) {
            $movie = new Movie($imdbId, $tokenId);
            $this->movieRepository->save($movie);
        }
    }

    /**
     * @param MovieOfImdbIdQuery $query
     * @return MovieDTO
     */
    public function movieOfImdbId(MovieOfImdbIdQuery $query)
    {
        $imdbId = new ImdbId($query->imdbId());
        $movie = $this->movieRepository->movieOfImdbId($imdbId);

        return new MovieDTO($movie);
    }

    /**
     * @param AddRightHolderCommand $command
     */
    public function addRightsHolder(AddRightHolderCommand $command)
    {
        $address = new Address($command->address());
        $tokenId = new TokenId($command->tokenId());
        $amount = $command->amount();
        $name = $command->name();

        $movie = $this->movieRepository->movieOfTokenId($tokenId);
        $rightsHolder = $this->rightsHolderRepository->rightsHolderOfAddress($address);
        if (!$rightsHolder) {
            $rightsHolder = new RightsHolder($address, $name);
        }
        $rightsHolder->addRight($movie, $amount);
        $movie->addShares($rightsHolder, $amount);

        $this->rightsHolderRepository->save($rightsHolder);
        $this->movieRepository->save($movie);

    }

    /**
     * @param MovieRightsHoldersQuery $query
     * @return array
     */
    public function movieRightsHolders(MovieRightsHoldersQuery $query): array
    {
        $tokenId = new TokenId($query->tokenId());
        $movie = $this->movieRepository->movieOfTokenId($tokenId);
        $shares = $movie->shares();
        $rightsHoldersAddresses = array_map(function (Share $shares) {
            return $shares->rightsHolderAddress();
        }, $shares);

        $rightsHolders = $this->rightsHolderRepository->rightsHoldersOfAddresses($rightsHoldersAddresses);

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
            return $this->createMovieShareDTO($share, $rightsHolder);
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
    private function createMovieShareDTO(Share $share, ?RightsHolder $rightsHolder): RightsHolderDTO
    {
        $name = 'Unknown';
        if ($rightsHolder) {
            $name = $rightsHolder->name();
        }

        return new RightsHolderDTO($share->rightsHolderAddress()->address(), $name, $share->percentage());
    }
}
