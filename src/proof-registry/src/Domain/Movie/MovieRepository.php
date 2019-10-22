<?php


namespace ProofRegistry\Domain\Movie;


use ProofRegistry\Domain\Shared\TokenId;

Interface MovieRepository
{
    public function save(Movie $movie): void;
    public function movieOfImdbId(ImdbId $imdbId): ?Movie;
    public function movieOfTokenId(TokenId $tokenId): ?Movie;
}
