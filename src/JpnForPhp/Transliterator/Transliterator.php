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

use JpnForPhp\Transliterator\System\System;

/**
 * Transliterate Japanese into various alphabet, and vice versa
 *
 * @author Matthieu Bilbille (@mbibille)
 */
class Transliterator
{
    private $system;

    /**
     * Transliterator's constructors
     */
    public function setSystem(System $system) {
        $this->system = $system;
        return $this;
    }

    /**
     * Transliterate a string from an alphabet into another alphabet.
     *
     * @param string $str The string to be converted.
     *
     * @return string Converted string.
     */
    public function transliterate($str) {
        if(is_null($this->system)) {
            throw new RuntimeException("Transliteration system is not defined");
        }
        return $this->system->transliterate($str);
    }
}
