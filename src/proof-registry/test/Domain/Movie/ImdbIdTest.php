<?php


use ProofRegistry\Domain\Movie\ImdbId;
use Tests\TestCase;

class ImdbIdTest extends TestCase
{
    public function testItAcceptsValidImdbId()
    {
        $validId = 'tt2911666';
        $imdbId = new ImdbId($validId);

        $this->assertEquals($validId, $imdbId->id());
    }

//    public function testItFailsWhenInvalidIdIsPassed()
//    {
//        $invalidId = 'tt5487tt';
//        new ImdbId($invalidId);
//
//        $this->expectException(InvalidArgumentException::class);
//    }


}
