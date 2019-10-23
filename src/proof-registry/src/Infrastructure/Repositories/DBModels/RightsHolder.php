<?php


namespace ProofRegistry\Infrastructure\Repositories\DBModels;


use Illuminate\Database\Eloquent\Model;

class RightsHolder extends Model
{
    protected $fillable = ['full_name', 'address', 'serialized_model'];
    protected $primaryKey = 'address';
    protected $keyType = 'string';
    public $incrementing = false;

    public function rightsHolderDomainModel()
    {
        return unserialize($this->serialized_model);
    }
}
