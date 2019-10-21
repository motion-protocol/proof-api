<?php


use ProofRegistry\Application\Movie\MovieApplicationService;
use ProofRegistry\Application\Movie\MovieOfImdbIdQuery;
use ProofRegistry\Application\Movie\NewMovieCommand;
use ProofRegistry\Domain\Movie\ImdbId;
use ProofRegistry\Domain\Movie\Movie;
use ProofRegistry\Domain\Movie\MovieRepository;
use ProofRegistry\Domain\Movie\TokenId;
use Tests\TestCase;

class MovieApplicationServiceTest extends TestCase
{
    public function testNewMovie()
    {
        $movieRepository = Mockery::mock(MovieRepository::class);
        $movieRepository->shouldReceive('save');
        $movieAppService = new MovieApplicationService($movieRepository);
        $newMovieCommand = new NewMovieCommand('tt2911666', '0x1234');

        $movieAppService->newMovie($newMovieCommand);
    }

    public function testMovieOfImdbId()
    {
        $imdbId = new ImdbId('tt2911666');
        $tokenId = new TokenId('0x1234');
        $johnWickMovie = new Movie($imdbId, $tokenId);

        $movieRepository = Mockery::mock(MovieRepository::class);
        $movieRepository->shouldReceive('movieOfImdbId')
            ->andReturn($johnWickMovie);

        $movieAppService = new MovieApplicationService($movieRepository);
        $query = new MovieOfImdbIdQuery('tt2911666');
        $returnedMovie = $movieAppService->movieOfImdbId($query);

        $this->assertEquals($johnWickMovie, $returnedMovie);
    }
}
