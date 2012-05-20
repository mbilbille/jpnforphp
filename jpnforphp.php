<?php

/**
 * JpnForPhp library, brings some usefull tools and functionalities
 * to interact with Japanese characters.
 *
 * @author      Matthieu Bilbille
 * @link	https://github.com/mbilbille/jpnforphp
 * @version	0.0.1
 */
class JpnForPhp {

    const HIRAGANA = 0;
    const KATAKANA = 1;

    /**
     * Looks for kanji within a given string.
     * 
     * @param $str
     *  The string to process.
     * @return
     *  TRUE if it contains at least one kanji, otherwise FALSE.
     */
    public static function has_kanji($str) {
        return preg_match('/[\x{4E00}-\x{9FBF}]/u', $str) > 0;
    }

    /**
     * Looks for hiragana within the specified string.
     * 
     * @param $str
     *  The string to process.
     * @return
     *  TRUE if it contains at least one hiragana, otherwise FALSE.
     */
    public static function has_hiragana($str) {
        return preg_match('/[\x{3040}-\x{309F}]/u', $str) > 0;
    }

    /**
     * Looks for katakana within the specified string.
     * 
     * @param $str
     *  The string to process.
     * @return
     *  TRUE if it contains at least one katakana, otherwise FALSE.
     */
    public static function has_katakana($str) {
        return preg_match('/[\x{30A0}-\x{30FF}]/u', $str) > 0;
    }

    /**
     * Check if the specified string uses Japanese characters
     */

    /**
     * Looks for Japanese characters within a given string.
     * 
     * @param $str
     *  The string to process.
     * @return
     *  TRUE if it contains either kanji, hiragana or katakana, otherwise FALSE.
     */
    public static function is_japanese($str) {
        return self::has_kanji($str) || self::has_hiragana($str) || self::has_katakana($str);
    }

    /**
     * Convert a given string in romaji into hiragana.
     * @param $romaji 
     *  The string to be converted.
     * @return
     *  Converted string into hiragana.
     */
    public static function romaji_to_hiragana($romaji) {

        $romaji = strtolower($romaji);
        $output = self::convert_chiisai_tsu($romaji, self::HIRAGANA);
        $table = array(
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
            'n' => 'ん',
            'ga' => 'が', 'gi' => 'ぎ', 'gu' => 'ぐ', 'ge' => 'げ', 'go' => 'ご',
            'za' => 'ざ', 'ji' => 'じ', 'zi' => 'じ', 'zu' => 'ず', 'ze' => 'ぜ', 'zo' => 'ぞ',
            'da' => 'だ', 'di' => 'ぢ', 'dzu' => 'づ', 'du' => 'づ', 'de' => 'で', 'do' => 'ど',
            'ba' => 'ば', 'bi' => 'び', 'bu' => 'ぶ', 'be' => 'べ', 'bo' => 'ぼ',
            'pa' => 'ぱ', 'pi' => 'ぴ', 'pu' => 'ぷ', 'pe' => 'ぺ', 'po' => 'ぽ',
            'vu' => 'ゔ',
            'kya' => 'きゃ', 'kyu' => 'きゅ', 'kyo' => 'きょ',
            'sya' => 'しゃ', 'sha' => 'しゃ', 'syu' => 'しゅ', 'shu' => 'しゅ', 'syo' => 'しょ', 'sho' => 'しょ',
            'cya' => 'ちゃ', 'cha' => 'ちゃ', 'cyu' => 'ちゅ', 'chu' => 'ちゅ', 'cyo' => 'ちょ', 'cho' => 'ちょ',
            'nya' => 'にゃ', 'nyu' => 'みゅ', 'nyo' => 'にょ',
            'hya' => 'ひゃ', 'hyu' => 'ひゅ', 'hyo' => 'ひょ',
            'mya' => 'みゃ', 'myu' => 'みゅ', 'myo' => 'みょ',
            'rya' => 'りゃ', 'ryu' => 'りゅ', 'ryo' => 'りょ',
            'gya' => 'ぎゃ', 'gyu' => 'ぎゅ', 'gyo' => 'ぎょ',
            'ja' => 'じゃ', 'jya' => 'じゃ', 'ju' => 'じゅ', 'jyu' => 'じゅ', 'jo' => 'じょ', 'jyo' => 'じょ',
            'dja' => 'ぢゃ', 'dya' => 'ぢゃ', 'dju' => 'ぢゅ', 'dyu' => 'ぢゅ', 'djo' => 'ぢょ', 'dyo' => 'ぢょ',
            'bya' => 'びゃ', 'byu' => 'びゅ', 'byo' => 'びょ',
            'pya' => 'ぴゃ', 'pyu' => 'ぴゅ', 'pyo' => 'ぴょ',
            ' ' => '　',
        );
        $output = strtr($output, $table);
        return $output;
    }

