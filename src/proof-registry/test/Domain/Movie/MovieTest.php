<?php


use ProofRegistry\Domain\Movie\ImdbId;
use ProofRegistry\Domain\Movie\Movie;
use ProofRegistry\Domain\RightsHolder\Address;
use ProofRegistry\Domain\RightsHolder\RightsHolder;
use ProofRegistry\Domain\Shared\TokenId;
use Tests\TestCase;

class MovieTest extends TestCase
{
    public function testItCanBeInitialized()
    {
        $imdbId = new ImdbId('tt2911666');
        $tokenId = new TokenId('0x0000001');
        $movie = new Movie($imdbId, $tokenId);

        $this->assertInstanceOf(Movie::class, $movie);
    }

    public function testItCanAddShares()
    {
        $imdbId = new ImdbId('tt2911666');
        $tokenId = new TokenId('0x0000001');
        $movie = new Movie($imdbId, $tokenId);

        $address1 = new Address('1DkyBEKt5S2GDtv7aQw6rQepAvnsRyHoYM');
        $rightsHolder1 = new RightsHolder($address1, 'Adrian Lugol');

        $address2 = new Address('8bf24a18a58ab500d30c73bf21dbf4703d31ad2c');
        $rightsHolder2 = new RightsHolder($address2, 'John Smith');

        $movie->addShares($rightsHolder1, 1000);
        $movie->addShares($rightsHolder1, 1000);
        $movie->addShares($rightsHolder2, 2000);

        $this->assertEquals(4000, $movie->totalShareAmount());
        $this->assertCount(2, $movie->shares());
    }
}
