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
interface RomanizationInterface
{
    /**
     * Transliterate a string from hiragana/katakana into latin alphabet as per 
     * a specific romanization system.
     *
     * @param string $str The string to be converted.
     *
     * @return string Converted string into latin alphabet.
     */
    public function transliterate($str);

    /**
     * Implement magic method __toString().
     */
    public function __toString();
}
