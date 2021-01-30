<?php
declare(strict_types=1);

namespace App\Utils;

class Alpha
{
    const TRANSLATION_TO_CHAR_OFFSET = 64;
    const TRANSLATION_TO_INT_OFFSET = 96;

    public static function transformToAlpha(int $number): string
    {
      return chr($number+self::TRANSLATION_TO_CHAR_OFFSET);
    }

    public static function transformToInt(string $string): int
    {
        return ord($string)-self::TRANSLATION_TO_INT_OFFSET;
    }

}
