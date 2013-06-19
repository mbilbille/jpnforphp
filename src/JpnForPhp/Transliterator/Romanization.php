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
abstract class Romanization implements RomanizationInterface
{
    /**
     * @var string Regex pattern to escape latin characters.
     */
    const PREG_PATTERN_ESCAPE_CHAR = '/([a-z]+)/';

    /**
     * @var array Store latin characters which are escaped.
     */
    public $latinCharacters = array();

    /**
     * @var array Map Japanese punctuation marks to their equivalent in latin
     * alphabet.
     *
     * @see http://en.wikipedia.org/wiki/Japanese_punctuation
     */
    protected $mapPunctuationMarks = array(
        '　' => ' ', '、' => ', ', '，' => ', ', '：' => ':', '・' => '-',
        '。' => '.', '！' => '!', '？' => '?', '‥' => '…',
        '「' => '\'', '」' => '\'', '『' => '"', '』' => '"',
        '（' => '(', '）' => ')', '｛' => '{', '｝' => '}',
        '［' => '[', '］' => ']', '【' => '[', '】' => ']',
        '〜' => '~', '〽' => '\'',
    );

    /**
     * Escapes latin characters [a-z].
     */
    protected function escapeLatinCharacters($str)
    {
        $str = preg_replace_callback(Romanization::PREG_PATTERN_ESCAPE_CHAR, array($this, "espaceLatinCharactersCallback"), $str);

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
     * Transliterate Sokuon (http://en.wikipedia.org/wiki/Sokuon) character into
     * its equivalent in latin alphabet.
     *
     * @param string $str String to be transliterated.
     *
     * @param string $syllabary Syllabary to use
     *
     * @return string Transliterated string.
     */
    protected function transliterateSokuon($str)
    {
       return preg_replace('/[' . Transliterator::SOKUON_HIRAGANA . Transliterator::SOKUON_KATAKANA . '](.)/u', '${1}${1}', $str);
    }

    /**
     * Transliterate Chōonpu (http://en.wikipedia.org/wiki/Chōonpu) character
     * into its equivalent in latin alphabet.
     *
     * @param string $str String to be transliterated.
     *
     * @return string Transliterated string.
     */
    protected function transliterateChoonpu($str)
    {
        return $str;
    }

    /**
     * Post-processing transliteration to properly format long vowels.
     *
     * @param string $str String to be processed.
     *
     * @return string Transliterated string.
     */
    protected function convertLongVowels($str)
    {
        return $str;
    }

    /**
     * Post-processing transliteration to properly format particles.
     *
     * @param string $str String to be processed.
     *
     * @return string Transliterated string.
     */
    protected function convertParticles($str)
    {
        return $str;
    }
}
