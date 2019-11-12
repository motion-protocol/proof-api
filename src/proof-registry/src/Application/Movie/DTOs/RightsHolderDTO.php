<?php


namespace ProofRegistry\Application\Movie\DTOs;


use ProofRegistry\Domain\RightsHolder\RightsHolder;

class RightsHolderDTO
{
    public $address;
    public $name;
    public $sharesPercentage;
    public $sharesAmount;

    /**
     * RightsHolderDTO constructor.
     * @param string $address
     * @param string $name
     * @param string $sharesPercentage
     * @param string $sharesAmount
     */
    public function __construct(string $address, string $name, string $sharesPercentage, string $sharesAmount)
    {
        $this->address = $address;
        $this->name = $name;
        $this->sharesPercentage = $sharesPercentage;
        $this->sharesAmount = $sharesAmount;
    }

}
