<?php


use ProofRegistry\Domain\Movie\TokenId;
use Tests\TestCase;

class TokenIdTest extends TestCase
{
    public function testFailsWhenInvalidIdIsPassed()
    {
        $invalidId = 'x0InvalidID';
        new TokenId($invalidId);

        $this->expectException(InvalidArgumentException::class);
    }
}
