<?php


use ProofRegistry\Domain\Shared\TokenId;
use Tests\TestCase;

class TokenIdTest extends TestCase
{
    public function testFailsWhenInvalidIdIsPassed()
    {
        $this->markTestSkipped('must be revisited.');
        $invalidId = 'x0InvalidID';
        new TokenId($invalidId);

        $this->expectException(InvalidArgumentException::class);
    }
}
