<?php

/*
 * This file is part of the JpnForPhp package.
 *
 * (c) Matthieu Bilbille
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JpnForPhp\Transliterator\System;

use JpnForPhp\Analyzer\Analyzer;
use JpnForPhp\Helper\Helper;

/**
 * Transliteration system class to support transliteration into Kana alphabet:
 *  - Hiragana
 *  - Katakana
 *
 * @author Matthieu Bilbille (@mbibille)
 */
abstract class Kana implements System
{
    const STRIP_WHITESPACE_NONE = 0;
    const STRIP_WHITESPACE_ALL = 1;
    const STRIP_WHITESPACE_AUTO = 2;
    const STRIP_WHITESPACE_AUTO_NB_SPACES = 2;


    /**
     * Prepare given string for transliteration
     *
     * @param string $str        String to be transliterated.
     *
     * @return string A string ready for transliteration.
     */
    protected function preTransliterate($str)
    {
        return preg_replace_callback('/([A-Z]|Ā|Â|Ē|Ê|Ī|Î|Ō|Ô|Ū|Û)([a-z]|ā|â|ē|ê|ī|î|ō|ô|ū|û)/u', function($matches) {
            return mb_strtolower($matches[1], 'UTF-8') . $matches[2];
        }, $str);
    }


    /**
     * Prepare a string for to transliterate long vowels into kana.
     *
     * @param string $str        String to be prepared.
     * @param array  $longVowels Long vowels mapping.
     *
     * @return string Prepared string.
     */
    protected function prepareLongVowelsTransliteration($str, $longVowels)
    {
        return strtr($str, $longVowels);
    }


    /**
     * Prepare a string for to transliterate choonpu into kana.
     *
     * @param string $str        String to be prepared.
     * @param array  $parameters Long vowels mapping.
     *
     * @return string Prepared string.
     */
    protected function prepareChoonpuTransliteration($str)
    {
        // Consonant followed by two of the same vowel
        $consonant = 'bcdfghjklmnpqrstvwyz';

        return preg_replace_callback('/(^[' . $consonant . '])(aa|ii|uu|ee|oo)/u', function($matches){
            return $matches[1].substr($matches[2], 1) . 'ー';
        }, $str);
    }


    /**
     * Transliterate proper combinaisons of latin alphabet characters into
     * Sokuon (http://en.wikipedia.org/wiki/Sokuon) characters.
     *
     * @param string $str        String to be transliterated.
     * @param array  $sokuon     Sokuon character.
     *
     * @return string Transliterated string.
     */
    protected function transliterateSokuon($str, $sokuon)
    {
        $new_str = $str;
        $length = Analyzer::length($str);

        //No need to go further.
        if ($length < 2) {
            return $new_str;
        }

        $skip = array('a', 'i', 'u', 'e', 'o', 'n');

        for ($i = 1; $i < $length; $i++) {
            $prev_char = substr($str, $i - 1, 1);
            if (!in_array($prev_char, $skip)) {
                // Don't forget Hepburn special case: ch > tch
                if ($prev_char === substr($str, $i, 1) || ($prev_char === 't' && substr($str, $i, 2) === 'ch')) {
                    $new_str = substr_replace($str, $sokuon, $i - 1, 1);
                }
            }
        }

        return $new_str;
    }


    /**
     * Transliterate quotation mark into their equivalent in Japanese syllabary.
     *
     * @param string $str String to be transliterated.
     *
     * @return string Transliterated string.
     */
    protected function transliterateQuotationMarks($str)
    {
        $str = preg_replace('/\'(.*)\'/u', '「${1}」', $str);
        $str = preg_replace('/"(.*)"/u', '『${1}』', $str);

        return $str;
    }


    /**
     * Convert the given string into kana using the specified mapping.
     *
     * @param string $str        String to be converted.
     * @param array  $mapping    Characters mapping.
     *
     * @return string Converted string.
     */
    protected function transliterateDefaultCharacters($str, $mapping)
    {
        return strtr($str, $mapping);
    }
}
