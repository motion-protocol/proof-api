<?php


use ProofRegistry\Infrastructure\Services\AbiHash;
use Tests\TestCase;

class AbiHashTest extends TestCase
{
    const ADD_1 = '0x1231111111111111111111111111111111111123';
    const ADD_2 = '0x2341111111111111111111111111111111111234';
    const ADD_3 = '0x3451111111111111111111111111111111111345';
    const ADD_4 = '0x4561111111111111111111111111111111111456';
    const AMOUNT = 124000000;

    public function testItHashOneAddress()
    {
        $hash = AbiHash::hash([self::ADD_1], [self::AMOUNT]);
        $expectedHash = '0x3274b7ee060fa41bf0a20baf8a4edc7330dc073acaabe6570e0361187b407a29';
        $this->assertEquals($expectedHash, $hash);
    }

    public function testItHashesTwoAddresses()
    {
        $hash1 = AbiHash::hash([self::ADD_1, self::ADD_2], [self::AMOUNT, self::AMOUNT]);
        $hash2 = AbiHash::hash([self::ADD_2, self::ADD_1], [self::AMOUNT, self::AMOUNT]);
        $expectedHash = '0x5995411c9c4bfedc9b7f8de8303ab22a36a087610971027a9cf30acd77ff1b18';
        $this->assertEquals($expectedHash, $hash1);
        $this->assertEquals($expectedHash, $hash2);
    }

    public function testItSortsAndHash4Values()
    {
        $hash1 = AbiHash::hash([self::ADD_1, self::ADD_2, self::ADD_3, self::ADD_4], [self::AMOUNT, self::AMOUNT, self::AMOUNT, self::AMOUNT]);
        $hash2 = AbiHash::hash([self::ADD_4, self::ADD_1, self::ADD_2, self::ADD_3], [self::AMOUNT, self::AMOUNT, self::AMOUNT, self::AMOUNT]);
        $hash3 = AbiHash::hash([self::ADD_1, self::ADD_3, self::ADD_4, self::ADD_2], [self::AMOUNT, self::AMOUNT, self::AMOUNT, self::AMOUNT]);
        $hash4 = AbiHash::hash([self::ADD_3, self::ADD_4, self::ADD_1, self::ADD_2], [self::AMOUNT, self::AMOUNT, self::AMOUNT, self::AMOUNT]);
        $expectedHash = '0x6d9b0dd883e0820f1915c6998ee2b25fcbcb5534bb3ffe6b14b59da84ff35d34';
        $this->assertEquals($expectedHash, $hash1);
        $this->assertEquals($expectedHash, $hash2);
        $this->assertEquals($expectedHash, $hash3);
        $this->assertEquals($expectedHash, $hash4);
    }
}
