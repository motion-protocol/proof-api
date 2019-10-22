<?php
namespace ProofRegistry\Domain\RightsHolder;

use InvalidArgumentException;
use ProofRegistry\Domain\Shared\TokenId;

class MovieRight
{
    private $movieTokenId;
    private $amount;

    /**
     * MovieRight constructor.
     * @param $movieTokenId
     * @param $amount
     */
    public function __construct(TokenId $movieTokenId, int $amount)
    {
        $this->movieTokenId = $movieTokenId;
        $this->setAmount($amount);
    }

    /**
     * @param int $amount
     */
    private function setAmount(int $amount): void
    {
        if ($amount <= 0) {
            throw new InvalidArgumentException('Movie right amount should be more then 0');
        }
        $this->amount = $amount;
    }

    /**
     * @return TokenId
     */
    public function movieTokenId(): TokenId
    {
        return $this->movieTokenId;
    }

    /**
     * @param TokenId $tokenId
     * @return bool
     */
    public function isForToken(TokenId $tokenId): bool
    {
        return $this->movieTokenId->equals($tokenId);
    }

    /**
     * @param MovieRight $movieRight
     * @return MovieRight
     */
    public function addRight(MovieRight $movieRight)
    {
        if (!$this->movieTokenId->equals($movieRight->movieTokenId())) {
            throw new InvalidArgumentException('Movie rights for different movies cannot be added.' .
                'Movie 1: ' . $this->movieTokenId->id() .
                'Movie 2: ' . $movieRight->movieTokenId()->id());
        }

        $amountSum = $this->amount + $movieRight->amount;

        return new MovieRight($this->movieTokenId, $amountSum);
    }

    /**
     * @return int
     */
    public function amount(): int
    {
        return $this->amount;
    }
}
