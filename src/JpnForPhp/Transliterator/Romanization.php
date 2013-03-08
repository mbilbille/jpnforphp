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
 * Romanization system interface
 */
abstract class Romanization implements RomanizationInterface
{
    // Characters to espace before the romanization process.
    const PREG_PATTERN_ESCAPE_CHAR =  '/([a-z]+)/';

    public $latinCharacters = array();

    /**
     * Escapes latin characters [a-z].
     */
    protected function escapeLatinCharacters($str)
    {
        $obj = $this;
        $str = preg_replace_callback(Romanization::PREG_PATTERN_ESCAPE_CHAR, function($matches) use ($obj) {
            $obj->latinCharacters[] = $matches[1];

            return '%s';
        }, $str);

        return $str;
    }

    /**
     * Unescapes latin characters [a-z].
     */
    protected function unescapeLatinCharacters($str)
    {
        if ($this->latinCharacters) {
            $str = vsprintf($str, $this->latinCharacters);
        }

        return $str;
    }

    /**
     * Transliterate Sokuon (http://en.wikipedia.org/wiki/Sokuon) character into
     * its equivalent in latin alphabet.
     *
     * @param string $str String to be transliterated.
     *
     * @param string $syllabary Syllabary to use
     *
     * @return string Transliterated string.
     */
    protected function transliterateSokuon($str, $syllabary = Transliterator::HIRAGANA)
    {
        if ($syllabary === Transliterator::KATAKANA) {
            $sokuon = Transliterator::SOKUON_KATAKANA;
        } else {
            $sokuon = Transliterator::SOKUON_HIRAGANA;
        }

        $output = preg_replace('/' . $sokuon . '(.)/u', '${1}${1}', $str);

        return $output;
    }

    /**
     * Transliterate Chōonpu (http://en.wikipedia.org/wiki/Chōonpu) character
     * into its equivalent in latin alphabet.
     *
     * @param string $str String to be transliterated.
     *
     * @return string Transliterated string.
     */
    protected function transliterateChoonpu($str)
    {
        return $str;
    }

    /**
     * Post-processing transliteration to properly format long vowels.
     *
     * @param string $str String to be processed.
     *
     * @return string Transliterated string.
     */
    protected function convertLongVowels($str)
    {
        return $str;
    }

    /**
     * Post-processing transliteration to properly format particles.
     *
     * @param string $str String to be processed.
     *
     * @return string Transliterated string.
     */
    protected function convertParticles($str)
    {
        return $str;
    }
}
