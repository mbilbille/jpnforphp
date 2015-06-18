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
     * @see TransliterationSystem
     */
    public function __toString()
    {
        return $this->configuration['name']['english'] . ' (' . $this->configuration['name']['japanese'] . ')';
    }

    /**
     * Override preTransliterate().
     *
     * @see TransliterationSystem
     */
    protected function preTransliterate($str)
    {
        $str = $this->escapeLatinCharacters($str);
        $str = mb_convert_kana($str, 'c', 'UTF-8');

        return $str;
    }

    /**
     * Override postTransliterate().
     *
     * @see TransliterationSystem
     */
    protected function postTransliterate($str)
    {
        $str = $this->unescapeLatinCharacters($str);

        return $str;
    }

    /**
     * Use the specified mapping to transliterate the given string into romaji
     *
     * @param string $str        String to be converted.
     * @param array  $parameters Characters mapping.
     *
     * @return string Converted string.
     */
    protected function transliterateDefaultCharacters($str, $parameters)
    {
        return strtr($str, $parameters['mapping']);
    }

    /**
     * Transliterate Sokuon (http://en.wikipedia.org/wiki/Sokuon) character into
     * its equivalent in latin alphabet.
     *
     * @param string $str        String to be transliterated.
     * @param array  $parameters Default or Hepburn transliteration.
     *
     * @return string Transliterated string.
     */
    protected function transliterateSokuon($str, $parameters)
    {
        if ($parameters['default']) {
            $str = preg_replace('/[っッ](.)/u', '${1}${1}', $str);
        }

        // As per Hepburn system ch > tch
        // (http://en.wikipedia.org/wiki/Hepburn_romanization#Double_consonants)
        if ($parameters['hepburn']) {
            $str = str_replace('cch', 'tch', $str);
        }

        return $str;
    }


    /**
     * Transliterate Chōonpu (http://en.wikipedia.org/wiki/Chōonpu) character
     * into its equivalent in latin alphabet.
     *
     * @param string $str        String to be transliterated.
     * @param array  $parameters Macrons mapping.
     *
     * @return string Transliterated string.
     */
    protected function transliterateChoonpu($str, $parameters)
    {
        $keys = array_keys($parameters['macrons']);
        $pattern = '/([' . implode('', $keys) . '])ー/u';

        return preg_replace_callback($pattern, function($matches) use ($parameters) {
            return $parameters['macrons'][$matches[1]];
        }, $str);
    }

    /**
     * Transliterate long vowels as per the given mapping.
     *
     * @param string $str        String to be transliterated.
     * @param array  $parameters Long vowels mapping.
     *
     * @return string Transliterated string.
     */
    protected function transliterateLongVowels($str, $parameters)
    {
        return str_replace(array_keys($parameters['long-vowels']), array_values($parameters['long-vowels']), $str);
    }

    /**
     * Transliterate particules as per the given mapping.
     *
     * @param string $str        String to be transliterated.
     * @param array  $parameters Particules mapping.
     *
     * @return string Transliterated string.
     */
    protected function transliterateParticles($str, $parameters)
    {
        return str_replace(array_keys($parameters['particules']), array_values($parameters['particules']), $str);
    }
    
    /**
     * Transliterate character 'n' to 'm' before labial consonants.
     *
     * @param string $str        String to be transliterated.
     * 
     * @return string Transliterated string.
     */
    protected function transliterateNBeforeLabialConsonants($str)
    {
        return preg_replace('/n([bmp])/u', 'm$1', $str);
    }

    /**
     * Escapes latin characters [a-z].
     */
    private function escapeLatinCharacters($str)
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
    private function unescapeLatinCharacters($str)
    {
        if ($this->latinCharacters) {
            $str = vsprintf($str, $this->latinCharacters);
        }

        return $str;
    }
}
