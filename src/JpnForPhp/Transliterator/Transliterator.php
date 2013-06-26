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
     * @param string                $str        The input string.
     * @param RomanizationInterface $system     A romanization instance.
     *
     * @return string Converted string into romaji.
     */
    public static function toRomaji($str, RomanizationInterface $system = NULL)
    {
        $output = $str;

        if (is_null($system)) {
            // Set default system to Hepburn
            $system = new Hepburn();
        } elseif (!$system instanceof RomanizationInterface) {
            return $output;
        }

        return $system->transliterate($str);
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
        $system = new Kana();

        if ($syllabary === self::HIRAGANA) {
            $output = $system->toHiragana($str);
        } elseif ($syllabary === self::KATAKANA) {
            $output = $system->toKatakana($str);
        }

        return $output;
    }
}
