<?php


namespace ProofRegistry\Application\Movie\DTOs;


class ShareDTO
{
    /**
     * @var string
     */
    public $address;
    /**
     * @var string
     */
    public $amount;
    /**
     * @var string
     */
    public $percentage;

    /**
     * ShareDTO constructor.
     * @param string $address
     * @param string $amount
     * @param string $percentage
     */
    public function __construct(string $address, string $amount, string $percentage)
    {
        $this->address = $address;
        $this->amount = $amount;
        $this->percentage = $percentage;
    }
}
