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
use JpnForPhp\Helper\Helper;

/**
 * Kana transliteration system class
 */
class Kana extends TransliterationSystem
{
    const STRIP_WHITESPACE_NONE = 0;
    const STRIP_WHITESPACE_ALL = 1;
    const STRIP_WHITESPACE_AUTO = 2;
    const STRIP_WHITESPACE_AUTO_NB_SPACES = 2;
    
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
     * Override transliterate().
     *
     * @see TransliterationSystem
     */
    public function transliterate($str, $stripwhitespace = self::STRIP_WHITESPACE_NONE)
    {
        $str = parent::transliterate($str);
        
        // Strip whitespace(s) here
        switch($stripwhitespace) {
            case self::STRIP_WHITESPACE_AUTO:
                if(Helper::countSubString($str, '　') > self::STRIP_WHITESPACE_AUTO_NB_SPACES) {
                    break;
                }
            case self::STRIP_WHITESPACE_ALL:
                $str = preg_replace('/\s/u', '', $str);
                break;
        }
        return $str;
    }

    /**
     * Override preTransliterate().
     *
     * @see TransliterationSystem
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
     * @param array  $parameters Long vowels mapping.
     *
     * @return string Prepared string.
     */
    protected function prepareLongVowelsTransliteration($str, $parameters)
    {
        return strtr($str, $parameters['long-vowels']);
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
     * @param array  $parameters Sokuon character.
     *
     * @return string Transliterated string.
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
     * @param string $str        String to be converted.
     * @param array  $parameters Characters mapping.
     *
     * @return string Converted string.
     */
    protected function transliterateDefaultCharacters($str, $parameters)
    {
        return strtr($str, $parameters['mapping']);
    }

    /**
     * Hack to call Helper::convertHiraganaToKatakana() within the
     * transliteration workflow.
     *
     * @param string $str String to be converted.
     *
     * @return string Converted string.
     *
     * @see JpnForPhp\Helper\Helper::convertHiraganaToKatakana()
     */
    protected function convertHiraganaToKatakana($str)
    {
        return Helper::convertHiraganaToKatakana($str);
    }
}
