<?php


namespace ProofRegistry\Infrastructure\Repositories\DBModels;


use Illuminate\Database\Eloquent\Model;

class SharesSnapshot extends Model
{
    protected $fillable = ['hash', 'serialized_shares'];
    protected $primaryKey = 'hash';
    protected $keyType = 'string';
    public $incrementing = false;

    public function shares()
    {
        return unserialize($this->serialized_shares);
    }
}
