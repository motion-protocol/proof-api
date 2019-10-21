<?php


namespace ProofRegistry\Domain\Movie;


Interface MovieRepository
{
    public function save(Movie $movie): void;
    public function movieOfImdbId(ImdbId $imdbId): Movie;
}
