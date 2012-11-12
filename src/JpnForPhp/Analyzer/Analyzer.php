<?php

/*
 * This file is part of the JpnForPhp package.
 *
 * (c) Matthieu Bilbille
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JpnForPhp\Analyzer;

use JpnForPhp\Helper\Helper;

/**
 * Provides useful utilities to analyze Japanese strings & characters.
 *
 * @author Matthieu Bilbille
 */
class Analyzer
{

    /**
     * Get string length.
     *
     * @param string $str The string being measured for length.
     *
     * @return integer Returns the number of characters in the input string. A
     * multi-byte character is counted as 1.
     *
     * @see mb_strlen()
     */
    public static function length($str)
    {
        return mb_strlen($str, 'UTF-8');
    }

    /**
     * Inspects a given string and returns useful details about it.
     *
     * @param string $str The string to be inspected.
     *
     * @return array An associative array containing the following items:
     *   - "length" : string length.
     *   - "kanji" : number of kanji within this string.
     *   - "hiragana" : number of hiragana within this string.
     *   - "katakana" : number of katakana within this string.
     *
     * @see length()
     * @see countKanji()
     * @see countHiragana()
     * @see countKatakana()
     */
    public static function inspect($str)
    {
        $result = array(
            'length' => 0,
            'kanji' => 0,
            'hiragana' => 0,
            'katakana' => 0,
            );

        $result['length'] = self::length($str);
        $result['kanji'] = self::countKanji($str);
        $result['hiragana'] = self::countHiragana($str);
        $result['katakana'] = self::countKatakana($str);

        return $result;
    }

    /**
     * Count number of kanji within the specified string.
     *
     * @param string $str The input string.
     *
     * @return integer Returns the number of kanji.
     */
    public static function countKanji($str)
    {
        $matches = array();

        return preg_match_all(Helper::PREG_PATTERN_KANJI, $str, $matches);
    }

    /**
     * Count number of hiragana within the specified string.
     *
     * @param string $str The input string.
     *
     * @return integer Returns the number of hiragana.
     */
    public static function countHiragana($str)
    {
        $matches = array();

        return preg_match_all(Helper::PREG_PATTERN_HIRAGANA, $str, $matches);
    }

    /**
     * Count number of katakana within the specified string. Chōonpu
     * (http://en.wikipedia.org/wiki/Chōonpu) is considered as Katakana here.
     *
     * @param string $str The input string.
     *
     * @return integer Returns the number of katakana
     */
    public static function countKatakana($str)
    {
        $matches = array();

        return preg_match_all(Helper::PREG_PATTERN_KATAKANA, $str, $matches);
    }

    /**
     * Determines whether the given string contains kanji characters.
     *
     * @param string $str The string to inspect.
     *
     * @return boolean TRUE if it contains at least one kanji, otherwise FALSE.
     */
    public static function hasKanji($str)
    {
        return preg_match(Helper::PREG_PATTERN_KANJI, $str) > 0;
    }

    /**
     * Determines whether the given string contains hiragana characters.
     *
     * @param string $str The string to inspect.
     *
     * @return boolean TRUE if it contains at least one hiragana, otherwise
     * FALSE.
     */
    public static function hasHiragana($str)
    {
        return preg_match(Helper::PREG_PATTERN_HIRAGANA, $str) > 0;
    }

    /**
     * Determines whether the given string contains katakana characters.
     *
     * @param string $str The string to inspect.
     *
     * @return boolean TRUE if it contains at least one katakana, otherwise
     * FALSE.
     */
    public static function hasKatakana($str)
    {
        return preg_match(Helper::PREG_PATTERN_KATAKANA, $str) > 0;
    }

    /**
     * Determines whether the given string contains kana (hiragana or katakana).
     *
     * @param  string  $str The string to inspect.
     * @return boolean TRUE if it contains either hiragana or katakana,
     * otherwise FALSE.
     *
     * @see hasHiragana()
     * @see hasKatakana()
     */
    public static function hasKana($str)
    {
        return self::hasHiragana($str) || self::hasKatakana($str);
    }

    /**
     * Determines whether the given string contains Japanese characters (kanji,
     * hiragana or katakana).
     *
     * @param string $str The string to inspect.
     *
     * @return boolean TRUE if it contains either kanji, hiragana or katakana,
     * otherwise FALSE.
     *
     * @see hasKanji()
     * @see hasHiragana()
     * @see hasKatakana()
     */
    public static function hasJapaneseChars($str)
    {
        return self::hasKanji($str) || self::hasHiragana($str) || self::hasKatakana($str);
    }
}
