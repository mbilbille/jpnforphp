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
     * @param string                $str            The input string.
     * @param RomanizationInterface $transliterator A romanization instance.
     *
     * @return string Converted string into romaji.
     */
    public static function toRomaji($str, RomanizationInterface $transliterator = NULL)
    {
        $output = $str;

        if (is_null($transliterator)) {
            // Set default system to Hepburn
            $transliterator = new Hepburn();
        } elseif (!$transliterator instanceof RomanizationInterface) {
            return $output;
        }

        return $transliterator->transliterate($str);
    }

    /**
     * Convert a given string into kana (either hiragana or katakana).
     *
     * @param string $str       The input string.
     * @param string $syllabary The syllabary flag.
     *
     * @return string Converted string into kana.
     */
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
