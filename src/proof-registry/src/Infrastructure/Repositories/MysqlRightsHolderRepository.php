<?php


namespace ProofRegistry\Infrastructure\Repositories;


use ProofRegistry\Domain\RightsHolder\Address;
use ProofRegistry\Domain\RightsHolder\RightsHolder;
use ProofRegistry\Domain\RightsHolder\RightsHolderRepository;

class MysqlRightsHolderRepository implements RightsHolderRepository
{

    public function rightsHolderOfAddress(Address $address): ?RightsHolder
    {
        $dbRightHolder = DBModels\RightsHolder::query()->where('address', $address->address())->first();
        if (!$dbRightHolder) {
            return null;
        }
        $domainModel = $dbRightHolder->rightsHolderDomainModel();

        return $domainModel;
    }

    public function save(RightsHolder $rightsHolder): void
    {
        DBModels\RightsHolder::updateOrCreate(
            ['address' => $rightsHolder->address()->address()],
            [
                'full_name' => $rightsHolder->name(),
                'serialized_model' => serialize($rightsHolder)
            ]
        );
    }

    public function rightsHoldersOfAddresses(array $addresses): array
    {
        // TODO: Implement rightsHoldersOfAddresses() method.
    }
}
