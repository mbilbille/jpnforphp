<?php

namespace JpnForPhp\Transliterator;

use JpnForPhp\JpnForPhp;

/**
 * Hepburn system class
 */
class Hepburn implements Transliterator
{

    /**
     * @var array Map hiragana characters (or combinaison of characters) to
     * their equivalent in latin alphabet.
     */
    private $mapHiragana = array(
        'あ' => 'a', 'い' => 'i', 'う' => 'u', 'え' => 'e', 'お' => 'o',
        'か' => 'ka', 'き' => 'ki', 'く' => 'ku', 'け' => 'ke', 'こ' => 'ko',
        'さ' => 'sa', 'し' => 'shi', 'す' => 'su', 'せ' => 'se', 'そ' => 'so',
        'た' => 'ta', 'ち' => 'chi', 'つ' => 'tsu', 'て' => 'te', 'と' => 'to',
        'な' => 'na', 'に' => 'ni', 'ぬ' => 'nu', 'ね' => 'ne', 'の' => 'no',
        'は' => 'ha', 'ひ' => 'hi', 'ふ' => 'fu', 'へ' => 'he', 'ほ' => 'ho',
        'ま' => 'ma', 'み' => 'mi', 'む' => 'mu', 'め' => 'me', 'も' => 'mo',
        'や' => 'ya', 'ゆ' => 'yu', 'よ' => 'yo',
        'ら' => 'ra', 'り' => 'ri', 'る' => 'ru', 'れ' => 're', 'ろ' => 'ro',
        'わ' => 'wa', 'ゐ' => 'wi', 'ゑ' => 'we', 'を' => 'wo',
        'ん' => 'n',
        'が' => 'ga', 'ぎ' => 'gi', 'ぐ' => 'gu', 'げ' => 'ge', 'ご' => 'go',
        'ざ' => 'za', 'じ' => 'ji', 'ず' => 'zu', 'ぜ' => 'ze', 'ぞ' => 'zo',
        'だ' => 'da', 'ぢ' => 'ji', 'づ' => 'zu', 'で' => 'de', 'ど' => 'do',
        'ば' => 'ba', 'び' => 'bi', 'ぶ' => 'bu', 'べ' => 'be', 'ぼ' => 'bo',
        'ぱ' => 'pa', 'ぴ' => 'pi', 'ぷ' => 'pu', 'ぺ' => 'pe', 'ぽ' => 'po',
        'ゔ' => 'vu',
        'きゃ' => 'kya', 'きゅ' => 'kyu', 'きょ' => 'kyo',
        'しゃ' => 'sha', 'しゅ' => 'shu', 'しょ' => 'sho',
        'ちゃ' => 'cha', 'ちゅ' => 'chu', 'ちょ' => 'cho',
        'にゃ' => 'nya', 'にゅ' => 'nyu', 'にょ' => 'nyo',
        'ひゃ' => 'hya', 'ひゅ' => 'hyu', 'ひょ' => 'hyo',
        'みゃ' => 'mya', 'みゅ' => 'myu', 'みょ' => 'myo',
        'りゃ' => 'rya', 'りゅ' => 'ryu', 'りょ' => 'ryo',
        'ぎゃ' => 'gya', 'ぎゅ' => 'gyu', 'ぎょ' => 'gyo',
        'じゃ' => 'ja', 'じゅ' => 'ju', 'じょ' => 'jo',
        'ぢゃ' => 'ja', 'ぢゅ' => 'ju', 'ぢょ' => 'jo',
        'びゃ' => 'bya', 'びゅ' => 'byu', 'びょ' => 'byo',
        'ぴゃ' => 'pya', 'ぴゅ' => 'pyu', 'ぴょ' => 'pyo',
        '　' => ' ', '、' => ',　',
    );

