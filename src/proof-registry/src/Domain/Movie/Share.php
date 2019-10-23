<?php


namespace ProofRegistry\Domain\Movie;


use ProofRegistry\Domain\RightsHolder\Address;

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
     * @var int
     */
    private $totalAmount;

    /**
     * Shares constructor.
     * @param Address $rightsHolderAddress
     * @param int $amount
     * @param int $totalAmount
     */
    public function __construct(Address $rightsHolderAddress, int $amount, int $totalAmount)
    {
        if ($totalAmount < $amount) {
            throw new \InvalidArgumentException('The amount of shares cannot be greater than the total shares');
        }
        $this->rightsHolderAddress = $rightsHolderAddress;
        $this->amount = $amount;
        $this->totalAmount = $totalAmount;
    }

    /**
     * @return int
     */
    public function amount(): int
    {
        return $this->amount;
    }

    /**
     * @return float
     */
    public function percentage(): float
    {
        return $this->amount / $this->totalAmount;
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
        $amountSum = $this->amount + $anotherShare->amount;

        return new Share($this->rightsHolderAddress, $amountSum, $this->totalAmount + $amountSum);
    }

    /**
     * @param int $totalShares
     * @return Share
     */
    public function ofTotalShares(int $totalShares)
    {
        return new Share($this->rightsHolderAddress, $this->amount, $totalShares);
    }
}
