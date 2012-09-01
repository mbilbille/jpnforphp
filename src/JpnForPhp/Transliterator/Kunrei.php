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
 * Kunrei romanization system class
 */
class Kunrei implements RomanizationInterface
{
    /**
     * Implements fromHiragana();
     *
     * @see Transliterator
     */
    public function fromHiragana($str)
    {
        return $str;
    }

    /**
     * Implements fromKatakana();
     *
     * @see Transliterator
     */
    public function fromKatakana($str)
    {
        return $str;
    }
    
    /**
     * Implements __toString().
     *
     * @see TransliteratorInterface
     */
    public function __toString(){
        return 'Kunrei romanization system (訓令式ローマ字)';
    }
}
