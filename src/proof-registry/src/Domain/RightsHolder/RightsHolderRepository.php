<?php


namespace ProofRegistry\Domain\RightsHolder;


interface RightsHolderRepository
{
    public function rightsHolderOfAddress(Address $address): ?RightsHolder;
    public function save(RightsHolder $rightsHolder): void;
    public function rightsHoldersOfAddresses(array $addresses): array;
}
