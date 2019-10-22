<?php


namespace ProofRegistry\Infrastructure\Repositories;


use Illuminate\Support\Facades\DB;
use ProofRegistry\Domain\Movie\ImdbId;
use ProofRegistry\Domain\Movie\Movie;
use ProofRegistry\Domain\Movie\MovieRepository;
use ProofRegistry\Domain\Shared\TokenId;

class MysqlMovieRepository implements MovieRepository
{

    public function save(Movie $movie): void
    {
        DBModels\Movie::updateOrCreate(
            [
                'token_id' => $movie->tokenId()->id(),
                'imdb_id' => $movie->imdbId()->id()
            ], [
                'serialized_model' => serialize($movie)
            ]
        );

    }

    public function movieOfImdbId(ImdbId $imdbId): ?Movie
    {
        $dbMovie = DBModels\Movie::query()->where('imdb_id', $imdbId->id())->first();
        if (!$dbMovie) {
            return null;
        }
        $domainModel = $dbMovie->movieDomainModel();

        return $domainModel;
    }

    public function movieOfTokenId(TokenId $tokenId): ?Movie
    {
        $dbMovie = DBModels\Movie::query()->where('token_id', $tokenId->id())->first();
        if (!$dbMovie) {
            return null;
        }
        $domainModel = $dbMovie->movieDomainModel();

        return $domainModel;
    }
}
