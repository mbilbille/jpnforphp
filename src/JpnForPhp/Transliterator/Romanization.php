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
     * @var array Map hiragana characters (or combinaison of characters) to
     * their equivalent in latin alphabet.
     *
     * This mapping must be defined in Romanization' subclasses.
     */
    protected $mapHiragana = array();

    /**
     * @var array Map katakana characters (or combinaison of characters) to
     * their equivalent in latin alphabet.
     *
     * Here is only extended katakana, mapping for default katakana must be defined in Romanization' subclasses.
     *
     * @see http://en.wikipedia.org/wiki/Transcription_into_Japanese#Extended_katakana
     */
    protected $mapKatakana = array(
        'イィ' => 'yi', 'イェ' => 'ye',
        'ウァ' => 'wa', 'ウィ' => 'wi', 'ウゥ' => 'wu', 'ウェ' => 'we', 'ウォ' => 'wo',
        'ウュ' => 'wya',
        'ヴァ' => 'va', 'ヴィ' => 'vi', 'ヴ' => 'vu', 'ヴェ' => 've', 'ヴォ' => 'vo',
        'ヴャ' => 'vya', 'ヴュ' => 'vyu', 'ヴィェ' => 'vye', 'ヴョ' => 'vyo',
        'キェ' => 'kye',
        'ギェ' => 'gye',
        'クァ' => 'kwa', 'クィ' => 'kwi', 'クェ' => 'kwe', 'クォ' => 'kwo',
        'クヮ' => 'kwa',
        'グァ' => 'gwa', 'グィ' => 'gwi', 'グェ' => 'gwe', 'グォ' => 'gwo',
        'グヮ' => 'gwa',
        'シェ' => 'she',
        'ジェ' => 'je',
        'スィ' => 'si',
        'ズィ' => 'zi',
        'チェ' => 'che',
        'ツァ' => 'tsa', 'ツィ' => 'tsi', 'ツェ' => 'tse', 'ツォ' => 'tso',
        'ツュ' => 'tsyu',
        'ティ' => 'ti', 'テゥ' => 'tu',
        'テュ' => 'tyu',
        'ディ' => 'di', 'デゥ' => 'du',
        'デュ' => 'dyu',
        'ニェ' => 'nye',
        'ヒェ' => 'hye',
        'ビェ' => 'bye',
        'ピェ' => 'pye',
        'ファ' => 'fa', 'フィ' => 'fi', 'フェ' => 'fe', 'フォ' => 'fo',
        'フャ' => 'fya', 'フュ' => 'fyu', 'フィェ' => 'fye', 'フョ' => 'fyo',
        'ホゥ' => 'hu',
        'ミェ' => 'mye',
        'リェ' => 'rye',
        'ラ゜' => 'la', 'リ゜' => 'li', 'ル゜' => 'lu', 'レ゜' => 'le', 'ロ゜' => 'lo',
        'ヷ' => 'va', 'ヸ' => 'vi', 'ヹ' => 've', 'ヺ' => 'vo',
        'ンア' => "n'a", 'ンイ' => "n'i", 'ンウ' => "n'u", 'ンエ' => "n'e", 'ンオ' => "n'o",
        'ンヤ' => "n'ya", 'ンユ' => "n'yu", 'ンヨ' => "n'yo",
    );

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
    protected function transliterateSokuon($str, $syllabary = Transliterator::HIRAGANA)
    {
        if ($syllabary === Transliterator::KATAKANA) {
            $sokuon = Transliterator::SOKUON_KATAKANA;
        } else {
            $sokuon = Transliterator::SOKUON_HIRAGANA;
        }

        $output = preg_replace('/' . $sokuon . '(.)/u', '${1}${1}', $str);

        return $output;
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
