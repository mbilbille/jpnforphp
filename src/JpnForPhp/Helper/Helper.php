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
 * @author Matthieu Bilbille (@mbilbille)
 */
class Helper
{
    const PREG_PATTERN_KANJI = '/\p{Han}/u';
    const PREG_PATTERN_HIRAGANA = '/\p{Hiragana}/u';
    const PREG_PATTERN_KATAKANA = '/\p{Katakana}|ー/u';
    const PREG_PATTERN_KANA = '/\p{Hiragana}|\p{Katakana}|ー/u';
    const PREG_PATTERN_NOT_KANJI = '/\p{^Han}/u';
    const PREG_PATTERN_NOT_HIRAGANA = '/\p{^Hiragana}/u';
    const PREG_PATTERN_NOT_KATAKANA = '/[^\p{Katakana}ー]/u';
    const PREG_PATTERN_NOT_KANA = '/[^\p{Hiragana}|\p{Katakana}|ー]/u';
    const PREG_PATTERN_HIRAGANA_YOON = '/ゃ|ゅ|ょ|ぁ|ぃ|ぅ|ぇ|ぉ|ゎ/u';
    const PREG_PATTERN_KATAKANA_YOON = '/ャ|ュ|ョ|ァ|ィ|ゥ|ェ|ォ|ヮ/u';
    const PREG_PATTERN_KANA_YOON = '/ゃ|ゅ|ょ|ぁ|ぃ|ぅ|ぇ|ぉ|ゎ|ャ|ュ|ョ|ァ|ィ|ゥ|ェ|ォ|ヮ/u';
    const PREG_PATTERN_PUNCTUATION_MARKS = '/[、，：・。！？‥「」『』（）｛｝［］【】〜〽]/u';

    /**
     * Enhance default splitter function to handle UTF-8 characters.
     *
     * @param string  $str    The string to split.
     * @param integer $length (optional) Define an optional substring length.
     * Default to 1.
     * @param boolean $yoon (optional) Whether considering the base syllable and
     * the following yoon character as a single character or not
     * Default to false.
     *
     * @return array An array of strings.
     */
    public static function split($str, $length = 1, $yoon = false)
    {
        // First split the given string into single characters ; default and
        // most common case.
        $chrs = preg_split("//u", $str, 0, PREG_SPLIT_NO_EMPTY);
        if($length === 1 && !$yoon) {
            return $chrs;
        }

        // ... handle cases where length != 1
        $str_length = count($chrs);
        $concatChrs = array();
        for ($i = 0, $j = -1, $k = -1; $i < $str_length; $i++) {

            // With yoon set to TRUE, consider the base syllable and the yoon
            // character as a single character.
            $skip = false;
            $k++;
            if($yoon && preg_match(self::PREG_PATTERN_KANA_YOON, $chrs[$i])) {
               $skip = true;
               $k--;
            }

            if(!$skip && $k % $length === 0) {
                $j++;
                $concatChrs[$j] = $chrs[$i];
            }
            else {
                 $concatChrs[$j] .= $chrs[$i];
            }
        }

        return $concatChrs;
    }

    /**
     * Returns a new string that is a substring of the given string.
     *
     * @param string  $str   The input string.
     * @param integer $begin The beginning index, inclusive.
     * @param integer $length   Maximum number of characters to use from str.
     *
     * @return string A substring
     *
     * @see mb_substr()
     */
    public static function subString($str, $begin, $length)
    {
        return mb_substr($str, $begin, $length, 'UTF-8');
    }

    /**
     * Returns the character at the specified index.
     *
     * @param string  $str   The input string.
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
     * Counts the number of substring occurrences.
     *
     * @param string  $str    The input string.
     * @param string  $needle The string being found.
     *
     * @return integer The number of times the needle substring occurs in the 
     * input string.
     *
     * @see mb_substr_count()
     */
    public static function countSubString($str, $needle)
    {
        return mb_substr_count($str, $needle, 'UTF-8');
    }

    /**
     * Split a given string to extract kanji substrings.
     *
     * @param string $str The input string.
     * @param integer $length (optional) Define an optional substring length.
     * Default to 0 which means substrings will be returned as it is.
     *
     * @return array An array of kanji substrings.
     */
    public static function extractKanji($str, $length = 0)
    {
        // No length given, extract kanji substrings as it is.
        if(!$length) {
            return preg_split(self::PREG_PATTERN_NOT_KANJI, $str, 0, PREG_SPLIT_NO_EMPTY);
        }

        // Otherwise...
        // remove any non kanji characters and split the remaining string as per
        // the given length
        $str = preg_replace(self::PREG_PATTERN_NOT_KANJI, "", $str);
        return self::split($str, $length);
    }

