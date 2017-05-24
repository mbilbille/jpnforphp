<?php

/*
 * This file is part of the JpnForPhp package.
 *
 * (c) Matthieu Bilbille
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JpnForPhp\Transliterator\System;

use JpnForPhp\Analyzer\Analyzer;
use JpnForPhp\Helper\Helper;

/**
 * Transliteration system class to support transliteration into Kana alphabet:
 *  - Hiragana
 *  - Katakana
 *
 * @author Matthieu Bilbille (@mbibille)
 */
abstract class Kana implements System
{
    const STRIP_WHITESPACE_NONE = 0;
    const STRIP_WHITESPACE_ALL = 1;
    const STRIP_WHITESPACE_AUTO = 2;
    const STRIP_WHITESPACE_AUTO_NB_SPACES = 2;

    private $stripWhitespaceMode;

    private $mapping = array(
      'a' => 'あ', 'i' => 'い', 'u' => 'う', 'e' => 'え', 'o' => 'お',
      'ka' => 'か', 'ki' => 'き', 'ku' => 'く', 'ke' => 'け', 'ko' => 'こ',
      'sa' => 'さ', 'shi' => 'し', 'si' => 'し', 'su' => 'す', 'se' => 'せ', 'so' => 'そ',
      'ta' => 'た', 'chi' => 'ち', 'ti' => 'ち', 'tsu' => 'つ', 'tu' => 'つ', 'te' => 'て', 'to' => 'と',
      'na' => 'な', 'ni' => 'に', 'nu' => 'ぬ', 'ne' => 'ね', 'no' => 'の',
      'ha' => 'は', 'hi' => 'ひ', 'fu' => 'ふ', 'hu' => 'ふ', 'he' => 'へ', 'ho' => 'ほ',
      'ma' => 'ま', 'mi' => 'み', 'mu' => 'む', 'me' => 'め', 'mo' => 'も',
      'ra' => 'ら', 'ri' => 'り', 'ru' => 'る', 're' => 'れ', 'ro' => 'ろ',
      'ya' => 'や', 'yi' => 'いぃ', 'yu' => 'ゆ', 'ye' => 'えぇ', 'yo' => 'よ',
      'wa' => 'わ', 'wi' => 'ゐ', 'we' => 'ゑ', 'wo' => 'を',
      // 'wa' => 'うぁ', 'wi' => 'うぃ', 'wu' => 'うぅ', 'we' => 'うぇ', 'wo' => 'うぉ',
      'n' => 'ん', 'n\'' => 'ん',
      'ga' => 'が', 'gi' => 'ぎ', 'gu' => 'ぐ', 'ge' => 'げ', 'go' => 'ご',
      'za' => 'ざ', 'ji' => 'じ', 'zi' => 'じ', 'zu' => 'ず', 'ze' => 'ぜ', 'zo' => 'ぞ',
      'da' => 'だ', 'di' => 'ぢ', 'dzu' => 'づ', 'du' => 'づ', 'de' => 'で', 'do' => 'ど',
      'ba' => 'ば', 'bi' => 'び', 'bu' => 'ぶ', 'be' => 'べ', 'bo' => 'ぼ',
      'pa' => 'ぱ', 'pi' => 'ぴ', 'pu' => 'ぷ', 'pe' => 'ぺ', 'po' => 'ぽ',
      'va' => 'ぶぁ', 'vi' => 'ぶぃ', 'vu' => 'ぶ', 've' => 'ぶぇ', 'vo' => 'ぶぉ',
      'kya' => 'きゃ', 'kyu' => 'きゅ', 'kye' => 'きぇ', 'kyo' => 'きょ',
      'sya' => 'しゃ', 'sha' => 'しゃ', 'syu' => 'しゅ', 'shu' => 'しゅ', 'she' => 'しぇ', 'syo' => 'しょ', 'sho' => 'しょ',
      'tya' => 'ちゃ', 'cya' => 'ちゃ', 'cha' => 'ちゃ', 'tyu' => 'ちゅ', 'cyu' => 'ちゅ', 'chu' => 'ちゅ', 'tyo' => 'ちょ', 'cyo' => 'ちょ', 'cho' => 'ちょ',
      'nya' => 'にゃ', 'nyu' => 'みゅ', 'nye' => 'にぇ', 'nyo' => 'にょ',
      'hya' => 'ひゃ', 'hyu' => 'ひゅ', 'hye' => 'ひぇ', 'hyo' => 'ひょ',
      'mya' => 'みゃ', 'myu' => 'みゅ', 'mye' => 'みぇ', 'myo' => 'みょ',
      'rya' => 'りゃ', 'ryu' => 'りゅ', 'rye' => 'りぇ', 'ryo' => 'りょ',
      'gya' => 'ぎゃ', 'gyu' => 'ぎゅ', 'gye' => 'ぎぇ', 'gyo' => 'ぎょ',
      'vya' => 'ぶゃ', 'vyu' => 'ぶゅ', 'vye' => 'ぶぃぇ', 'vyo' => 'ぶょ',
      'wya' => 'うゃ',
      'ja' => 'じゃ', 'zya' => 'じゃ', 'jya' => 'じゃ', 'ju' => 'じゅ', 'zyu' => 'じゅ', 'jyu' => 'じゅ', 'je' => 'じぇ', 'zye' => 'じぇ', 'jye' => 'じぇ', 'jo' => 'じょ', 'zyo' => 'じょ', 'jyo' => 'じょ',
      'dja' => 'ぢゃ', 'dya' => 'ぢゃ', 'dju' => 'ぢゅ', 'dyu' => 'ぢゅ', 'djo' => 'ぢょ', 'dyo' => 'ぢょ',
      'bya' => 'びゃ', 'byu' => 'びゅ', 'bye' => 'びぇ', 'byo' => 'びょ',
      'pya' => 'ぴゃ', 'pyu' => 'ぴゅ', 'pye' => 'ぴぇ', 'pyo' => 'ぴょ',
      'fya' => 'ふゃ', 'fyu' => 'ふゅ', 'fye' => 'ふぃぇ', 'fyo' => 'ふょ',
      'wyi' => 'ゐ', 'wye' => 'ゑ',
      'kwa' => 'くぁ', 'kwi' => 'くぃ', 'kwe' => 'くぇ', 'kwo' => 'くぉ', // 'kwa' => 'くゎ',
      'gwa' => 'ぐぁ', 'gwi' => 'ぐぃ', 'gwe' => 'ぐぇ', 'gwo' => 'ぐぉ', // 'gwa' => 'ぐゎ',
      'swa' => 'すぁ', 'swi' => 'すぃ', 'swu' => 'すぅ', 'swe' => 'すぇ', 'swo' => 'すぉ',
      'twa' => 'とぁ', 'twi' => 'とぃ', 'twu' => 'とぅ', 'twe' => 'とぇ', 'two' => 'とぉ',
      'fwa' => 'ふぁ', 'fwi' => 'ふぃ', 'fwu' => 'ふぅ', 'fwe' => 'ふぇ', 'fwo' => 'ふぉ',
      'dwa' => 'どぁ', 'dwi' => 'どぃ', 'dwu' => 'どぅ', 'dwe' => 'どぇ', 'dwo' => 'どぉ',
      // 'si' => 'すぃ', 'zi' => 'ずぃ',
      'che' => 'ちぇ',
      'tsa' => 'つぁ', 'tsi' => 'つぃ', 'tse' => 'つぇ', 'tso' => 'つぉ', 'tsyu' => 'つゅ',
      // 'ti' => 'てぃ', 'tu' => 'てぅ', 'di' => 'でぃ', 'du' => 'でぅ', 'dyu' => 'でゅ',
      'fa' => 'ふぁ', 'fi' => 'ふぃ', 'fe' => 'ふぇ', 'fo' => 'ふぉ',
      'wha' => 'うぁ', 'whi' => 'うぃ', 'whe' => 'うぇ', 'who' => 'うぉ',
      'hu' => 'ほぅ',
      // 'la' => 'ら゜', 'li' => 'り゜', 'lu' => 'る゜', 'le' => 'れ゜', 'lo' => 'ろ゜',
      // 'va' => 'ヷ', 'vi' => 'ヸ', 've' => 'ヹ', 'vo' => 'ヺ',
      'la' => 'ぁ', 'li' => 'ぃ', 'lu' => 'ぅ', 'le' => 'ぇ', 'lo' => 'ぉ',
      'lya' => 'ゃ', 'lyu' => 'ゅ', 'lyo' => 'ょ', 'lwa' => 'ゎ',
      // http://en.wikipedia.org/wiki/Japanese_punctuation
      // NOTE => Quotation marks are not handle here as opening and closing
      // characters are equivalent in latin alphabet.
      ' ' => '　',
      ',' => '、',
      ', ' => '、',
      '-' => '・',
      '.' => '。',
      ':' => '：',
      '!' => '！',
      '?' => '？',
      '(' => '（',
      ')' => '）',
      '{' => '｛',
      '}' => '｝',
      '[' => '［',
      ']' => '］',
      '~' => '〜'
    );

