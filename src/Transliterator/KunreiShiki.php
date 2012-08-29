<?php

namespace JpnForPhp\Transliterator;

/**
 * Kunrei Shiki romaji system class
 */
class KunreiShiki implements Transliterator
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
     * Implements transliterateSokuon().
     *
     * @see Transliterator
     */
    public function transliterateSokuon($str)
    {
        return $str;
    }

    /**
     * Implements transliterateChoonpu().
     *
     * @see Transliterator
     */
    public function transliterateChoonpu($str)
    {
        return $str;
    }

}