    /**
     * Convert a given string in romaji into katakana.
     * @param $katakana 
     *  The string to be converted.
     * @return
     *  Converted string into katakana.
     */
    public static function romaji_to_katakana($romaji) {

        $romaji = strtolower($romaji);
        $output = self::convert_chiisai_tsu($romaji, self::KATAKANA);
        $table = array(
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
            'n' => 'ン',
            'ga' => 'ガ', 'gi' => 'ギ', 'gu' => 'グ', 'ge' => 'ゲ', 'go' => 'ゴ',
            'za' => 'ザ', 'ji' => 'ジ', 'zi' => 'ジ', 'zu' => 'ズ', 'ze' => 'ゼ', 'zo' => 'ゾ',
            'da' => 'ダ', 'di' => 'ヂ', 'dzu' => 'ヅ', 'du' => 'ヅ', 'de' => 'デ', 'do' => 'ド',
            'ba' => 'バ', 'bi' => 'ビ', 'bu' => 'ブ', 'be' => 'ベ', 'bo' => 'ボ',
            'pa' => 'パ', 'pi' => 'ピ', 'pu' => 'プ', 'pe' => 'ペ', 'po' => 'ポ',
            'vu' => 'ヴ',
            'kya' => 'キャ', 'kyu' => 'キュ', 'kyo' => 'キョ',
            'sya' => 'シャ', 'sha' => 'シャ', 'syu' => 'シュ', 'shu' => 'シュ', 'syo' => 'ショ', 'sho' => 'ショ',
            'cya' => 'チャ', 'cha' => 'チャ', 'cyu' => 'チュ', 'chu' => 'チュ', 'cyo' => 'チョ', 'cho' => 'チョ',
            'nya' => 'ニャ', 'nyu' => 'ニュ', 'nyo' => 'ニョ',
            'hya' => 'ヒャ', 'hyu' => 'ヒュ', 'hyo' => 'ヒョ',
            'mya' => 'ミャ', 'myu' => 'ミュ', 'myo' => 'ミョ',
            'rya' => 'リャ', 'ryu' => 'リュ', 'ryo' => 'リョ',
            'gya' => 'ギャ', 'gyu' => 'ギュ', 'gyo' => 'ギョ',
            'ja' => 'ジャ', 'jya' => 'ジャ', 'ju' => 'ジュ', 'jyu' => 'ジュ', 'jo' => 'ジョ', 'jyo' => 'ジョ',
            'dja' => 'ヂャ', 'dya' => 'ヂャ', 'dju' => 'ヂュ', 'dyu' => 'ヂュ', 'djo' => 'ヂョ', 'dyo' => 'ヂョ',
            'bya' => 'ビャ', 'byu' => 'ビュ', 'byo' => 'ビョ',
            'pya' => 'ピャ', 'pyu' => 'ピュ', 'pyo' => 'ピョ',
            ' ' => '　',
                //@todo handle small characters like ぁ　ぃ　ぅ　ぇ　ぉ
        );
        $output = strtr($output, $table);
        return $output;
    }

    /**
     *
     * @param type $str
     * @param type $alpha
     * @return type 
     */
    private static function convert_chiisai_tsu($str, $syllabary) {
        $new_str = $str;
        $length = strlen($str);

        //No need to go further.
        if ($length < 2)
            return $new_str;

        $chiisai_tsu = ($syllabary == self::HIRAGANA) ? 'っ' : 'ッ';
        $skip = array('a', 'i', 'u', 'e', 'o', 'n');

        for ($i = 1; $i < $length; $i++) {
            $char = substr($str, $i - 1, 1);
            if (!in_array($char, $skip) && $char === substr($str, $i, 1)) {
                $new_str = substr_replace($str, $chiisai_tsu, $i - 1, 1);
            }
        }

        return $new_str;
    }

}

?>