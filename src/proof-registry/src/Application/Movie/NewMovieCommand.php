<?php


namespace ProofRegistry\Application\Movie;


class NewMovieCommand
{
    private $imdbId;
    private $tokenId;

    /**
     * NewMovieCommand constructor.
     * @param string $imdbId
     * @param string $tokenId
     */
    public function __construct(string $imdbId, string $tokenId)
    {
        $this->imdbId = $imdbId;
        $this->tokenId = $tokenId;
    }

    /**
     * @return string
     */
    public function imdbId(): string
    {
        return $this->imdbId;
    }


    /**
     * @return string
     */
    public function tokenId(): string
    {
        return $this->tokenId;
    }



}
