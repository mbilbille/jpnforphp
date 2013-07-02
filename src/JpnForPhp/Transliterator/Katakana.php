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

/**
 * Katakana transliteration system class
 */
class Katakana extends Kana
{
    /**
     * @var string Sokuon character in katakana.
     */
    const SOKUON = 'ッ';
    
    /**
     * Katakana's constructor
     */
    public function __construct()
    {
        $this->mapLatin += $this->mapPunctuationMarks;   
    }
    
    /**
     * Implements __toString().
     *
     * @see TransliterationSystemInterface
     */
    public function __toString()
    {
        return 'Katakana transliteration system';
    }
    
    
    /**
     * Transliterate a string from latin alphabet into katakana.
     *
     * @param string $str The string to be converted.
     *
     * @return string Converted string into katakana.
     */
    public function transliterate($str)
    {
        $str = $this->prepareTransliteration($str);
        $str = $this->transliterateSokuon($str);
        $str = $this->transliterateQuotationMarks($str);
        $hiragana = strtr($str, $this->mapLatin);
        $katakana = mb_convert_kana($hiragana, 'C', 'UTF-8');

        return $katakana;
    }

    /**
     * Prepare a string for its transliteration in kana.
     *
     * @param string $str String to be prepared.
     *
     * @param string $syllabary Syllabary to use
     *
     * @return string Prepared string.
     */
    protected function prepareTransliteration($str)
    {
        $str = mb_strtolower($str, 'UTF-8');
        $mapChars = array();
        
        // Consonant followed by two of the same vowel
        $consonant = 'bcdfghjklmnpqrstvwyz';
        $prepared_s = preg_replace_callback('/(^[' . $consonant . '])(aa|ii|uu|ee|oo)/u', function($matches){
            return $matches[1].substr($matches[2], 1) . 'ー';
        }, $str);
        
        // Vowel with macron
        $mapChars = array(
            'ā' => 'aー',
            'ī' => 'iー',
            'ū' => 'uー',
            'ē' => 'eー',
            'ō' => 'oー',
            'â' => 'aー',
            'î' => 'iー',
            'û' => 'uー',
            'ê' => 'eー',
            'ô' => 'oー',
        );
        return strtr($prepared_s, $mapChars);
    }
}