    /**
     * Split a given string to extract hiragana substrings.
     *
     * @param string $str The input string.
     * @param integer $length (optional) Define an optional substring length.
     * Default to 0 which means substrings will be returned as it is.
     * @param boolean $yoon (optional) Whether considering the base syllable and
     * the following yoon character as a single character or not
     * Default to false.
     *
     * @return array An array of hiragana substrings.
     */
    public static function extractHiragana($str, $length = 0, $yoon = false)
    {
        // No length given, extract hiragana substrings as it is.
        if(!$length) {
            return preg_split(self::PREG_PATTERN_NOT_HIRAGANA, $str, 0, PREG_SPLIT_NO_EMPTY);
        }

        // Otherwise...
        // remove any non hiragana characters and split the remaining string as per
        // the given length
        $str = preg_replace(self::PREG_PATTERN_NOT_HIRAGANA, "", $str);
        return self::split($str, $length, $yoon);
    }

    /**
     * Split a given string to extract katakana substrings.
     *
     * @param string $str The input string.
     * @param integer $length (optional) Define an optional substring length.
     * Default to 0 which means substrings will be returned as it is.
     * @param boolean $yoon (optional) Whether considering the base syllable and
     * the following yoon character as a single character or not
     * Default to false.
     *
     * @return array An array of katakana substrings.
     */
    public static function extractKatakana($str, $length = 0, $yoon = false)
    {
        // No length given, extract katakana substrings as it is.
        if(!$length) {
            return preg_split(self::PREG_PATTERN_NOT_KATAKANA, $str, 0, PREG_SPLIT_NO_EMPTY);
        }

        // Otherwise...
        // remove any non katakana characters and split the remaining string as per
        // the given length
        $str = preg_replace(self::PREG_PATTERN_NOT_KATAKANA, "", $str);
        return self::split($str, $length, $yoon);
    }

    /**
     * Split a given string to extract kana substrings.
     *
     * @param string $str The input string.
     * @param integer $length (optional) Define an optional substring length.
     * Default to 0 which means substrings will be returned as it is.
     * @param boolean $yoon (optional) Whether considering the base syllable and
     * the following yoon character as a single character or not
     * Default to false.
     *
     * @return array An array of kana substrings.
     */
    public static function extractKana($str, $length = 0, $yoon = false)
    {
        // No length given, extract kana substrings as it is.
        if(!$length) {
            return preg_split(self::PREG_PATTERN_NOT_KANA, $str, 0, PREG_SPLIT_NO_EMPTY);
        }

        // Otherwise...
        // remove any non kana characters and split the remaining string as per
        // the given length
        $str = preg_replace(self::PREG_PATTERN_NOT_KANA, "", $str);
        return self::split($str, $length, $yoon);
    }

    /**
     * Enhance default trim() to trim unicode whitespace.
     *
     * @param  string $str The input string.
     * @return string A cleaned string.
     */
    public static function trim($str)
    {
        return preg_replace('/^[\pZ\pC]+|[\pZ\pC]+$/u', '', $str);
    }

    /**
     * Remove macrons from the specified string.
     *
     * Based on Wordpress remove_accents().
     *
     * @param string $str The input string.
     *
     * @return string Cleaned string.
     */
    public static function removeMacrons($str)
    {
        if ( !preg_match('/[\x80-\xff]/', $str) ) {
            return $str;
        }

        $chars = array(
            // Some romanization system may use circumflex accent rather than macron
            chr(195).chr(130) => 'A', chr(195).chr(162) => 'a',
            chr(195).chr(142) => 'I', chr(195).chr(174) => 'i',
            chr(195).chr(155) => 'U', chr(195).chr(187) => 'u',
            chr(195).chr(138) => 'E', chr(195).chr(170) => 'e',
            chr(195).chr(148) => 'O', chr(195).chr(180) => 'o',
            // Macrons
            chr(196).chr(128) => 'A', chr(196).chr(129) => 'a',
            chr(196).chr(170) => 'I', chr(196).chr(171) => 'i',
            chr(197).chr(170) => 'U', chr(197).chr(171) => 'u',
            chr(196).chr(146) => 'E', chr(196).chr(147) => 'e',
            chr(197).chr(140) => 'O', chr(197).chr(141) => 'o',
        );

        return strtr($str, $chars);
    }

    /**
     * Convert the given string from katakana to hiragana.
     * Simply wrap the mb_convert_kana function.
     *
     * @param string $str String to be converted.
     *
     * @return string Converted string.
     *
     */
    public static function convertKatakanaToHiragana($str)
    {
        return mb_convert_kana($str, 'c', 'UTF-8');
    }

    /**
     * Convert the given string from hiragana to katakana.
     * Simply wrap the mb_convert_kana function.
     *
     * @param string $str String to be converted.
     *
     * @return string Converted string.
     */
    public static function convertHiraganaToKatakana($str)
    {
        return mb_convert_kana($str, 'C', 'UTF-8');
    }
}
