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

use JpnForPhp\Transliterator\Hepburn;

/**
 * Provides utilities to transliterate Japanese strings into various 
 * syllabaries.
 *
 * @author Matthieu Bilbille
 */
class Transliterator
{
    const HIRAGANA = 'hiragana';
    const KATAKANA = 'katakana';
    const SOKUON_HIRAGANA = 'っ';
    const SOKUON_KATAKANA = 'ッ';
    const CHOONPU = 'ー';

    /**
     * Wrap all romaji transliteration functions and perform intelligente 
     * verification to properly convert a given string into romaji.
     *
     * @param string $str The input string.
     * @param TransliteratorInterface $transliterator A transliterator instance.
     * @param integer $syllabary Force source syllabary.
     *
     * @return string Converted string into romaji.
     */
    public static function toRomaji($str, $syllabary = NULL, TransliteratorInterface $transliterator = NULL)
    {
        $output = $str;

        if(is_null($transliterator)){
            // Set default system to Hepburn
            $transliterator = new Hepburn();
        }
        elseif(!$transliterator instanceof TransliteratorInterface) {
            return $output;
        }

        if (!is_null($syllabary)) {
            // Force source syllabary
            if ($syllabary === self::HIRAGANA) {
                $output = $transliterator->fromHiragana($str);
            } elseif ($syllabary === self::KATAKANA) {
                $output = $transliterator->fromKatakana($str);
            }
        } else {
                // Rather than guessing the appropriate syllabary, process both.
            $output = $transliterator->fromHiragana($str);
            $output = $transliterator->fromKatakana($output);
        }

        return $output;
    }


    public static function toKana($str, $syllabary){
        return $str;
    }
}
