<?php


namespace ProofRegistry\Application\Movie;


use ProofRegistry\Domain\Movie\ImdbId;
use ProofRegistry\Domain\Movie\Movie;
use ProofRegistry\Domain\Movie\MovieRepository;
use ProofRegistry\Domain\Movie\TokenId;

class MovieApplicationService
{
    /**
     * @var MovieRepository
     */
    private $movieRepository;

    /**
     * MovieApplicationService constructor.
     * @param MovieRepository $movieRepository
     */
    public function __construct(MovieRepository $movieRepository)
    {
        $this->movieRepository = $movieRepository;
    }

    /**
     * @param NewMovieCommand $command
     */
    public function newMovie(NewMovieCommand $command): void
    {
        $imdbId = new ImdbId($command->imdbId());
        $tokenId = new TokenId($command->tokenId());
        $movie = new Movie($imdbId, $tokenId);

        $this->movieRepository->save($movie);
    }

    /**
     * @param MovieOfImdbIdQuery $query
     * @return Movie
     */
    public function movieOfImdbId(MovieOfImdbIdQuery $query)
    {
        $imdbId = new ImdbId($query->imdbId());
        $movie = $this->movieRepository->movieOfImdbId($imdbId);

        return $movie;
    }
}
