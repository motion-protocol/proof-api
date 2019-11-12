<?php


namespace ProofRegistry\Application\Movie\Exceptions;


class MovieAlreadyAddedException extends \Exception
{

    /**
     * MovieAlreadyAddedException constructor.
     */
    public function __construct()
    {
        parent::__construct("A movie with the same tokenId or ImdbId exists already");
    }
}
