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
use JpnForPhp\Helper\Helper;

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
     * @param string                $str            The input string.
     * @param RomanizationInterface $transliterator A romanization instance.
     * @param integer               $syllabary      Force source syllabary.
     *
     * @return string Converted string into romaji.
     */
    public static function toRomaji($str, $syllabary = NULL, RomanizationInterface $transliterator = NULL)
    {
        $output = $str;

        if (is_null($transliterator)) {
            // Set default system to Hepburn
            $transliterator = new Hepburn();
        } elseif (!$transliterator instanceof RomanizationInterface) {
            return $output;
        }

        $parts_in_latin = array();
        $has_latin_parts = preg_match_all(
                                Helper::PREG_PATTERN_JAPANESE_MULTI
                                , $str
                                , $parts_in_latin
                                , PREG_PATTERN_ORDER);

        if($has_latin_parts) {
            $str = preg_replace(
                        Helper::PREG_PATTERN_JAPANESE_MULTI
                        ,'%s'
                        , $str);
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

        if($has_latin_parts) {
            $output = vsprintf($output, $parts_in_latin[0]);
        }

        return $output;
    }

    public static function toKana($str, $syllabary)
    {
        $output = $str;
        $transliterator = new Kana();

        if ($syllabary === self::HIRAGANA) {
            $output = $transliterator->toHiragana($str);
        } elseif ($syllabary === self::KATAKANA) {
            $output = $transliterator->toKatakana($str);
        }

        return $output;
    }
}
