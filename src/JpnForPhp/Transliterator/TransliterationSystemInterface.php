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
 * Transliteration system interface
 */
interface TransliterationSystemInterface
{
    /**
     * Transliterate a string from an alphabet into another alphabet as per a 
     * specific transliteration system.
     *
     * @param string $str The string to be converted.
     *
     * @return string Converted string.
     */
    public function transliterate($str);

    /**
     * Implement magic method __toString().
     */
    public function __toString();
}
