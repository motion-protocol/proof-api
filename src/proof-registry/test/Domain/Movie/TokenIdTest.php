<?php


use ProofRegistry\Domain\Shared\TokenId;
use Tests\TestCase;

class TokenIdTest extends TestCase
{

    public function testFailsWhenInvalidIdIsPassed()
    {
        $invalidId = 'x0InvalidID';
        new TokenId($invalidId);

        $this->expectException(InvalidArgumentException::class);
        $this->markTestSkipped('Not yet implemented');
    }
}
