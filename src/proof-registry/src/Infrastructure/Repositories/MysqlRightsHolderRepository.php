<?php


namespace ProofRegistry\Infrastructure\Repositories;


use ProofRegistry\Domain\RightsHolder\Address;
use ProofRegistry\Domain\RightsHolder\RightsHolder;
use ProofRegistry\Domain\RightsHolder\RightsHolderRepository;
use ProofRegistry\Infrastructure\Repositories\DBModels\RightsHolder as DBRightsHolder;

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
        $addresses = array_map(function (Address $address) {
            return $address->address();
        }, $addresses);
        $dbRightHolders = DBModels\RightsHolder::query()->whereIn('address', $addresses)->get();
        $rightsHolders = $dbRightHolders->map(function (DBRightsHolder $rightsHolder) {
           return $rightsHolder->rightsHolderDomainModel();
        });

        return $rightsHolders->toArray();
    }
}
