<?php


namespace ProofRegistry\Domain\Shared\Services;


interface Hash
{
    public static function hash(array $addresses, array $amounts): string;
}
