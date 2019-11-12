<?php


namespace ProofRegistry\Application\Snapshot;


class SharesOfHashQuery
{
    /**
     * @var string
     */
    private $hash;

    /**
     * SharesOfHashQuery constructor.
     */
    public function __construct(string $hash)
    {
        $this->hash = $hash;
    }

    /**
     * @return string
     */
    public function hash(): string
    {
        return $this->hash;
    }

}
