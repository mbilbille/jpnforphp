<?php

/**
 * JpnForPhp library, brings some usefull tools and functionalities
 * to interact with Japanese characters.
 *
 * @author      Matthieu Bilbille
 * @link	https://github.com/mbilbille/jpnforphp
 * @version	0.1
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
     * @param $romaji 
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
     * Convert a given string in hiragana into romaji.
     * @param $hiragana 
     *  The string to be converted.
     * @return
     *  Converted string into romaji.
     */
    public static function hiragana_to_romaji($hiragana) {

        $table = array(
            'あ' => 'a', 'い' => 'i', 'う' => 'u', 'え' => 'e', 'お' => 'o',
            'か' => 'ka', 'き' => 'ki', 'く' => 'ku', 'け' => 'ke', 'こ' => 'ko',
            'さ' => 'sa', 'し' => 'shi', 'す' => 'su', 'せ' => 'se', 'そ' => 'so',
            'た' => 'ta', 'ち' => 'chi', 'つ' => 'tsu', 'て' => 'te', 'と' => 'to',
            'な' => 'na', 'に' => 'ni', 'ぬ' => 'nu', 'ね' => 'ne', 'の' => 'no',
            'は' => 'ha', 'ひ' => 'hi', 'ふ' => 'fu', 'へ' => 'he', 'ほ' => 'ho',
            'ま' => 'ma', 'み' => 'mi', 'む' => 'mu', 'め' => 'me', 'も' => 'mo',
            'ら' => 'ra', 'り' => 'ri', 'る' => 'ru', 'れ' => 're', 'ろ' => 'ro',
            'や' => 'ya', 'ゆ' => 'yu', 'よ' => 'yo',
            'わ' => 'wa', 'ゐ' => 'wi', 'ゑ' => 'we', 'を' => 'wo',
            'が' => 'ga', 'ぎ' => 'gi', 'ぐ' => 'gu', 'げ' => 'ge', 'ご' => 'go',
            'ざ' => 'za', 'じ' => 'ji', 'ず' => 'zu', 'ぜ' => 'ze', 'ぞ' => 'zo',
            'だ' => 'da', 'ぢ' => 'di', 'づ' => 'du', 'で' => 'de', 'ど' => 'do',
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
            'ぢゃ' => 'dja', 'ぢゅ' => 'dju', 'ぢょ' => 'djo',
            'びゃ' => 'bya', 'びゅ' => 'byu', 'びょ' => 'byo',
            'ぴゃ' => 'pya', 'ぴゅ' => 'pyu', 'ぴょ' => 'pyo',
            '　' => ' ',
        );
        $output = strtr($hiragana, $table);
        $output = self::translate_chiisai_tsu($output);
        return $output;
    }
    
    /**
     * Convert a given string in katakana into romaji.
     * @param $katakana 
     *  The string to be converted.
     * @return
     *  Converted string into romaji.
     */
    public static function katakana_to_romaji($katakana) {

        $table = array(
            'ア' => 'a', 'イ' => 'i', 'ウ' => 'u', 'エ' => 'e', 'オ' => 'o',
            'カ' => 'ka', 'キ' => 'ki', 'ク' => 'ku', 'ケ' => 'ke', 'コ' => 'ko',
            'サ' => 'sa', 'シ' => 'shi', 'ス' => 'su', 'セ' => 'se', 'ソ' => 'so',
            'タ' => 'ta', 'チ' => 'chi', 'ツ' => 'tsu', 'テ' => 'te', 'ト' => 'to',
            'ナ' => 'na', 'ニ' => 'ni', 'ヌ' => 'nu', 'ネ' => 'ne', 'ノ' => 'no',
            'ハ' => 'ha', 'ヒ' => 'hi', 'フ' => 'fu', 'ヘ' => 'he', 'ホ' => 'ho',
            'マ' => 'ma', 'ミ' => 'mi', 'ム' => 'mu', 'メ' => 'me', 'モ' => 'mo',
            'レ' => 'ra', 'リ' => 'ri', 'ル' => 'ru', 'レ' => 're', 'ロ' => 'ro',
            'ヤ' => 'ya', 'ユ' => 'yu', 'ヨ' => 'yo',
            'ワ' => 'wa', 'ヰ' => 'wi', 'ヱ' => 'we', 'ヲ' => 'wo',
            'ガ' => 'ga', 'ギ' => 'gi', 'グ' => 'gu', 'ゲ' => 'ge', 'ゴ' => 'go',
            'ザ' => 'za', 'ジ' => 'ji', 'ズ' => 'zu', 'ゼ' => 'ze', 'ゾ' => 'zo',
            'ダ' => 'da', 'ヂ' => 'di', 'ヅ' => 'du', 'デ' => 'de', 'ド' => 'do',
            'バ' => 'ba', 'ビ' => 'bi', 'ブ' => 'bu', 'ベ' => 'be', 'ボ' => 'bo',
            'パ' => 'pa', 'ピ' => 'pi', 'プ' => 'pu', 'ペ' => 'pe', 'ポ' => 'po',
            'ヴ' => 'vu',
            'キャ' => 'kya', 'キュ' => 'kyu', 'キョ' => 'kyo',
            'シャ' => 'sha', 'シュ' => 'shu', 'ショ' => 'sho',
            'チャ' => 'cha', 'チュ' => 'chu', 'チョ' => 'cho',
            'ニャ' => 'nya', 'ニュ' => 'nyu', 'ニョ' => 'nyo',
            'ヒャ' => 'hya', 'ヒュ' => 'hyu', 'ヒョ' => 'hyo',
            'ミャ' => 'mya', 'ミュ' => 'myu', 'ピョ' => 'myo',
            'リャ' => 'rya', 'リュ' => 'ryu', 'リョ' => 'ryo',
            'ギャ' => 'gya', 'ギュ' => 'gyu', 'ギョ' => 'gyo',
            'ジャ' => 'ja', 'ジュ' => 'ju', 'ジョ' => 'jo',
            'ヂャ' => 'dja', 'ヂュ' => 'dju', 'ヂョ' => 'djo',
            'ビャ' => 'bya', 'ビュ' => 'byu', 'ビョ' => 'byo',
            'ピャ' => 'pya', 'ピュ' => 'pyu', 'ピョ' => 'pyo',
            '　' => ' ',
        );
        $output = strtr($katakana, $table);
        $output = self::translate_chiisai_tsu($output);
        return $output;
    }

    public static function split($str, $length = 1) {
        $chrs = array();
        $str_length = mb_strlen($str, 'UTF-8');
        for ($i = 0; $i < $str_length; $i++) {
            $chrs[] = mb_substr($str, $i, $length, 'UTF-8');
        }
        return $chrs;
    }

    /**
     * Look into a given string to identify and convert potential sets of 
     * characters into small tsu characters.
     * 
     * @param $str
     *  String to look into.
     * @param $syllabary
     *  Syllabary to be used ; either Hiragana or Katakana.
     * @return
     *  Converted string.
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
            $previous_char = substr($str, $i - 1, 1);
            if (!in_array($previous_char, $skip) && $previous_char === substr($str, $i, 1)) {
                $new_str = substr_replace($str, $chiisai_tsu, $i - 1, 1);
            }
        }
        return $new_str;
    }

    /**
     * Translate any small tsu characters into its equivalent in romaji.
     * 
     * @param $str
     *  String to be translated.
     * @return
     *  Translated string.
     */
    private static function translate_chiisai_tsu($str) {
        $new_str = $str;

        $chrs = self::split($str);
        $length = count($chrs);

        //No need to go further.
        if ($length < 2)
            return $new_str;

        for ($i = 0; $i < $length - 1; $i++) {
            if ($chrs[$i] === 'っ' || $chrs[$i] === 'ッ') {
                $chrs[$i] = $chrs[$i + 1];
            }
        }
        $new_str = implode($chrs);
        return $new_str;
    }

}

?>