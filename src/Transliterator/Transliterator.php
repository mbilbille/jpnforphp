<?php

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
    function fromHiragana($str);

    /**
     * Transliterate a string from katakana into latin alphabet as per a 
     * specific romanization system.
     *
     * @param $str
     *   The string to be converted.
     * @return string
     *   Converted string into hiragana.
     */
    function fromKatakana($str);
    

    /**
     * Transliterate Sokuon (http://en.wikipedia.org/wiki/Sokuon) character into 
     * its equivalent in latin alphabet.
     *
     * @param $str
     *   String to be transliterated.
     * @return string
     *   Transliterated string.
     */
    function transliterateSokuon($str);

    /**
     * Transliterate Chōonpu (http://en.wikipedia.org/wiki/Chōonpu) character 
     * into its equivalent in latin alphabet.
     *
     * @param $str
     *   String to be transliterated.
     * @return string
     *   Transliterated string.
     */
    function transliterateChoonpu($str);
}