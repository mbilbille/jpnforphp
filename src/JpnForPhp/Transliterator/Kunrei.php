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
 * Kunrei romanization system class
 *
 * Based on the following rules:
 * http://www.age.ne.jp/x/nrs/iso3602/iso3602_unicode.html#kutoten
 */
class Kunrei extends Romanization
{
    /**
     * @var array Map hiragana characters (or combinaison of characters) to
     * their equivalent in latin alphabet.
     */
    protected $mapHiragana = array (
        'あ' => 'a', 'い' => 'i', 'う' => 'u', 'え' => 'e', 'お' => 'o',
        'か' => 'ka', 'き' => 'ki', 'く' => 'ku', 'け' => 'ke', 'こ' => 'ko',
        'さ' => 'sa', 'し' => 'si', 'す' => 'su', 'せ' => 'se', 'そ' => 'so',
        'た' => 'ta', 'ち' => 'ti', 'つ' => 'tu', 'て' => 'te', 'と' => 'to',
        'な' => 'na', 'に' => 'ni', 'ぬ' => 'nu', 'ね' => 'ne', 'の' => 'no',
        'は' => 'ha', 'ひ' => 'hi', 'ふ' => 'hu', 'へ' => 'he', 'ほ' => 'ho',
        'ま' => 'ma', 'み' => 'mi', 'む' => 'mu', 'め' => 'me', 'も' => 'mo',
        'や' => 'ya', 'ゆ' => 'yu', 'よ' => 'yo',
        'ら' => 'ra', 'り' => 'ri', 'る' => 'ru', 'れ' => 're', 'ろ' => 'ro',
        'わ' => 'wa', 'ゐ' => 'i', 'ゑ' => 'e', 'を' => 'wo',
        'ん' => 'n',
        'が' => 'ga', 'ぎ' => 'gi', 'ぐ' => 'gu', 'げ' => 'ge', 'ご' => 'go',
        'ざ' => 'za', 'じ' => 'zi', 'ず' => 'zu', 'ぜ' => 'ze', 'ぞ' => 'zo',
        'だ' => 'da', 'ぢ' => 'zi', 'づ' => 'zu', 'で' => 'de', 'ど' => 'do',
        'ば' => 'ba', 'び' => 'bi', 'ぶ' => 'bu', 'べ' => 'be', 'ぼ' => 'bo',
        'ぱ' => 'pa', 'ぴ' => 'pi', 'ぷ' => 'pu', 'ぺ' => 'pe', 'ぽ' => 'po',
        'ゔ' => 'vu',
        'きゃ' => 'kya', 'きゅ' => 'kyu', 'きょ' => 'kyo',
        'しゃ' => 'sya', 'しゅ' => 'syu', 'しょ' => 'syo',
        'ちゃ' => 'tya', 'ちゅ' => 'tyu', 'ちょ' => 'tyo',
        'にゃ' => 'nya', 'にゅ' => 'nyu', 'にょ' => 'nyo',
        'ひゃ' => 'hya', 'ひゅ' => 'hyu', 'ひょ' => 'hyo',
        'みゃ' => 'mya', 'みゅ' => 'myu', 'みょ' => 'myo',
        'りゃ' => 'rya', 'りゅ' => 'ryu', 'りょ' => 'ryo',
        'ぎゃ' => 'gya', 'ぎゅ' => 'gyu', 'ぎょ' => 'gyo',
        'じゃ' => 'zya', 'じゅ' => 'zyu', 'じょ' => 'zyo',
        'ぢゃ' => 'zya', 'ぢゅ' => 'zyu', 'ぢょ' => 'zyo',
        'びゃ' => 'bya', 'びゅ' => 'byu', 'びょ' => 'byo',
        'ぴゃ' => 'pya', 'ぴゅ' => 'pyu', 'ぴょ' => 'pyo',
        'くゎ' => 'ka', 'ぐゎ' => 'ga',
        'んあ' => "n'a", 'んい' => "n'i", 'んう' => "n'u", 'んえ' => "n'e", 'んお' => "n'o",
        'んや' => "n'ya", 'んゆ' => "n'yu", 'んよ' => "n'yo",
    );

