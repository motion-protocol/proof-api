<?php


namespace ProofRegistry\Application\Movie\DTOs;


use ProofRegistry\Domain\Movie\Movie;

class MovieDTO
{
    public $tokenId;
    public $imdbId;

    /**
     * MovieDTO constructor.
     * @param Movie $movie
     */
    public function __construct(Movie $movie)
    {
        $this->tokenId = $movie->tokenId()->id();
        $this->imdbId = $movie->imdbId()->id();
    }


}
