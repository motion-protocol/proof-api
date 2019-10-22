<?php


namespace ProofRegistry\Domain\Movie;


use ProofRegistry\Domain\RightsHolder\Address;
use ProofRegistry\Domain\RightsHolder\RightsHolder;

class Share
{
    /**
     * @var Address
     */
    private $rightsHolderAddress;
    /**
     * @var int
     */
    private $amount;

    /**
     * Shares constructor.
     * @param RightsHolder $rightsHolder
     * @param int $amount
     */
    public function __construct(Address $rightsHolderAddress, int $amount)
    {
        $this->rightsHolderAddress = $rightsHolderAddress;
        $this->amount = $amount;
    }

    /**
     * @return int
     */
    public function amount(): int
    {
        return $this->amount;
    }

    /**
     * @return Address
     */
    public function rightsHolderAddress(): Address
    {
        return $this->rightsHolderAddress;
    }


    /**
     * @param Share $anotherShare
     * @return Share
     */
    public function add(Share $anotherShare): Share
    {
        if (!$this->rightsHolderAddress->equals($anotherShare->rightsHolderAddress)) {
            throw new \InvalidArgumentException('Shares of different rights holders cannot be added');
        }
        $totalAmount = $this->amount + $anotherShare->amount;

        return new Share($this->rightsHolderAddress, $totalAmount);
    }
}
