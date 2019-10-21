<?php


namespace ProofRegistry\Application\Movie;


class MovieOfImdbIdQuery
{
    private $imdbId;

    /**
     * MovieOfImdbIdQuery constructor.
     * @param $imdbId
     */
    public function __construct(string $imdbId)
    {
        $this->imdbId = $imdbId;
    }

    /**
     * @return string
     */
    public function imdbId(): string
    {
        return $this->imdbId;
    }

}
