<?php


namespace ProofRegistry\Infrastructure\Repositories\DBModels;


use Illuminate\Database\Eloquent\Model;
use ProofRegistry\Domain\Movie\Movie as MovieDomainModel;

class Movie extends Model
{

    /**
     * @return MovieDomainModel
     */
    public function movieDomainModel(): MovieDomainModel
    {
        return unserialize($this->serialized_model);
    }


}
