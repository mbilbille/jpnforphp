<?php

/*
 * This file is part of the JpnForPhp package.
 *
 * (c) Matthieu Bilbille
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JpnForPhp\Converter;

/**
 * Provides useful methods for Japanese units conversion.
 *
 * @author Matthieu Bilbille
 */
class Converter
{

    /**
     * Numeral conversion type
     */
    const NUMERAL_KANJI = 0;
    const NUMERAL_KANJI_LEGAL = 1;
    const NUMERAL_READING = 2;

    // Mapping between digits and kanjis
    private static $mapDigitsKanji = array(
        1 => '一',
        2 => '二',
        3 => '三',
        4 => '四',
        5 => '五',
        6 => '六',
        7 => '七',
        8 => '八',
        9 => '九'
    );

    // Mapping between digits and legal use kanjis
    private static $mapDigitsKanjiLegal = array(
        1 => '壱',
        2 => '弐',
        3 => '参',
        4 => '四',
        5 => '五',
        6 => '六',
        7 => '七',
        8 => '八',
        9 => '九'
    );

    // Mapping between digits and readings
    private static $mapDigitsReading = array(
        1 => 'ichi',
        2 => 'ni',
        3 => 'san',
        4 => 'yon',
        5 => 'go',
        6 => 'roku',
        7 => 'nana',
        8 => 'hachi',
        9 => 'kyū'
    );

    // Mapping powers of ten and kanjis
    private static $mapPowersOfTenKanji = array(
        1 => '十',
        2 => '百',
        3 => '千',
        4 => '万',
        8 => '億',
        12 => '兆',
        16 => '京'
    );

    // Mapping powers of ten and legal use kanjis
    private static $mapPowersOfTenKanjiLegal = array(
        1 => '拾',
        2 => '百',
        3 => '千',
        4 => '万',
        8 => '億',
        12 => '兆',
        16 => '京'
    );

    // Mapping powers of ten and readings
    private static $mapPowersOfTenReading = array(
        1 => 'jū',
        2 => 'hyaku',
        3 => 'sen',
        4 => 'man',
        8 => 'oku',
        12 => 'chō',
        16 => 'kei'
    );

    // Mapping numeral and their exceptions
    private static $readingExceptions = array(
        300 => 'sanbyaku',
        600 => 'roppyaku',
        800 => 'happyaku',
        1000 => 'issen',
        3000 => 'sanzen',
        8000 => 'hassen',
        1000000000000 => 'ichō',
        8000000000000 => 'hatchō'
    );

    /**
     * Converts a number in Arabic/Western format into Japanese numeral.
     *
     * @param integer $number The input number.
     *
     * @param int $type
     * @return string The Japanese numeral.
     * @throws Exception
     */
    public static function toJapaneseNumeral($number, $type = self::NUMERAL_KANJI)
    {
        // Return fast on zero
        if ($number == 0) {
            if ($type == self::NUMERAL_READING) {
                return 'zero';
            } else {
                return '〇';
            }
        }
        $separator = '';
        switch ($type) {
            case self::NUMERAL_KANJI:
                $mapPowersOfTen = self::$mapPowersOfTenKanji;
                $mapDigits = self::$mapDigitsKanji;
                break;
            case self::NUMERAL_KANJI_LEGAL:
                $mapPowersOfTen = self::$mapPowersOfTenKanjiLegal;
                $mapDigits = self::$mapDigitsKanjiLegal;
                break;
            case self::NUMERAL_READING:
                $mapPowersOfTen = self::$mapPowersOfTenReading;
                $mapDigits = self::$mapDigitsReading;
                $separator = ' ';
                break;
            default:
                throw new Exception('Unknown type');
        }
        $exponent = strlen($number) - 1;
        if ($exponent > 4) {
            $exponentRemainder = $exponent % 4;
            $closestExponent = $exponent - $exponentRemainder;
            $power = pow(10, $closestExponent);
            $remainder = $number % $power;
            $roundPart = $number - $remainder;
            $multiplier = (int)(($number - $remainder) / $power);
            if ($type != self::NUMERAL_READING || !array_key_exists($roundPart, self::$readingExceptions)) {
                $result = self::toJapaneseNumeral($multiplier, $type) . $separator . $mapPowersOfTen[$closestExponent];
            } else {
                $result = self::$readingExceptions[$roundPart];
            }
            if ($remainder != 0) {
                $result .= rtrim($separator . self::toJapaneseNumeral($remainder, $type));
            }
            return $result;
        } else {
            $result = '';
            while ($exponent > 0) {
                $power = pow(10, $exponent);
                $remainder = $number % $power;
                $roundPart = $number - $remainder;
                $multiplier = (int)(($number - $remainder) / $power);
                if ($type != self::NUMERAL_READING || !array_key_exists($roundPart, self::$readingExceptions)) {
                    if ($multiplier != 1 || $exponent == 4) {
                        $result .= $mapDigits[$multiplier] . $separator;
                    }
                    $result .= $mapPowersOfTen[$exponent] . $separator;
                } else {
                    $result .= self::$readingExceptions[$roundPart] . $separator;
                }
                $number = $remainder;
                $exponent = strlen($number) - 1;
            }
            if ($number != 0) {
                $result .= $mapDigits[$number];
            }
            return $result;
        }
    }
}