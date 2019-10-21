<?php
namespace ProofRegistry\Domain\Movie;

class Movie
{
    private $imdbId;
    private $tokenId;

    /**
     * Movie constructor.
     * @param ImdbId $imdbId
     * @param TokenId $tokenId
     */
    public function __construct(ImdbId $imdbId, TokenId $tokenId)
    {
        $this->imdbId = $imdbId;
        $this->tokenId = $tokenId;
    }
}
