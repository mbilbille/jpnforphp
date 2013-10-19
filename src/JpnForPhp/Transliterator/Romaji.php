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
 * Romaji transliteration system class
 */
class Romaji extends TransliterationSystem
{    
    /**
     * @var array Store latin characters which are escaped.
     */
    private $latinCharacters = array();

    /**
     * Romaji's constructor
     */
    public function __construct($system = '')
    {
        $file = __DIR__ . DIRECTORY_SEPARATOR . 'Romaji' . DIRECTORY_SEPARATOR . (($system) ? $system : 'hepburn') . '.yaml';
        parent::__construct($file);
    }

    /**
     * Implements __toString().
     *
     * @see TransliterationSystemInterface
     */
    public function __toString()
    {
        return $this->configuration['name']['english'] . ' (' . $this->configuration['name']['japanese'] . ')';
    }

    /**
     * Escapes latin characters [a-z].
     */
    protected function escapeLatinCharacters($str)
    {
        $str = preg_replace_callback('/([a-z]+)/', array($this, "espaceLatinCharactersCallback"), $str);

        return $str;
    }

    /**
     * Private callback for escapeLatinCharacters().
     */
    private function espaceLatinCharactersCallback($matches)
    {
        $this->latinCharacters[] = $matches[1];

        return '%s';
    }

    /**
     * Unescapes latin characters [a-z].
     */
    protected function unescapeLatinCharacters($str)
    {
        if ($this->latinCharacters) {
            $str = vsprintf($str, $this->latinCharacters);
        }

        return $str;
    }

    /**
     * Convert the given string from katakana to hiragana.
     * Simply wrap the mb_convert_kana function.
     *
     * @param string $str           String to be converted.
     *
     * @return string               Converted string.     
     */
    protected function convertKatakanaToHiragana($str)
    {
        return mb_convert_kana($str, 'c', 'UTF-8');
    }

    /**
     * Convert the given string into romaji using the specified mapping.
     *
     * @param string $str           String to be converted.
     * @param array $parameters     Characters mapping.
     *
     * @return string               Converted string.
     */
    protected function convertUsingMapping($str, $parameters)
    {
        return strtr($str, $parameters['mapping']);
    }

    /**
     * Transliterate Sokuon (http://en.wikipedia.org/wiki/Sokuon) character into
     * its equivalent in latin alphabet.
     *
     * @param string $str           String to be transliterated.
     * @param array $parameters     Default or Hepburn transliteration.
     *
     * @return string               Transliterated string.
     */
    protected function transliterateSokuon($str, $parameters)
    {
        if($parameters['default']){
            $str = preg_replace('/[っッ](.)/u', '${1}${1}', $str);
        }

        // As per Hepburn system ch > tch
        // (http://en.wikipedia.org/wiki/Hepburn_romanization#Double_consonants)
        if($parameters['hepburn']){
            $str = str_replace('cch', 'tch', $str);
        }

        return $str;
    }


    /**
     * Transliterate Chōonpu (http://en.wikipedia.org/wiki/Chōonpu) character
     * into its equivalent in latin alphabet.
     *
     * @param string $str           String to be transliterated.
     * @param array $parameters     Macrons mapping.
     *
     * @return string               Transliterated string.
     */
    protected function transliterateChoonpu($str, $parameters)
    {
        $keys = array_keys($parameters['macrons']);
        $pattern = '/([' . implode('', $keys) . '])ー/ue';
        return preg_replace($pattern, '$parameters[\'macrons\'][\'${1}\']', $str);
    }

    /**
     * Convert long vowels as per the given mapping.
     *
     * @param string $str           String to be converted.
     * @param array $parameters     Long vowels mapping.
     *
     * @return string               Converted string.
     */
    protected function convertLongVowels($str, $parameters)
    {
        return str_replace(array_keys($parameters['long-vowels']), array_values($parameters['long-vowels']), $str);
    }

    /**
     * Convert particules as per the given mapping.
     *
     * @param string $str           String to be converted.
     * @param array $parameters     Particules mapping.
     *
     * @return string               Converted string.
     */
    protected function convertParticles($str, $parameters)
    {
        return str_replace(array_keys($parameters['particules']), array_values($parameters['particules']), $str);
    }

}