    /**
     * Kana's constructor
     */
    public function __construct($stripWhitespaceMode = self::STRIP_WHITESPACE_NONE)
    {
        $this->stripWhitespaceMode = $stripWhitespaceMode;
    }

    /**
     * Change mode for stripping whitespaces.
     */
    public function setStripWhitespaceMode($stripWhitespaceMode = self::STRIP_WHITESPACE_NONE) {
        $this->stripWhitespaceMode = $stripWhitespaceMode;
        return $this;
    }

    /**
     * Prepare given string for transliteration
     *
     * @param string $str        String to be transliterated.
     *
     * @return string A string ready for transliteration.
     */
    protected function preTransliterate($str)
    {
        return preg_replace_callback('/([A-Z]|Ā|Â|Ē|Ê|Ī|Î|Ō|Ô|Ū|Û)([a-z]|ā|â|ē|ê|ī|î|ō|ô|ū|û)/u', function($matches) {
            return mb_strtolower($matches[1], 'UTF-8') . $matches[2];
        }, $str);
    }


    /**
     * Prepare a string for to transliterate long vowels into kana.
     *
     * @param string $str        String to be prepared.
     * @param array  $longVowels Long vowels mapping.
     *
     * @return string Prepared string.
     */
    protected function prepareLongVowelsTransliteration($str, $longVowels)
    {
        return strtr($str, $longVowels);
    }


