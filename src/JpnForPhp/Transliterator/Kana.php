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

use JpnForPhp\Analyzer\Analyzer;

/**
 * Kana transliteration class
 */
class Kana
{
    /**
     * @var array Map latin characters (or combinaison of characters) to
     * their equivalent in hiragana.
     */
    protected $mapHiragana = array(
        'a' => 'あ', 'i' => 'い', 'u' => 'う', 'e' => 'え', 'o' => 'お',
        'ka' => 'か', 'ki' => 'き', 'ku' => 'く', 'ke' => 'け', 'ko' => 'こ',
        'sa' => 'さ', 'shi' => 'し', 'si' => 'し', 'su' => 'す', 'se' => 'せ', 'so' => 'そ',
        'ta' => 'た', 'chi' => 'ち', 'ti' => 'ち', 'tsu' => 'つ', 'tu' => 'つ', 'te' => 'て', 'to' => 'と',
        'na' => 'な', 'ni' => 'に', 'nu' => 'ぬ', 'ne' => 'ね', 'no' => 'の',
        'ha' => 'は', 'hi' => 'ひ', 'fu' => 'ふ', 'hu' => 'ふ', 'he' => 'へ', 'ho' => 'ほ',
        'ma' => 'ま', 'mi' => 'み', 'mu' => 'む', 'me' => 'め', 'mo' => 'も',
        'ra' => 'ら', 'ri' => 'り', 'ru' => 'る', 're' => 'れ', 'ro' => 'ろ',
        'ya' => 'や', 'yu' => 'ゆ', 'yo' => 'よ',
        'wa' => 'わ', 'wi' => 'ゐ', 'we' => 'ゑ', 'wo' => 'を',
        'n' => 'ん', "n'" => 'ん',
        'ga' => 'が', 'gi' => 'ぎ', 'gu' => 'ぐ', 'ge' => 'げ', 'go' => 'ご',
        'za' => 'ざ', 'ji' => 'じ', 'zi' => 'じ', 'zu' => 'ず', 'ze' => 'ぜ', 'zo' => 'ぞ',
        'da' => 'だ', 'di' => 'ぢ', 'dzu' => 'づ', 'du' => 'づ', 'de' => 'で', 'do' => 'ど',
        'ba' => 'ば', 'bi' => 'び', 'bu' => 'ぶ', 'be' => 'べ', 'bo' => 'ぼ',
        'pa' => 'ぱ', 'pi' => 'ぴ', 'pu' => 'ぷ', 'pe' => 'ぺ', 'po' => 'ぽ',
        'vu' => 'ゔ',
        'kya' => 'きゃ', 'kyu' => 'きゅ', 'kyo' => 'きょ',
        'sya' => 'しゃ', 'sha' => 'しゃ', 'syu' => 'しゅ', 'shu' => 'しゅ', 'syo' => 'しょ', 'sho' => 'しょ',
        'tya' => 'ちゃ', 'cya' => 'ちゃ', 'cha' => 'ちゃ', 'tyu' => 'ちゅ', 'cyu' => 'ちゅ', 'chu' => 'ちゅ', 'tyo' => 'ちょ', 'cyo' => 'ちょ', 'cho' => 'ちょ',
        'nya' => 'にゃ', 'nyu' => 'みゅ', 'nyo' => 'にょ',
        'hya' => 'ひゃ', 'hyu' => 'ひゅ', 'hyo' => 'ひょ',
        'mya' => 'みゃ', 'myu' => 'みゅ', 'myo' => 'みょ',
        'rya' => 'りゃ', 'ryu' => 'りゅ', 'ryo' => 'りょ',
        'gya' => 'ぎゃ', 'gyu' => 'ぎゅ', 'gyo' => 'ぎょ',
        'ja' => 'じゃ', 'zya' => 'じゃ', 'jya' => 'じゃ', 'ju' => 'じゅ', 'zyu' => 'じゅ', 'jyu' => 'じゅ', 'jo' => 'じょ', 'zyo' => 'じょ', 'jyo' => 'じょ',
        'dja' => 'ぢゃ', 'dya' => 'ぢゃ', 'dju' => 'ぢゅ', 'dyu' => 'ぢゅ', 'djo' => 'ぢょ', 'dyo' => 'ぢょ',
        'bya' => 'びゃ', 'byu' => 'びゅ', 'byo' => 'びょ',
        'pya' => 'ぴゃ', 'pyu' => 'ぴゅ', 'pyo' => 'ぴょ',
    );

