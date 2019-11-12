<?php


namespace ProofRegistry\Application\Movie\Exceptions;


class MovieNotFoundException extends \Exception
{

    /**
     * MovieNotFoundException constructor.
     */
    public function __construct()
    {
        parent::__construct('Movie not found');
    }
}
