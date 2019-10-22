<?php


use ProofRegistry\Application\Movie\MovieApplicationService;
use ProofRegistry\Application\Movie\MovieOfImdbIdQuery;
use ProofRegistry\Application\Movie\NewMovieCommand;
use ProofRegistry\Domain\Movie\ImdbId;
use ProofRegistry\Domain\Movie\Movie;
use ProofRegistry\Domain\Movie\MovieRepository;
use ProofRegistry\Domain\RightsHolder\RightsHolderRepository;
use ProofRegistry\Domain\Shared\TokenId;
use Tests\TestCase;

class MovieApplicationServiceTest extends TestCase
{
    public function testNewMovie()
    {
        $movieRepository = Mockery::mock(MovieRepository::class);
        $movieRepository->shouldReceive('movieOfImdbId')->andReturn(null);
        $movieRepository->shouldReceive('save');
        $rightHolderRepository = Mockery::mock(RightsHolderRepository::class);

        $movieAppService = new MovieApplicationService($movieRepository, $rightHolderRepository);
        $newMovieCommand = new NewMovieCommand('tt2911666', '0x1234');
        $movieAppService->newMovie($newMovieCommand);
    }

    public function testAddExistingMovie()
    {
        $movie = Mockery::mock(Movie::class);
        $movieRepository = Mockery::mock(MovieRepository::class);
        $movieRepository->shouldReceive('movieOfImdbId')->andReturn($movie);
        $movieRepository->shouldReceive('save');
        $rightHolderRepository = Mockery::mock(RightsHolderRepository::class);

        $movieAppService = new MovieApplicationService($movieRepository, $rightHolderRepository);
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
        $rightHolderRepository = Mockery::mock(RightsHolderRepository::class);

        $movieAppService = new MovieApplicationService($movieRepository, $rightHolderRepository);
        $query = new MovieOfImdbIdQuery('tt2911666');
        $returnedMovie = $movieAppService->movieOfImdbId($query);

        $this->assertEquals($johnWickMovie, $returnedMovie);
    }
}
