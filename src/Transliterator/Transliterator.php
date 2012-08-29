<?php

namespace JpnForPhp\Transliterator;

/**
 * Transliterator abstract class
 */
interface Transliterator
{
    /**
     * Transliterate a string from hiragana into latin alphabet as per a
     * specific romanization system.
     *
     * @param $str
     *   The string to be converted.
     * @return string
     *   Converted string into hiragana.
     */
    public function fromHiragana($str);

    /**
     * Transliterate a string from katakana into latin alphabet as per a
     * specific romanization system.
     *
     * @param $str
     *   The string to be converted.
     * @return string
     *   Converted string into hiragana.
     */
    public function fromKatakana($str);

    /**
     * Transliterate Sokuon (http://en.wikipedia.org/wiki/Sokuon) character into
     * its equivalent in latin alphabet.
     *
     * @param $str
     *   String to be transliterated.
     * @return string
     *   Transliterated string.
     */
    public function transliterateSokuon($str);

    /**
     * Transliterate Chōonpu (http://en.wikipedia.org/wiki/Chōonpu) character
     * into its equivalent in latin alphabet.
     *
     * @param $str
     *   String to be transliterated.
     * @return string
     *   Transliterated string.
     */
    public function transliterateChoonpu($str);
}
