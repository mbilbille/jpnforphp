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
abstract class Romaji implements TransliterationSystemInterface
{
    /**
     * @var string Flag for hiragana
     */
    const HIRAGANA = 'hiragana';
    
    /**
     * @var string Flag for katakana
     */
    const KATAKANA = 'katakana';
    
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
        $str = preg_replace_callback(Romaji::PREG_PATTERN_ESCAPE_CHAR, array($this, "espaceLatinCharactersCallback"), $str);

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
     * @return string Transliterated string.
     */
    protected function transliterateSokuon($str)
    {
       return preg_replace('/[っッ](.)/u', '${1}${1}', $str);
    }
}
