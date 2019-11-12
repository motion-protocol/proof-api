<?php


namespace ProofRegistry\Infrastructure\Services;


use Exception;
use kornrunner\Keccak;
use ProofRegistry\Domain\Shared\Services\Hash;

class AbiHash implements Hash
{

    /**
     * @param array $addresses
     * @param array $amounts
     * @return string
     * @throws Exception
     */
    public static function hash(array $addresses, array $amounts): string
    {
        $bin = hex2bin(self::abiEncode($addresses, $amounts));

        return '0x' . Keccak::hash($bin, 256);
    }

    private static function abiEncode(array $addresses, array $amounts): string
    {
        $word1 = '0000000000000000000000000000000000000000000000000000000000000020';
        $word2 = self::sizeHex32($addresses);

        $hex20Addresses = array_map(function ($address) {
            return self::hex20($address);
        }, $addresses);

        $hex12Amounts = array_map(function ($amount) {
            return self::hex12($amount);
        }, $amounts);

        uasort($hex20Addresses, function ($a, $b) {
            $aInteger = hexdec($a);
            $bInteger = hexdec($b);
            $diff = $aInteger - $bInteger;

            return max(min($diff, 1), -1);
        });

        $words = [];
        foreach ($hex20Addresses as $key => $hex20Address) {
            $words[] = $hex20Address . $hex12Amounts[$key];
        }

        $words = array_merge([$word1, $word2], $words);

        return implode("", $words);
    }

    /**
     * @param array $anArray
     * @return string
     */
    private static function sizeHex32(array $anArray): string
    {
        $size = count($anArray);

        return self::hex32($size);
    }

    /**
     * @param int $aNumber
     * @return string
     */
    private static function hex32(int $aNumber): string
    {
        $hexNumber = dechex($aNumber);
        $zeros = str_repeat('0', 64);
        $hex32 = $zeros . $hexNumber;
        while (strlen($hex32) > 64) {
            $hex32 = substr($hex32, 1);
        }

        return $hex32;
    }

    /**
     * @param int $aNumber
     * @return string
     */
    private static function hex20(string $aNumber): string
    {
        $zeros = str_repeat('0', 40);
        $hex20 = $zeros . $aNumber;
        while (strlen($hex20) > 40) {
            $hex20 = substr($hex20, 1);
        }

        return $hex20;
    }

    /**
     * @param int $aNumber
     * @return string
     */
    private static function hex12(int $aNumber): string
    {
        $hexNumber = dechex($aNumber);
        $zeros = str_repeat('0', 24);
        $hex12 = $zeros . $hexNumber;
        while (strlen($hex12) > 24) {
            $hex12 = substr($hex12, 1);
        }

        return $hex12;
    }
}
