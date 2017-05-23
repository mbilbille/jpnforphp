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

/**
 * Transliteration system class to support transliteration into Romaji alphabet.
 *
 * @author Matthieu Bilbille (@mbibille)
 */
abstract class Romaji implements System
{
    /**
     * @var array Store latin characters which are escaped.
     */
    private $latinCharacters = array();


    /**
     * Prepare given string for transliteration
     *
     * @param string $str        String to be transliterated.
     *
     * @return string A string ready for transliteration.
     */
    protected function preTransliterate($str)
    {
        $str = $this->escapeLatinCharacters($str);
        $str = mb_convert_kana($str, 'c', 'UTF-8');

        return $str;
    }


    /**
     * Postprocess string after transliteration
     *
     * @param string $str        String transliterated.
     *
     * @return string A string ready for output.
     */
    protected function postTransliterate($str)
    {
        $str = $this->unescapeLatinCharacters($str);

        return $str;
    }


    /**
     * Use the specified mapping to transliterate the given string into romaji
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


    /**
     * Transliterate Sokuon (http://en.wikipedia.org/wiki/Sokuon) character into
     * its equivalent in latin alphabet.
     *
     * @param string $str        String to be transliterated.
     *
     * @return string Transliterated string.
     */
    protected function transliterateSokuon($str)
    {
        return preg_replace('/[っッ](.)/u', '${1}${1}', $str);
    }


    /**
     * Transliterate Chōonpu (http://en.wikipedia.org/wiki/Chōonpu) character
     * into its equivalent in latin alphabet.
     *
     * @param string $str        String to be transliterated.
     * @param array  $macrons    Macrons mapping.
     *
     * @return string Transliterated string.
     */
    protected function transliterateChoonpu($str, $macrons)
    {
        $keys = array_keys($macrons);
        $pattern = '/([' . implode('', $keys) . '])ー/u';

        return preg_replace_callback($pattern, function($matches) use ($macrons) {
            return $macrons[$matches[1]];
        }, $str);
    }


    /**
     * Transliterate long vowels as per the given mapping.
     *
     * @param string $str        String to be transliterated.
     * @param array  $longVowels Long vowels mapping.
     *
     * @return string Transliterated string.
     */
    protected function transliterateLongVowels($str, $longVowels)
    {
        return str_replace(array_keys($longVowels), array_values($longVowels), $str);
    }


    /**
     * Transliterate particules as per the given mapping.
     *
     * @param string $str        String to be transliterated.
     * @param array  $particles  Particles mapping.
     *
     * @return string Transliterated string.
     */
    protected function transliterateParticles($str, $particles)
    {
        return str_replace(array_keys($particles), array_values($particles), $str);
    }


    /**
     * Transliterate character 'n' to 'm' before labial consonants.
     *
     * @param string $str        String to be transliterated.
     *
     * @return string Transliterated string.
     */
    protected function transliterateNBeforeLabialConsonants($str)
    {
        return preg_replace('/n([bmp])/u', 'm$1', $str);
    }


    /**
     * Escapes latin characters [a-z].
     */
    private function escapeLatinCharacters($str)
    {
        $str = preg_replace_callback('/([a-z]+)/', array($this, "espaceLatinCharactersCallback"), $str);

        return $str;
    }


    /**
     * Private callback for escapeLatinCharacters().
     */
    private function espaceLatinCharactersCallback($matches)
    {
        $this->latinCharacters[] = $matches[1];

        return '%s';
    }


    /**
     * Unescapes latin characters [a-z].
     */
    private function unescapeLatinCharacters($str)
    {
        if ($this->latinCharacters) {
            $str = vsprintf($str, $this->latinCharacters);
            $this->latinCharacters = array();
        }

        return $str;
    }
}