    /**
     * @var array Map latin characters (or combinaison of characters) to
     * their equivalent in katakana.
     */
    protected $mapKatakana = array(
        'a' => 'ア', 'i' => 'イ', 'u' => 'ウ', 'e' => 'エ', 'o' => 'オ',
        'ka' => 'カ', 'ki' => 'キ', 'ku' => 'ク', 'ke' => 'ケ', 'ko' => 'コ',
        'sa' => 'サ', 'shi' => 'シ', 'si' => 'シ', 'su' => 'ス', 'se' => 'セ', 'so' => 'ソ',
        'ta' => 'タ', 'chi' => 'チ', 'ti' => 'チ', 'tsu' => 'ツ', 'tu' => 'ツ', 'te' => 'テ', 'to' => 'ト',
        'na' => 'ナ', 'ni' => 'ニ', 'nu' => 'ヌ', 'ne' => 'ネ', 'no' => 'ノ',
        'ha' => 'ハ', 'hi' => 'ヒ', 'fu' => 'フ', 'hu' => 'フ', 'he' => 'ヘ', 'ho' => 'ホ',
        'ma' => 'マ', 'mi' => 'ミ', 'mu' => 'ム', 'me' => 'メ', 'mo' => 'モ',
        'ra' => 'ラ', 'ri' => 'リ', 'ru' => 'ル', 're' => 'レ', 'ro' => 'ロ',
        'ya' => 'ヤ', 'yu' => 'ユ', 'yo' => 'ヨ',
        'wa' => 'ワ', 'wi' => 'ヰ', 'we' => 'ヱ', 'wo' => 'ヲ',
        'n' => 'ン', "n'" => 'ン',
        'ga' => 'ガ', 'gi' => 'ギ', 'gu' => 'グ', 'ge' => 'ゲ', 'go' => 'ゴ',
        'za' => 'ザ', 'ji' => 'ジ', 'zi' => 'ジ', 'zu' => 'ズ', 'ze' => 'ゼ', 'zo' => 'ゾ',
        'da' => 'ダ', 'di' => 'ヂ', 'dzu' => 'ヅ', 'du' => 'ヅ', 'de' => 'デ', 'do' => 'ド',
        'ba' => 'バ', 'bi' => 'ビ', 'bu' => 'ブ', 'be' => 'ベ', 'bo' => 'ボ',
        'pa' => 'パ', 'pi' => 'ピ', 'pu' => 'プ', 'pe' => 'ペ', 'po' => 'ポ',
        'kya' => 'キャ', 'kyu' => 'キュ', 'kyo' => 'キョ',
        'sya' => 'シャ', 'sha' => 'シャ', 'syu' => 'シュ', 'shu' => 'シュ', 'syo' => 'ショ', 'sho' => 'ショ',
        'tya' => 'チャ', 'cya' => 'チャ', 'cha' => 'チャ', 'tyu' => 'チュ', 'cyu' => 'チュ', 'chu' => 'チュ', 'tyo' => 'チョ', 'cyo' => 'チョ', 'cho' => 'チョ',
        'nya' => 'ニャ', 'nyu' => 'ニュ', 'nyo' => 'ニョ',
        'hya' => 'ヒャ', 'hyu' => 'ヒュ', 'hyo' => 'ヒョ',
        'mya' => 'ミャ', 'myu' => 'ミュ', 'myo' => 'ミョ',
        'rya' => 'リャ', 'ryu' => 'リュ', 'ryo' => 'リョ',
        'gya' => 'ギャ', 'gyu' => 'ギュ', 'gyo' => 'ギョ',
        'ja' => 'ジャ', 'zya' => 'ジャ', 'jya' => 'ジャ', 'ju' => 'ジュ', 'zyu' => 'ジュ', 'jyu' => 'ジュ', 'jo' => 'ジョ', 'zyo' => 'ジョ', 'jyo' => 'ジョ',
        'dja' => 'ヂャ', 'dya' => 'ヂャ', 'dju' => 'ヂュ', 'dyu' => 'ヂュ', 'djo' => 'ヂョ', 'dyo' => 'ヂョ',
        'bya' => 'ビャ', 'byu' => 'ビュ', 'byo' => 'ビョ',
        'pya' => 'ピャ', 'pyu' => 'ピュ', 'pyo' => 'ピョ',
        ' ' => '　', ',' => '、', ', ' => '、',
        'yi' => 'イィ', 'ye' => 'イェ',
        //'wa' => 'ウァ', 'wi' => 'ウィ', 'wu' => 'ウゥ', 'we' => 'ウェ', 'wo' => 'ウォ',
        'wya' => 'ウュ',
        'va' => 'ヴァ', 'vi' => 'ヴィ', 'vu' => 'ヴ', 've' => 'ヴェ', 'vo' => 'ヴォ',
        'vya' => 'ヴャ', 'vyu' => 'ヴュ', 'vye' => 'ヴィェ', 'vyo' => 'ヴョ',
        'kye' => 'キェ',
        'gye' => 'ギェ',
        'kwa' => 'クァ', 'kwi' => 'クィ', 'kwe' => 'クェ', 'kwo' => 'クォ',
        //'kwa' => 'クヮ',
        'gwa' => 'グァ', 'gwi' => 'グィ', 'gwe' => 'グェ', 'gwo' => 'グォ',
        //'gwa' => 'グヮ',
        'she' => 'シェ',
        'je' => 'ジェ',
        //'si' => 'スィ',
        //'zi' => 'ズィ',
        'che' => 'チェ',
        'tsa' => 'ツァ', 'tsi' => 'ツィ', 'tse' => 'ツェ', 'tso' => 'ツォ',
        'tsyu' => 'ツュ',
        //'ti' => 'ティ', 'tu' => 'テゥ',
        //'di' => 'ディ', 'du' => 'デゥ',
        //'dyu' => 'デュ',
        'nye' => 'ニェ',
        'hye' => 'ヒェ',
        'bye' => 'ビェ',
        'pye' => 'ピェ',
        'fa' => 'ファ', 'fi' => 'フィ', 'fe' => 'フェ', 'fo' => 'フォ',
        'fya' => 'フャ', 'fyu' => 'フュ', 'fye' => 'フィェ', 'fyo' => 'フョ',
        //'hu' => 'ホゥ',
        'mye' => 'ミェ',
        'rye' => 'リェ',
        'la' => 'ラ゜', 'li' => 'リ゜', 'lu' => 'ル゜', 'le' => 'レ゜', 'lo' => 'ロ゜',
        //'va' => 'ヷ', 'vi' => 'ヸ', 've' => 'ヹ', 'vo' => 'ヺ',
    );

