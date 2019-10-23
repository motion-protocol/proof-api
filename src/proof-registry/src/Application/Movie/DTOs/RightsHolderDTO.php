<?php


namespace ProofRegistry\Application\Movie\DTOs;


use ProofRegistry\Domain\RightsHolder\RightsHolder;

class RightsHolderDTO
{
    public $address;
    public $name;
    public $shares;

    /**
     * RightsHolderDTO constructor.
     * @param string $address
     * @param string $name
     * @param string $shares
     */
    public function __construct(string $address, string $name, string $shares)
    {
        $this->address = $address;
        $this->name = $name;
        $this->shares = $shares;
    }

}
