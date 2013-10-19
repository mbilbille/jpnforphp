<?php

/*
 * This file is part of the JpnForPhp package.
 *
 * (c) Matthieu Bilbille
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JpnForPhp\Transliterator;

use JpnForPhp\Analyzer\Analyzer;

/**
 * Kana transliteration system class
 */
class Kana extends TransliterationSystem
{ 
    /**
     * Kana's constructor
     */
    public function __construct($system = '')
    {
        $file = __DIR__ . DIRECTORY_SEPARATOR . 'Kana' . DIRECTORY_SEPARATOR . (($system) ? $system : 'hiragana') . '.yaml';
        parent::__construct($file);
    }

    /**
     * Implements __toString().
     *
     * @see TransliterationSystemInterface
     */
    public function __toString()
    {
        return $this->configuration['name']['english'] . ' (' . $this->configuration['name']['japanese'] . ')';
    }

    /**
     * Simple wrap mb_strtolower to convert characters to lower case
     *
     * @param string $str           String to be converted
     *
     * @return string               Converted string.
     */
    protected function convertToLowerCase($str)
    {
        return  mb_strtolower($str, 'UTF-8');
    }

    /**
     * Prepare a string for to transliterate long vowels into kana.
     *
     * @param string $str           String to be prepared.
     * @param array $parameters     Long vowels mapping.
     *
     * @return string               Prepared string.
     */
    protected function prepareLongVowelsTransliteration($str, $parameters)
    {
        return strtr($str, $parameters['long-vowels']);
    }
       
    /**
     * Prepare a string for to transliterate choonpu into kana.
     *
     * @param string $str           String to be prepared.
     * @param array $parameters     Long vowels mapping.
     *
     * @return string               Prepared string.
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
     * @param string $str           String to be transliterated.
     * @param array $parameters     Sokuon character.
     *
     * @return string               Transliterated string.
     */
    protected function transliterateSokuon($str, $parameters)
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
                    $new_str = substr_replace($str, $parameters['sokuon'], $i - 1, 1);
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
     * @param string $str           String to be converted.
     * @param array $parameters     Characters mapping.
     *
     * @return string               Converted string.
     */
    protected function convertUsingMapping($str, $parameters)
    {
        return strtr($str, $parameters['mapping']);
    }

    /**
     * Convert the given string from hiragana to katakana.
     * Simply wrap the mb_convert_kana function.
     *
     * @param string $str           String to be converted.
     *
     * @return string               Converted string.     
     */
    protected function convertHiraganaToKatakana($str)
    {
        return mb_convert_kana($str, 'C', 'UTF-8');
    }
}