    /**
     * @var array Map latin form of various marks, punctuation, hyphen, etc. to
     * their equivalent in Japanese syllabary.
     */
    protected $mapMarks = array(
        ' ' => '　', ',' => '、', ', ' => '、', '-' => '・',
        '(' => '（', ')' => '）',
    );

    /**
     * Transliterate a string from latin alphabet into hiragana.
     *
     * @param string $str The string to be converted.
     *
     * @return string Converted string into hiragana.
     */
    public function toHiragana($str)
    {
        $str = $this->prepareTransliteration($str, Transliterator::HIRAGANA);
        $str = $this->transliterateSokuon($str, Transliterator::HIRAGANA);
        $str = $this->transliterateQuotationMarks($str);
        $output = strtr($str, $this->mapHiragana);
        $output = strtr($output, $this->mapMarks);

        return $output;
    }

    /**
     * Transliterate a string from latin alphabet into katakana.
     *
     * @param string $str The string to be converted.
     *
     * @return string Converted string into katakana.
     */
    public function toKatakana($str)
    {
        $str = $this->prepareTransliteration($str,Transliterator::KATAKANA);
        $str = $this->transliterateSokuon($str, Transliterator::KATAKANA);
        $str = $this->transliterateQuotationMarks($str);
        $output = strtr($str, $this->mapKatakana);
        $output = strtr($output, $this->mapMarks);

        return $output;
    }

    /**
     * Prepare a string for its transliteration in kana.
     *
     * @param string $str String to be prepared.
     *
     * @param string $syllabary Syllabary to use
     *
     * @return string Prepared string.
     */
    protected function prepareTransliteration($str, $syllabary)
    {
        $str = mb_strtolower($str, 'UTF-8');
        $mapChars = array();
        if ($syllabary === Transliterator::HIRAGANA) {
            $mapChars = array(
                'ā' => 'aa', 'ī' => 'ii', 'ū' => 'uu', 'ē' => 'ee', 'ō' => 'ou',
                'ô' => 'ou',
            );
        } elseif ($syllabary === Transliterator::KATAKANA) {
            $mapChars = array(
            'aa' => 'a'.Transliterator::CHOONPU, 'ii' => 'i'.Transliterator::CHOONPU,
            'uu' => 'u'.Transliterator::CHOONPU, 'ee' => 'e'.Transliterator::CHOONPU,
            'oo' => 'o'.Transliterator::CHOONPU, 'ā' => 'a'.Transliterator::CHOONPU,
            'ī' => 'i'.Transliterator::CHOONPU, 'ū' => 'u'.Transliterator::CHOONPU,
            'ē' => 'e'.Transliterator::CHOONPU, 'ō' => 'o'.Transliterator::CHOONPU,
            'ô' => 'o'.Transliterator::CHOONPU,
            );
        } else {
            return $str;
        }

        $prepared_s = strtr($str, $mapChars);

        return $prepared_s;
    }

    /**
     * Transliterate proper combinaisons of latin alphabet characters into
     * Sokuon (http://en.wikipedia.org/wiki/Sokuon) characters.
     *
     * @param string $str       String to be transliterated.
     * @param string $syllabary Syllabary to use ; either Hiragana or
     * Katakana.
     *
     * @return string Transliterated string.
     */
    protected function transliterateSokuon($str, $syllabary)
    {
        $new_str = $str;
        $length = Analyzer::length($str);

        //No need to go further.
        if ($length < 2) {
            return $new_str;
        }

        $sokuon = ($syllabary === Transliterator::HIRAGANA) ? Transliterator::SOKUON_HIRAGANA : Transliterator::SOKUON_KATAKANA;
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
        return preg_replace('/"(.*)"/u', '「${1}」', $str);
    }

}
