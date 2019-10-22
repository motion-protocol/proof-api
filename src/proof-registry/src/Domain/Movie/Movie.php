<?php
namespace ProofRegistry\Domain\Movie;

use ProofRegistry\Domain\RightsHolder\RightsHolder;
use ProofRegistry\Domain\Shared\TokenId;

class Movie
{
    private $imdbId;
    private $tokenId;
    private $shares = [];

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
        return  $this->imdbId;
    }

    /**
     * @param RightsHolder $rightsHolder
     * @param int $amount
     */
    public function addShares(RightsHolder $rightsHolder, int $amount): void
    {
        $newShare = new Share($rightsHolder->address(), $amount);

        foreach ($this->shares() as $key => $share) {
            if ($share->rightsHolderAddress()->equals($newShare->rightsHolderAddress())) {
                $this->shares[$key] = $share->add($newShare);
                return;
            }
        }

        $this->shares[] = $newShare;
    }

    /**
     * @return Share[]
     */
    public function shares(): array
    {
        return $this->shares;
    }

    /**
     * @return int
     */
    public function totalShareAmount(): int
    {
        $amounts = array_map(function (Share $share) {
            return $share->amount();
        }, $this->shares);

        return array_sum($amounts);
    }
}