    /**
     * Prepare a string for to transliterate choonpu into kana.
     *
     * @param string $str        String to be prepared.
     * @param array  $parameters Long vowels mapping.
     *
     * @return string Prepared string.
     */
    protected function prepareChoonpuTransliteration($str)
    {
        // Consonant followed by two of the same vowel
        $consonant = 'bcdfghjklmnpqrstvwyz';

        return preg_replace_callback('/(^[' . $consonant . '])(aa|ii|uu|ee|oo)/u', function($matches){
            return $matches[1].substr($matches[2], 1) . 'ー';
        }, $str);
    }


    /**
     * Transliterate proper combinaisons of latin alphabet characters into
     * Sokuon (http://en.wikipedia.org/wiki/Sokuon) characters.
     *
     * @param string $str        String to be transliterated.
     * @param array  $sokuon     Sokuon character.
     *
     * @return string Transliterated string.
     */
    protected function transliterateSokuon($str, $sokuon)
    {
        $new_str = $str;
        $length = Analyzer::length($str);

        //No need to go further.
        if ($length < 2) {
            return $new_str;
        }

        $skip = array('a', 'i', 'u', 'e', 'o', 'n');

        for ($i = 1; $i < $length; $i++) {
            $prev_char = substr($str, $i - 1, 1);
            if (!in_array($prev_char, $skip)) {
                // Don't forget Hepburn special case: ch > tch
                if ($prev_char === substr($str, $i, 1) || ($prev_char === 't' && substr($str, $i, 2) === 'ch')) {
                    $new_str = substr_replace($str, $sokuon, $i - 1, 1);
                }
            }
        }

        return $new_str;
    }


    /**
     * Transliterate quotation mark into their equivalent in Japanese syllabary.
     *
     * @param string $str String to be transliterated.
     *
     * @return string Transliterated string.
     */
    protected function transliterateQuotationMarks($str)
    {
        $str = preg_replace('/\'(.*)\'/u', '「${1}」', $str);
        $str = preg_replace('/"(.*)"/u', '『${1}』', $str);

        return $str;
    }


    /**
     * Convert the given string into kana using the specified mapping.
     *
     * @param string $str        String to be converted.
     * @param array  $mapping    Characters mapping.
     *
     * @return string Converted string.
     */
    protected function transliterateDefaultCharacters($str)
    {
        return strtr($str, $this->mapping);
    }


    /**
     * Strip whitespaces as per given strip mode.
     *
     * @param string $str        String to be cleaned.
     *
     * @return string Clean string.
     */
    protected function stripWhitespaces($str) {
       switch($this->stripWhitespaceMode) {
           case self::STRIP_WHITESPACE_AUTO:
               if(Helper::countSubString($str, '　') > self::STRIP_WHITESPACE_AUTO_NB_SPACES) {
                   break;
               }
           case self::STRIP_WHITESPACE_ALL:
               $str = preg_replace('/\x{3000}|\s/u', '', $str);
               break;
       }

       return $str;
    }
}
