<?php


namespace ProofRegistry\Domain\Shared;


class TokenId
{
    private $id;

    /**
     * ImdbId constructor.
     * @param $id
     */
    public function __construct(string $id)
    {
        $this->setId($id);
    }

    /**
     * @return string
     */
    public function id(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    private function setId(string $id): void
    {
        //@TODO Validate input
        $this->id = $id;
    }

    public function equals(TokenId $tokenId): bool
    {
        return $this->id === $tokenId->id();
    }
}