    /**
     * @var array Map katakana characters (or combinaison of characters) to
     * their equivalent in latin alphabet.
     */
    protected $mapKatakana = array (
        'ア' => 'a', 'イ' => 'i', 'ウ' => 'u', 'エ' => 'e', 'オ' => 'o',
        'カ' => 'ka', 'キ' => 'ki', 'ク' => 'ku', 'ケ' => 'ke', 'コ' => 'ko',
        'サ' => 'sa', 'シ' => 'si', 'ス' => 'su', 'セ' => 'se', 'ソ' => 'so',
        'タ' => 'ta', 'チ' => 'ti', 'ツ' => 'tu', 'テ' => 'te', 'ト' => 'to',
        'ナ' => 'na', 'ニ' => 'ni', 'ヌ' => 'nu', 'ネ' => 'ne', 'ノ' => 'no',
        'ハ' => 'ha', 'ヒ' => 'hi', 'フ' => 'hu', 'ヘ' => 'he', 'ホ' => 'ho',
        'マ' => 'ma', 'ミ' => 'mi', 'ム' => 'mu', 'メ' => 'me', 'モ' => 'mo',
        'ヤ' => 'ya', 'ユ' => 'yu', 'ヨ' => 'yo',
        'ラ' => 'ra', 'リ' => 'ri', 'ル' => 'ru', 'レ' => 're', 'ロ' => 'ro',
        'ワ' => 'wa', 'ヰ' => 'i', 'ヱ' => 'e', 'ヲ' => 'wo',
        'ン' => 'n',
        'ガ' => 'ga', 'ギ' => 'gi', 'グ' => 'gu', 'ゲ' => 'ge', 'ゴ' => 'go',
        'ザ' => 'za', 'ジ' => 'zi', 'ズ' => 'zu', 'ゼ' => 'ze', 'ゾ' => 'zo',
        'ダ' => 'da', 'ヂ' => 'zi', 'ヅ' => 'zu', 'デ' => 'de', 'ド' => 'do',
        'バ' => 'ba', 'ビ' => 'bi', 'ブ' => 'bu', 'ベ' => 'be', 'ボ' => 'bo',
        'パ' => 'pa', 'ピ' => 'pi', 'プ' => 'pu', 'ペ' => 'pe', 'ポ' => 'po',
        'キャ' => 'kya', 'キュ' => 'kyu', 'キョ' => 'kyo',
        'シャ' => 'sya', 'シュ' => 'syu', 'ショ' => 'syo',
        'チャ' => 'tya', 'チュ' => 'tyu', 'チョ' => 'tyo',
        'ニャ' => 'nya', 'ニュ' => 'nyu', 'ニョ' => 'nyo',
        'ヒャ' => 'hya', 'ヒュ' => 'hyu', 'ヒョ' => 'hyo',
        'ミャ' => 'mya', 'ミュ' => 'myu', 'ミョ' => 'myo',
        'リャ' => 'rya', 'リュ' => 'ryu', 'リョ' => 'ryo',
        'ギャ' => 'gya', 'ギュ' => 'gyu', 'ギョ' => 'gyo',
        'ジャ' => 'zya', 'ジュ' => 'zyu', 'ジョ' => 'zyo',
        'ヂャ' => 'zya', 'ヂュ' => 'zyu', 'ヂョ' => 'zyo',
        'ビャ' => 'bya', 'ビュ' => 'byu', 'ビョ' => 'byo',
        'ピャ' => 'pya', 'ピュ' => 'pyu', 'ピョ' => 'pyo',
        'クヮ' => 'ka', 'グヮ' => 'ga',
        'ンア' => "n'a", 'ンイ' => "n'i", 'ンウ' => "n'u", 'ンエ' => "n'e", 'ンオ' => "n'o",
        'ンヤ' => "n'ya", 'ンユ' => "n'yu", 'ンヨ' => "n'yo",
    );

    /**
     * @var array Map Japanese punctuation marks to their equivalent in latin
     * alphabet.
     */
    protected $mapPunctuationMarks = array(
        '　' => ' ', '、' => ',　', '・' => '-',
        '「' => '"', '」' => '"',
        '（' => '(', '）' => ')',
    );

    /**
     * Implements fromHiragana();
     *
     * @see Transliterator
     */
    public function fromHiragana($str)
    {
        $str = $this->escapeLatinCharacters($str);
        $output = strtr($str, $this->mapHiragana);
        $output = strtr($output, $this->mapPunctuationMarks);
        $output = $this->transliterateSokuon($output);
        $output = $this->convertLongVowels($output);
        $output = $this->convertParticles($output);
        $output = $this->unescapeLatinCharacters($output);

        return $output;
    }

    /**
     * Implements fromKatakana();
     *
     * @see Transliterator
     */
    public function fromKatakana($str)
    {
        $str = $this->escapeLatinCharacters($str);
        $output = strtr($str, $this->mapKatakana);
        $output = strtr($output, $this->mapPunctuationMarks);
        $output = $this->transliterateSokuon($output, Transliterator::KATAKANA);
        $output = $this->transliterateChoonpu($output);
        $output = $this->unescapeLatinCharacters($output);

        return $output;
    }

    /**
     * Implements __toString().
     *
     * @see TransliteratorInterface
     */
    public function __toString()
    {
        return 'Kunrei romanization system (訓令式ローマ字)';
    }

    /**
     * Overrides transliterateChoonpu().
     *
     * @see Romanization
     */
    protected function transliterateChoonpu($str)
    {
        $macrons = array(
            'a' => 'â',
            'i' => 'î',
            'u' => 'û',
            'e' => 'ê',
            'o' => 'ô',
        );

        return preg_replace('/(.)' . Transliterator::CHOONPU . '/ue', '$macrons[\'${1}\']', $str);
    }

    /**
     * Overrides convertLongVowels().
     *
     * @see Romanization
     */
    protected function convertLongVowels($str)
    {
        $search = array('aa', 'uu', 'ee', 'oo', 'ou');
        $replace = array('â', 'û', 'ê', 'ô', 'ô');

        return str_replace($search, $replace, $str);
    }

    /**
     * Overrides convertParticles().
     *
     * @see Romanization
     */
    protected function convertParticles($str)
    {
        $search = array(' ha ', ' he ', ' wo ');
        $replace = array(' wa ', ' e ', ' o ');

        return str_replace($search, $replace, $str);
    }
}
