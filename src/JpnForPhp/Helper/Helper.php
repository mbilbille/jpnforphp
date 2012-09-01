<?php

/*
 * This file is part of the JpnForPhp package.
 *
 * (c) Matthieu Bilbille
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JpnForPhp\Helper;

use JpnForPhp\Analyzer\Analyzer;

/**
 * Provides useful utilities to manipulate Japanese strings.
 *
 * @author Matthieu Bilbille
 */
class Helper
{
    const PREG_PATTERN_KANJI = '/\p{Han}/u';
    const PREG_PATTERN_HIRAGANA = '/\p{Hiragana}/u';
    const PREG_PATTERN_KATAKANA = '/\p{Katakana}|ー/u';
    const PREG_PATTERN_NOT_KANJI = '/\p{^Han}/u';
    const PREG_PATTERN_NOT_HIRAGANA = '/\p{^Hiragana}/u';
    const PREG_PATTERN_NOT_KATAKANA = '/[^\p{Katakana}|ー]/u';
    
    /**
     * Enhance default splitter function to handle UTF-8 characters.
     *
     * @param string $str The string to split.
     * @param integer $length (optional) Define an optional substring length. 
     * Default to 1.
     * 
     * @return array An array of strings.
     */
    public static function split($str, $length = 1)
    {
        $chrs = array();
        $str_length = Analyzer::length($str);
        for ($i = 0; $i < $str_length; $i++) {
            $chrs[] = mb_substr($str, $i, $length, 'UTF-8');
        }

        return $chrs;
    }

    /**
     * Returns a new string that is a substring of the given string.
     *
     * @param string $str The input string.
     * @param integer $begin The beginning index, inclusive.
     * @param integer $len Maximum number of characters to use from str.
     *
     * @return string A substring
     *
     * @see mb_substr()
     */
    public static function subString($str, $begin, $len)
    {
        return mb_substr($str, $begin, $len, 'UTF-8');
    }

    /**
     * Returns the character at the specified index.
     *
     * @param string $str The input string.
     * @param integer $index The index of the character to return (0 based 
     * indexing).
     *
     * @return string The character at the specified index.
     *
     * @see subString()
     */
    public static function charAt($str, $index)
    {
        return self::subString($str, $index, 1);
    }

    /**
     * Split a given string to extract kanji substrings.
     *
     * @param string $str The input string.
     *
     * @return array An array of kanji substrings.
     */
    public static function extractKanji($str)
    {
        return preg_split(self::PREG_PATTERN_NOT_KANJI, $str, 0, PREG_SPLIT_NO_EMPTY);
    }

    /**
     * Split a given string to extract hiragana substrings.
     *
     * @param string $str The input string.
     *
     * @return array An array of hiragana substrings.
     */
    public static function extractHiragana($str)
    {
        return preg_split(self::PREG_PATTERN_NOT_HIRAGANA, $str, 0, PREG_SPLIT_NO_EMPTY);
    }

    /**
     * Split a given string to extract katakana substrings.
     *
     * @param string $str The input string.
     *
     * @return array An array of katakana substrings.
     */
    public static function extractKatakana($str)
    {
        return preg_split(self::PREG_PATTERN_NOT_KATAKANA, $str, 0, PREG_SPLIT_NO_EMPTY);
    }

    /**
     * Remove hidden LTR Mark character where trim() and variant will ignore it.
     *
     * @param string $str The input string.
     * @return string A cleaned string.
     */
    public static function removeLTRM($str)
    {
        return preg_replace('/\xe2\x80\x8e/', '', $str);
    }

    /**
     * Remove diacritics from the specified string.
     *
     * @param $str The input string.
     *
     * @return string Cleaned string.
     *
     * @see split()
     */
    public static function removeDiacritics($str)
    {
        $newChars = array();
        $chars = self::split($str);
        if (!empty($chars)) {
            foreach ($chars as $char) {
                $newChar = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $char);
                if ($newChar != $char) {
                    $newChar = preg_replace('/\p{P}|\^|\`|~/u', '', $newChar);
                }
                $newChars[] = $newChar;
            }
        }

        return implode('', $newChars);
    }
}
