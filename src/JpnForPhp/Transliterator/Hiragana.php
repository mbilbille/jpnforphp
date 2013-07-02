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
 * Hiragana transliteration system class
 */
class Hiragana extends Kana
{
    /**
     * @var string Sokuon character in hiragana.
     */
    const SOKUON = 'っ';
    
    /**
     * Hiragana's constructor
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
        return 'Hiragana transliteration system';
    }
    
    /**
     * Transliterate a string from latin alphabet into hiragana.
     *
     * @param string $str The string to be converted.
     *
     * @return string Converted string into hiragana.
     */
    public function transliterate($str)
    {
        $str = $this->prepareTransliteration($str);
        $str = $this->transliterateSokuon($str);
        $str = $this->transliterateQuotationMarks($str);
        return strtr($str, $this->mapLatin);
    }
    
    /**
     * Prepare a string for its transliteration in kana.
     *
     * @param string $str String to be prepared.
     *
     * @return string Prepared string.
     */
    protected function prepareTransliteration($str)
    {
        $str = mb_strtolower($str, 'UTF-8');
        $mapChars = array(
            'ā' => 'aa', 'ī' => 'ii', 'ū' => 'uu', 'ē' => 'ee', 'ō' => 'ou',
            'â' => 'aa', 'î' => 'ii', 'û' => 'uu', 'ê' => 'ee', 'ô' => 'ou',
        );
        return strtr($str, $mapChars);
    }
}
