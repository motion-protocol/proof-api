<?php

use ProofRegistry\Domain\Movie\ImdbId;
use ProofRegistry\Domain\Movie\Movie;
use ProofRegistry\Domain\RightsHolder\Address;
use ProofRegistry\Domain\RightsHolder\RightsHolder;
use ProofRegistry\Domain\Shared\TokenId;
use Tests\TestCase;

class RightHolderTest extends TestCase
{
    public function testItCanBeInitialized()
    {
        $address = new Address('1DkyBEKt5S2GDtv7aQw6rQepAvnsRyHoYM');
        $name = 'Adrian Lugol';
        $rightsHolder = new RightsHolder($address, $name);

        $this->assertInstanceOf(RightsHolder::class, $rightsHolder);
    }

    public function testItCanAddRights()
    {
        $address = new Address('1DkyBEKt5S2GDtv7aQw6rQepAvnsRyHoYM');
        $name = 'Adrian Lugol';
        $rightsHolder = new RightsHolder($address, $name);

        $imdbId1 = new ImdbId('tt2911666');
        $tokenId1 = new TokenId('0x0000001');
        $movie1 = new Movie($imdbId1, $tokenId1);
        $rightsHolder->addRight($movie1, 1000);
        $this->assertCount(1, $rightsHolder->rights());

        $imdbId2 = new ImdbId('tt4425200');
        $tokenId2 = new TokenId('0x0000002');
        $movie2 = new Movie($imdbId2, $tokenId2);
        $rightsHolder->addRight($movie2, 1000);
        $this->assertCount(2, $rightsHolder->rights());

    }

    public function testItSumsRightsForTheSameToken()
    {
        $address = new Address('1DkyBEKt5S2GDtv7aQw6rQepAvnsRyHoYM');
        $name = 'Adrian Lugol';
        $rightsHolder = new RightsHolder($address, $name);

        $imdbId1 = new ImdbId('tt2911666');
        $tokenId1 = new TokenId('0x0000001');
        $movie1 = new Movie($imdbId1, $tokenId1);
        $rightsHolder->addRight($movie1, 1000);
        $rightsHolder->addRight($movie1, 2000);

        $movieRight = $rightsHolder->rights()[0];
        $this->assertEquals(3000, $movieRight->amount());
    }
}
