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
 * Transliteration system interface to transliterate Japanese into various
 * alphabet.
 *
 * @author Matthieu Bilbille (@mbibille)
 */
interface System
{
    /**
     * Transliterate a string from an alphabet into another alphabet.
     *
     * @param string $str The string to be converted.
     *
     * @return string Converted string.
     */
    function transliterate($str);


    /**
     * Implement magic method __toString().
     */
    function __toString();
}
