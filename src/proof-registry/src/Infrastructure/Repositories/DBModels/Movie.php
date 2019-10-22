<?php


namespace ProofRegistry\Infrastructure\Repositories\DBModels;


use Illuminate\Database\Eloquent\Model;
use ProofRegistry\Domain\Movie\Movie as MovieDomainModel;

class Movie extends Model
{
    protected $primaryKey = 'token_id';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'token_id',
        'imdb_id',
        'serialized_model'
    ];
    /**
     * @return MovieDomainModel
     */
    public function movieDomainModel(): MovieDomainModel
    {
        return unserialize($this->serialized_model);
    }


}
