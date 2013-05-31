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
 * Wapuro romanization system class
 */
class Wapuro extends Romanization
{
    /**
     * Wapuro's constructor
     */
    public function __construct()
    {
        $this->mapHiragana = array(
            'あ' => 'a', 'い' => 'i', 'う' => 'u', 'え' => 'e', 'お' => 'o',
            'か' => 'ka', 'き' => 'ki', 'く' => 'ku', 'け' => 'ke', 'こ' => 'ko',
            'さ' => 'sa', 'し' => 'si', 'す' => 'su', 'せ' => 'se', 'そ' => 'so',
            'た' => 'ta', 'ち' => 'ti', 'つ' => 'tu', 'て' => 'te', 'と' => 'to',
            'な' => 'na', 'に' => 'ni', 'ぬ' => 'nu', 'ね' => 'ne', 'の' => 'no',
            'は' => 'ha', 'ひ' => 'hi', 'ふ' => 'hu', 'へ' => 'he', 'ほ' => 'ho',
            'ま' => 'ma', 'み' => 'mi', 'む' => 'mu', 'め' => 'me', 'も' => 'mo',
            'や' => 'ya', 'ゆ' => 'yu', 'よ' => 'yo',
            'ら' => 'ra', 'り' => 'ri', 'る' => 'ru', 'れ' => 're', 'ろ' => 'ro',
            'わ' => 'wa', 'ゐ' => 'wi', 'ゑ' => 'we', 'を' => 'wo',
            'ん' => 'n',
            'が' => 'ga', 'ぎ' => 'gi', 'ぐ' => 'gu', 'げ' => 'ge', 'ご' => 'go',
            'ざ' => 'za', 'じ' => 'zi', 'ず' => 'zu', 'ぜ' => 'ze', 'ぞ' => 'zo',
            'だ' => 'da', 'ぢ' => 'di', 'づ' => 'du', 'で' => 'de', 'ど' => 'do',
            'ば' => 'ba', 'び' => 'bi', 'ぶ' => 'bu', 'べ' => 'be', 'ぼ' => 'bo',
            'ぱ' => 'pa', 'ぴ' => 'pi', 'ぷ' => 'pu', 'ぺ' => 'pe', 'ぽ' => 'po',
            'ゔ' => 'vu',
            'きゃ' => 'kya', 'きゅ' => 'kyu', 'きょ' => 'kyo',
            'しゃ' => 'sya', 'しゅ' => 'syu', 'しょ' => 'syo',
            'ちゃ' => 'cya', 'ちゅ' => 'cyu', 'ちょ' => 'cyo',
            'にゃ' => 'nya', 'にゅ' => 'nyu', 'にょ' => 'nyo',
            'ひゃ' => 'hya', 'ひゅ' => 'hyu', 'ひょ' => 'hyo',
            'みゃ' => 'mya', 'みゅ' => 'myu', 'みょ' => 'myo',
            'りゃ' => 'rya', 'りゅ' => 'ryu', 'りょ' => 'ryo',
            'ぎゃ' => 'gya', 'ぎゅ' => 'gyu', 'ぎょ' => 'gyo',
            'じゃ' => 'ja', 'じゅ' => 'ju', 'じょ' => 'jo',
            'ぢゃ' => 'ja', 'ぢゅ' => 'ju', 'ぢょ' => 'jo',
            'びゃ' => 'bya', 'びゅ' => 'byu', 'びょ' => 'byo',
            'ぴゃ' => 'pya', 'ぴゅ' => 'pyu', 'ぴょ' => 'pyo',
            'ぁ' => 'xa', 'ぃ' => 'xi', 'ぅ' => 'xu', 'ぇ' => 'xe', 'ぉ' => 'xo',
            'っ' => 'ltu',
            'ゃ' => 'lya', 'ゅ' => 'lyu', 'ょ' => 'lyo',
        ) + $this->mapHiragana;
        $this->mapKatakana = array(
            'ア' => 'a', 'イ' => 'i', 'ウ' => 'u', 'エ' => 'e', 'オ' => 'o',
            'カ' => 'ka', 'キ' => 'ki', 'ク' => 'ku', 'ケ' => 'ke', 'コ' => 'ko',
            'サ' => 'sa', 'シ' => 'si', 'ス' => 'su', 'セ' => 'se', 'ソ' => 'so',
            'タ' => 'ta', 'チ' => 'ti', 'ツ' => 'tu', 'テ' => 'te', 'ト' => 'to',
            'ナ' => 'na', 'ニ' => 'ni', 'ヌ' => 'nu', 'ネ' => 'ne', 'ノ' => 'no',
            'ハ' => 'ha', 'ヒ' => 'hi', 'フ' => 'hu', 'ヘ' => 'he', 'ホ' => 'ho',
            'マ' => 'ma', 'ミ' => 'mi', 'ム' => 'mu', 'メ' => 'me', 'モ' => 'mo',
            'ヤ' => 'ya', 'ユ' => 'yu', 'ヨ' => 'yo',
            'ラ' => 'ra', 'リ' => 'ri', 'ル' => 'ru', 'レ' => 're', 'ロ' => 'ro',
            'ワ' => 'wa', 'ヰ' => 'wi', 'ヱ' => 'we', 'ヲ' => 'wo',
            'ン' => 'n',
            'ガ' => 'ga', 'ギ' => 'gi', 'グ' => 'gu', 'ゲ' => 'ge', 'ゴ' => 'go',
            'ザ' => 'za', 'ジ' => 'zi', 'ズ' => 'zu', 'ゼ' => 'ze', 'ゾ' => 'zo',
            'ダ' => 'da', 'ヂ' => 'di', 'ヅ' => 'du', 'デ' => 'de', 'ド' => 'do',
            'バ' => 'ba', 'ビ' => 'bi', 'ブ' => 'bu', 'ベ' => 'be', 'ボ' => 'bo',
            'パ' => 'pa', 'ピ' => 'pi', 'プ' => 'pu', 'ペ' => 'pe', 'ポ' => 'po',
            'キャ' => 'kya', 'キュ' => 'kyu', 'キョ' => 'kyo',
            'シャ' => 'sya', 'シュ' => 'syu', 'ショ' => 'syo',
            'チャ' => 'cya', 'チュ' => 'cyu', 'チョ' => 'cyo',
            'ニャ' => 'nya', 'ニュ' => 'nyu', 'ニョ' => 'nyo',
            'ヒャ' => 'hya', 'ヒュ' => 'hyu', 'ヒョ' => 'hyo',
            'ミャ' => 'mya', 'ミュ' => 'myu', 'ミョ' => 'myo',
            'リャ' => 'rya', 'リュ' => 'ryu', 'リョ' => 'ryo',
            'ギャ' => 'gya', 'ギュ' => 'gyu', 'ギョ' => 'gyo',
            'ジャ' => 'ja', 'ジュ' => 'ju', 'ジョ' => 'jo',
            'ヂャ' => 'ja', 'ヂュ' => 'ju', 'ヂョ' => 'jo',
            'ビャ' => 'bya', 'ビュ' => 'byu', 'ビョ' => 'byo',
            'ピャ' => 'pya', 'ピュ' => 'pyu', 'ピョ' => 'pyo',
            'ァ' => 'xa', 'ィ' => 'xi', 'ゥ' => 'xu', 'ェ' => 'xe', 'ォ' => 'xo',
            'ッ' => 'ltu',
            'ャ' => 'lya', 'ュ' => 'lyu', 'ョ' => 'lyo',
            'ゎ' => 'lwa',
            'イィ' => 'ixi', 'イェ' => 'ixe',
            'ウァ' => 'uxa', 'ウィ' => 'uxi', 'ウゥ' => 'uxu', 'ウェ' => 'uxe', 'ウォ' => 'uxo',
            'ウュ' => 'uxya',
            'クァ' => 'kuxa', 'クィ' => 'kuxi', 'クェ' => 'kuxe', 'クォ' => 'kuxo',
            'クヮ' => 'kulwa',
            'グァ' => 'guxa', 'グィ' => 'guxi', 'グェ' => 'guxe', 'グォ' => 'guxo',
            'グヮ' => 'gulwa',
            'シェ' => 'sixe',
            'ジェ' => 'zixe',
            'スィ' => 'suxi',
            'ズィ' => 'zuxi',
            'チェ' => 'tixe',
            'ツァ' => 'tuxa', 'ツィ' => 'tuxi', 'ツェ' => 'tule', 'ツォ' => 'tulo',
            'ツュ' => 'tuxyu',
            'ティ' => 'texi', 'テゥ' => 'texu',
            'テュ' => 'texyu',
            'ディ' => 'dexi', 'デゥ' => 'dexu',
            'デュ' => 'dexyu',
            'ニェ' => 'nixye',
            'ヒェ' => 'hixye',
            'ビェ' => 'bixye',
            'ピェ' => 'pixye',
            'ファ' => 'fuxa', 'フィ' => 'fuxi', 'フェ' => 'fuxe', 'フォ' => 'fuxo',
            'フャ' => 'fuxya', 'フュ' => 'fuxyu', 'フィェ' => 'fuxixe', 'フョ' => 'fuxyo',
            'ホゥ' => 'hoxu',
            'ミェ' => 'mixe',
            'リェ' => 'rixe',
            Transliterator::CHOONPU => '-',
        ) + $this->mapKatakana;
    }

    /**
     * Implements fromHiragana();
     *
     * @see TransliteratorInterface
     */
    public function fromHiragana($str)
    {
        $str = $this->escapeLatinCharacters($str);
        $output = strtr($str, $this->mapHiragana);
        $output = strtr($output, $this->mapPunctuationMarks);
        $output = $this->transliterateSokuon($output);
        $output = $this->unescapeLatinCharacters($output);

        return $output;
    }

    /**
     * Implements fromKatakana();
     *
     * @see TransliteratorInterface
     */
    public function fromKatakana($str)
    {
        $str = $this->escapeLatinCharacters($str);
        $output = strtr($str, $this->mapKatakana);
        $output = strtr($output, $this->mapPunctuationMarks);
        $output = $this->transliterateSokuon($output, Transliterator::KATAKANA);
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
        return 'Hepburn romanization system (ヘボン式ローマ字)';
    }

    /**
     * Overrides transliterateSokuon().
     *
     * @see Romanization
     */
    protected function transliterateSokuon($str, $syllabary = Transliterator::HIRAGANA)
    {
        $output = parent::transliterateSokuon($str, $syllabary);
    }
}
