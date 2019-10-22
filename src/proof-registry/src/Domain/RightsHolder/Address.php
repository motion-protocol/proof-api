<?php


namespace ProofRegistry\Domain\RightsHolder;


class Address
{
    private $address;

    /**
     * Address constructor.
     * @param $address
     */
    public function __construct(string $address)
    {
        //@TODO add validation
        $this->address = $address;
    }

    /**
     * @return string
     */
    public function address(): string
    {
        return $this->address;
    }

    /**
     * @param Address $rightsHolderAddress
     * @return bool
     */
    public function equals(Address $rightsHolderAddress): bool
    {
        return $this->address === $rightsHolderAddress->address;
    }

}
