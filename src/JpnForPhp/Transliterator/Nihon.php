<?php

namespace JpnForPhp\Transliterator;

/**
 * Nihon romanization system class
 */
class Nihon implements TransliteratorInterface
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
        return 'Nihon romanization system (日本式ローマ字)';
    }
}
