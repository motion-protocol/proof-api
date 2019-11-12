<?php


namespace ProofRegistry\Application\Movie;


class MovieOfTokenIdQuery
{
    /**
     * @var string
     */
    private $tokenId;

    /**
     * MovieOfTokenIdQuery constructor.
     * @param string $tokenId
     */
    public function __construct(string $tokenId)
    {
        $this->tokenId = $tokenId;
    }

    /**
     * @return string
     */
    public function tokenId(): string
    {
        return $this->tokenId;
    }
}
