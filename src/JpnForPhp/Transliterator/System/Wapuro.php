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

/**
 * Transliteration system class to support Wapuro romanization system.
 *
 * @author Matthieu Bilbille (@mbibille)
 */
class Wapuro extends Romaji
{
    // This follow the MS-IME mapping as detailed here:
    // - http://www.hyperteika.com/ime/extra/rome.html
    private $mapping = array(
      'あ' => 'a', 'い' => 'i',  'う' => 'u',  'え' => 'e',  'お' => 'o',
      'ぁ' => 'la', 'ぃ' => 'li', 'ぅ' => 'lu', 'ぇ' => 'le', 'ぉ' => 'lo',
      'か' => 'ka', 'き' => 'ki', 'く' => 'ku', 'け' => 'ke', 'こ' => 'ko',
      'さ' => 'sa', 'し' => 'shi', 'す' => 'su', 'せ' => 'se', 'そ' => 'so',
      'た' => 'ta', 'ち' => 'chi', 'つ' => 'tsu', 'て' => 'te', 'と' => 'to',
      'な' => 'na', 'に' => 'ni', 'ぬ' => 'nu', 'ね' => 'ne', 'の' => 'no',
      'ま' => 'ma', 'み' => 'mi', 'む' => 'mu', 'め' => 'me', 'も' => 'mo',
      'は' => 'ha', 'ひ' => 'hi', 'ふ' => 'hu', 'へ' => 'he', 'ほ' => 'ho',
      'や' => 'ya', 'ゆ' => 'yu', 'いぇ' => 'ye', 'よ' => 'yo',
      'ゃ' => 'lya', 'ゅ' => 'lyu', 'ょ' => 'lyo',
      'ら' => 'ra', 'り' => 'ri', 'る' => 'ru', 'れ' => 're', 'ろ' => 'ro',
      'わ' => 'wa', 'ゐ' => 'wyi', 'ゑ' => 'wye', 'を' => 'wo',
      'ゎ' => 'lwa',
      'ん' => 'nn',
      'ー' => '-',
      'ヵ' => 'lka', 'ヶ' => 'lke',
      'が' => 'ga', 'ぎ' => 'gi', 'ぐ' => 'gu', 'げ' => 'ge', 'ご' => 'go',
      'ざ' => 'za', 'じ' => 'ji', 'ず' => 'zu', 'ぜ' => 'ze', 'ぞ' => 'zo',
      'だ' => 'da', 'ぢ' => 'di', 'づ' => 'du', 'で' => 'de', 'ど' => 'do',
      'ば' => 'ba', 'び' => 'bi', 'ぶ' => 'bu', 'べ' => 'be', 'ぼ' => 'bo',
      'ぱ' => 'pa', 'ぴ' => 'pi', 'ぷ' => 'pu', 'ぺ' => 'pe', 'ぽ' => 'po',
      'うぁ' => 'wha', 'うぃ' => 'whi', 'うぇ' => 'whe', 'うぉ' => 'who',
      'くぁ' => 'kwa', 'くぃ' => 'qi', 'くぅ' => 'qwu', 'くぇ' => 'qe', 'くぉ' => 'qo',
      'くゃ' => 'qya', 'くゅ' => 'qyu', 'くょ' => 'qyo',
      'きゃ' => 'kya', 'きゅ' => 'kyu', 'きょ' => 'kyo',
      'しゃ' => 'sha', 'しぃ' => 'syi', 'しゅ' => 'shu', 'しぇ' => 'she', 'しょ' => 'sho',
      'すぁ' => 'swa', 'すぃ' => 'swi', 'すぅ' => 'swu', 'すぇ' => 'swe', 'すぉ' => 'swo',
      'ちゃ' => 'cha', 'ちぃ' => 'cyi', 'ちゅ' => 'chu', 'ちぇ' => 'che', 'ちょ' => 'cho',
      'つぁ' => 'tsa', 'つぃ' => 'tsi', 'つぇ' => 'tse', 'つぉ' => 'tso',
      'とぁ' => 'twa', 'とぃ' => 'twi', 'とぅ' => 'twu', 'とぇ' => 'twe', 'とぉ' => 'two',
      'ふぁ' => 'fwa', 'ふぃ' => 'fwi', 'ふぅ' => 'fwu', 'ふぇ' => 'fwe', 'ふぉ' => 'fwo',
      'ふゃ' => 'fya', 'ふゅ' => 'fyu', 'ふょ' => 'fyo',
      'にゃ' => 'nya', 'にゅ' => 'nyu', 'にょ' => 'nyo',
      'ひゃ' => 'hya', 'ひゅ' => 'hyu', 'ひょ' => 'hyo',
      'みゃ' => 'mya', 'みゅ' => 'myu', 'みょ' => 'myo',
      'ぎゃ' => 'gya', 'ぎゅ' => 'gyu', 'ぎょ' => 'gyo',
      'りゃ' => 'rya', 'りぃ' => 'ryi', 'りゅ' => 'ryu', 'りぇ' => 'rye', 'りょ' => 'ryo',
      'ぐゃ' => 'gwa', 'ぐぃ' => 'gwi', 'ぐゅ' => 'gwu', 'ぐぇ' => 'gwe', 'ぐょ' => 'gwo',
      'じゃ' => 'ja', 'じぃ' => 'jyi', 'じゅ' => 'ju', 'じぇ' => 'je', 'じょ' => 'jo',
      'どぁ' => 'dwa', 'どぃ' => 'dwi', 'どぅ' => 'dwu', 'どぇ' => 'dwe', 'どぉ' => 'dwo',
      'ぢゃ' => 'dya', 'ぢぃ' => 'dyi', 'ぢゅ' => 'dyu', 'ぢぇ' => 'dye', 'ぢょ' => 'dyo',
      'びゃ' => 'bya', 'びゅ' => 'byu', 'びょ' => 'byo',
      'ぴゃ' => 'pya', 'ぴゅ' => 'pyu', 'ぴょ' => 'pyo',
      'ゔぁ' => 'va', 'ゔぃ' => 'vi', 'ゔ' => 'vu', 'ゔぇ' => 've', 'ゔぉ' => 'vo',
      'ゔゃ' => 'vya', 'ゔゅ' => 'vyu', 'ゔょ' => 'vyo',
      '　' => ' ',
      '、' => ', ',
      '，' => ', ',
      '：' => ':',
      '・' => '-',
      '。' => '.',
      '！' => '!',
      '？' => '?',
      '‥' => '…',
      '「' => '\'',
      '」' => '\'',
      '『' => '"',
      '』' => '"',
      '（' => '(',
      '）' => ')',
      '｛' => '{',
      '｝' => '}',
      '［' => '[',
      '］' => ']',
      '【' => '[',
      '】' => ']',
      '〜' => '~',
      '〽' => '\'',
    );

    private $macrons = array(
        'a' => 'aa',
        'i' => 'ii',
        'u' => 'uu',
        'e' => 'ee',
        'o' => 'oo'
    );

    /**
     * Override __toString().
     *
     * @see System
     */
    public function __toString()
    {
        return 'Wāpuro romanization system (ワープロローマ字)';
    }

    /**
     * Override transliterate().
     *
     * @see System
     */
    public function transliterate($str) {

      $str = self::preTransliterate($str);

      // Workflow:
      //  1/ Default characters
      //  2/ Sokuon
      //  3/ Choonpu

      $str = self::transliterateDefaultCharacters($str, $this->mapping);

      $str = self::transliterateSokuon($str);

      $str = self::transliterateChoonpu($str, $this->macrons);

      return self::postTransliterate($str);
    }
}