    /**
     * @var array Map katakana characters (or combinaison of characters) to
     * their equivalent in latin alphabet.
     */
    private $mapKatakana = array(
        'ア' => 'a', 'イ' => 'i', 'ウ' => 'u', 'エ' => 'e', 'オ' => 'o',
        'カ' => 'ka', 'キ' => 'ki', 'ク' => 'ku', 'ケ' => 'ke', 'コ' => 'ko',
        'サ' => 'sa', 'シ' => 'shi', 'ス' => 'su', 'セ' => 'se', 'ソ' => 'so',
        'タ' => 'ta', 'チ' => 'chi', 'ツ' => 'tsu', 'テ' => 'te', 'ト' => 'to',
        'ナ' => 'na', 'ニ' => 'ni', 'ヌ' => 'nu', 'ネ' => 'ne', 'ノ' => 'no',
        'ハ' => 'ha', 'ヒ' => 'hi', 'フ' => 'fu', 'ヘ' => 'he', 'ホ' => 'ho',
        'マ' => 'ma', 'ミ' => 'mi', 'ム' => 'mu', 'メ' => 'me', 'モ' => 'mo',
        'ヤ' => 'ya', 'ユ' => 'yu', 'ヨ' => 'yo',
        'ラ' => 'ra', 'リ' => 'ri', 'ル' => 'ru', 'レ' => 're', 'ロ' => 'ro',
        'ワ' => 'wa', 'ヰ' => 'wi', 'ヱ' => 'we', 'ヲ' => 'wo',
        'ン' => 'n',
        'ガ' => 'ga', 'ギ' => 'gi', 'グ' => 'gu', 'ゲ' => 'ge', 'ゴ' => 'go',
        'ザ' => 'za', 'ジ' => 'ji', 'ズ' => 'zu', 'ゼ' => 'ze', 'ゾ' => 'zo',
        'ダ' => 'da', 'ヂ' => 'ji', 'ヅ' => 'zu', 'デ' => 'de', 'ド' => 'do',
        'バ' => 'ba', 'ビ' => 'bi', 'ブ' => 'bu', 'ベ' => 'be', 'ボ' => 'bo',
        'パ' => 'pa', 'ピ' => 'pi', 'プ' => 'pu', 'ペ' => 'pe', 'ポ' => 'po',
        'ヴ' => 'vu',
        'キャ' => 'kya', 'キュ' => 'kyu', 'キョ' => 'kyo',
        'シャ' => 'sha', 'シュ' => 'shu', 'ショ' => 'sho',
        'チャ' => 'cha', 'チュ' => 'chu', 'チョ' => 'cho',
        'ニャ' => 'nya', 'ニュ' => 'nyu', 'ニョ' => 'nyo',
        'ヒャ' => 'hya', 'ヒュ' => 'hyu', 'ヒョ' => 'hyo',
        'ミャ' => 'mya', 'ミュ' => 'myu', 'ミョ' => 'myo',
        'リャ' => 'rya', 'リュ' => 'ryu', 'リョ' => 'ryo',
        'ギャ' => 'gya', 'ギュ' => 'gyu', 'ギョ' => 'gyo',
        'ジャ' => 'ja', 'ジュ' => 'ju', 'ジョ' => 'jo',
        'ヂャ' => 'ja', 'ヂュ' => 'ju', 'ヂョ' => 'jo',
        'ビャ' => 'bya', 'ビュ' => 'byu', 'ビョ' => 'byo',
        'ピャ' => 'pya', 'ピュ' => 'pyu', 'ピョ' => 'pyo',
        '　' => ' ', '、' => ',　',
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
    );

    /**
     * Implements fromHiragana();
     *
     * @see Transliterator
     */
    public function fromHiragana($str)
    {
        $output = strtr($str, $this->mapHiragana);
        $output = $this->transliterateSokuon($output);

        return $output;
    }

    /**
     * Implements fromKatakana();
     *
     * @see Transliterator
     */
    public function fromKatakana($str)
    {
        $output = strtr($str, $this->mapKatakana);
        $output = $this->transliterateSokuon($output, JpnForPhp::JPNFORPHP_KATAKANA);
        $output = $this->transliterateChoonpu($output);

        return $output;
    }

    /**
     * Implements transliterateSokuon().
     *
     * @see Transliterator
     */
    public function transliterateSokuon($str, $syllabary = JpnForPhp::JPNFORPHP_HIRAGANA)
    {
        if ($syllabary === JpnForPhp::JPNFORPHP_KATAKANA) {
            $sokuon = JpnForPhp::JPNFORPHP_SOKUON_KATAKANA;
        } else {
            $sokuon = JpnForPhp::JPNFORPHP_SOKUON_HIRAGANA;
        }

        $output = preg_replace('/' . $sokuon . '(.)/u', '${1}${1}', $str);

        // As per Hepburn system ch > tch
        // (http://en.wikipedia.org/wiki/Hepburn_romanization#Double_consonants)
        return preg_replace('/cch/', 'tch', $output);
    }

    /**
     * Implements transliterateChoonpu().
     *
     * @see Transliterator
     */
    public function transliterateChoonpu($str)
    {
        $macrons = array(
            'a' => 'ā',
            'i' => 'ī',
            'u' => 'ū',
            'e' => 'ē',
            'o' => 'ō',
        );

        return preg_replace('/(.)' . JpnForPhp::JPNFORPHP_CHOONPU . '/ue', '$macrons[\'${1}\']', $str);
    }

}
