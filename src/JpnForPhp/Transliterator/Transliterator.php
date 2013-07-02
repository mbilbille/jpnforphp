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
    /**
     * Wrap all romaji transliteration functions and perform intelligente
     * verification to properly convert a given string into romaji.
     *
     * @param string    $str        The input string.
     * @param Romaji    $system     A romanization system instance.
     *
     * @return string Converted string into romaji.
     */
    public static function toRomaji($str, Romaji $system = NULL)
    {
        $output = $str;

        if (is_null($system)) {
            // Set default system to Hepburn
            $system = new Hepburn();
        } elseif (!$system instanceof TransliterationSystemInterface) {
            return $output;
        }

        return $system->transliterate($str);
    }

    /**
     * Convert a given string into kana (either hiragana or katakana).
     *
     * @param string    $str       The input string.
     * @param Kana      $system    A kana"nization" system instance.
     *
     * @return string Converted string into kana.
     */
    public static function toKana($str, Kana $system = NULL)
    {
        $output = $str;

        if (is_null($system)) {
            // Set default system to Hiragana
            $system = new Hiragana();
        } elseif (!$system instanceof TransliterationSystemInterface) {
            return $output;
        }
        
        return $system->transliterate($str);
    }
}
