<?php


namespace ProofRegistry\Application\Movie;


class MovieRightsHoldersQuery
{
    private $tokenId;

    /**
     * MovieRightsHoldersQuery constructor.
     * @param $tokenId
     */
    public function __construct(string $tokenId)
    {
        $this->tokenId = $tokenId;
    }

    public function tokenId(): string
    {
        return $this->tokenId;
    }
}
