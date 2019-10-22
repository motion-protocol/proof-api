<?php


namespace ProofRegistry\Application\Movie;


class AddRightHolderCommand
{
    private $tokenId;
    private $address;
    private $name;
    private $amount;

    /**
     * AddRightHolderCommand constructor.
     * @param $tokenId
     * @param $address
     * @param $name
     * @param $amount
     */
    public function __construct(string $tokenId, string $address, string $name, string $amount)
    {
        $this->tokenId = $tokenId;
        $this->address = $address;
        $this->name = $name;
        $this->amount = $amount;
    }

    /**
     * @return string
     */
    public function tokenId(): string
    {
        return $this->tokenId;
    }

    /**
     * @return string
     */
    public function address(): string
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
     * @return string
     */
    public function amount(): string
    {
        return $this->amount;
    }




}
