<?php

namespace ProofRegistry\Domain\Movie;

use ProofRegistry\Domain\RightsHolder\RightsHolder;
use ProofRegistry\Domain\Shared\TokenId;

class Movie
{
    /**
     * @var ImdbId
     */
    private $imdbId;
    /**
     * @var TokenId
     */
    private $tokenId;
    /**
     * @var Share[]
     */
    private $shares = [];
    /**
     * @var int
     */
    private $totalShares;

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

    /**
     * @return TokenId
     */
    public function tokenId(): TokenId
    {
        return $this->tokenId;
    }

    /**
     * @return ImdbId
     */
    public function imdbId(): ImdbId
    {
        return $this->imdbId;
    }

    /**
     * @param RightsHolder $rightsHolder
     * @param int $amount
     */
    public function addShares(RightsHolder $rightsHolder, int $amount): void
    {
        $newShare = new Share($rightsHolder->address(), $amount, $this->totalShares + $amount);
        $address = $newShare->rightsHolderAddress()->address();
        $rightsHolderHasShares = isset($this->shares[$address]);
        $this->shares[$address] = $rightsHolderHasShares ? $this->shares[$address]->add($newShare): $newShare;

        $this->updateTotalShares();
        $this->updateSharesPercentage();
    }

    /**
     * @return Share[]
     */
    public function shares(): array
    {
        return array_values($this->shares);
    }

    private function updateTotalShares(): void
    {
        $sharesAmounts = array_map(function (Share $share) {
            return $share->amount();
        }, $this->shares);

        $this->totalShares = array_sum($sharesAmounts);
    }

    private function updateSharesPercentage(): void
    {
        $this->shares = array_map(function (Share $share){
            return $share->ofTotalShares($this->totalShares);
        }, $this->shares);
    }
}
