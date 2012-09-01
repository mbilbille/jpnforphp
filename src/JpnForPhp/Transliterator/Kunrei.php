<?php

namespace JpnForPhp\Transliterator;

/**
 * Kunrei romanization system class
 */
class Kunrei implements TransliteratorInterface
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

    /**
     * Implements __toString().
     *
     * @see TransliteratorInterface
     */
    public function __toString(){
        return 'Kunrei romanization system (訓令式ローマ字)';
    }
}
