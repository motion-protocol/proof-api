<?php


namespace ProofRegistry\Domain\RightsHolder;


use ProofRegistry\Domain\Movie\Movie;

class RightsHolder
{
    private $address;
    private $name;
    private $rights = [];

    /**
     * RightsHolder constructor.
     * @param $address
     * @param string $name
     */
    public function __construct(Address $address, string $name)
    {
        $this->address = $address;
        $this->setName($name);
    }

    /**
     * @param Movie $movie
     * @param int $amount
     */
    public function addRight(Movie $movie, int $amount): void
    {
        $newMovieRight = new MovieRight($movie->tokenId(), $amount);

        $this->addToRightsOfTheSameToken($newMovieRight);
        if (!$this->hasRightsForMovie($movie)) {
            $this->rights[] = $newMovieRight;
        }
    }

    /**
     * @return MovieRight[]
     */
    public function rights(): array
    {
        return $this->rights;
    }

    /**
     * @return Address
     */
    public function address(): Address
    {
        return $this->address;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @param MovieRight $newMovieRight
     */
    private function addToRightsOfTheSameToken(MovieRight $newMovieRight): void
    {
        /**
         * @var MovieRight $right
         */
        foreach ($this->rights as $key => $right) {
            if ($right->isForToken($newMovieRight->movieTokenId())) {
                $this->rights[$key] = $right->addRight($newMovieRight);
            }
        }
    }

    /**
     * @param Movie $movie
     * @return bool
     */
    private function hasRightsForMovie(Movie $movie): bool
    {
        foreach ($this->rights as $right) {
            if ($right->movieTokenId()->equals($movie->tokenId())) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param string $name
     */
    private function setName(string $name): void
    {
        if (!$name) {
            throw new \InvalidArgumentException('Rights Holder name cannot be empty');
        }

        $this->name = $name;
    }
}
