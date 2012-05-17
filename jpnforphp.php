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

    /**
     * Looks for kanji within a given string.
     * 
     * @param $str
     *  The string to process.
     * @return
     *  TRUE if it contains at least one kanji, otherwise FALSE.
     */
    static function has_kanji($str) {
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
    static function has_hiragana($str) {
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
    static function has_katakana($str) {
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
    static function is_japanese($str) {
        return JpnForPhp::has_kanji($str) || JpnForPhp::has_hiragana($str) || JpnForPhp::has_katakana($str);
    }

    /**
     * Convert a given string in romaji into hiragana.
     * @param $romaji 
     *  The string to convert.
     * @return
     *  Converted string into hiragana.
     */
    static function romaji_to_hiragana($romaji) {

        $romaji = strtolower($romaji);

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
                //@todo FINISH IT!!!!!!!
        );
        return strtr($romaji, $table);
    }

    
    static function tsu($str){
        $new_str = $str;
        $length = strlen($str);
        
        //No need to go further.
        if($length < 2) return $new_str;
        
        $skip = array('a', 'i', 'u', 'e', 'o', 'n');
        
        for($i = 1; $i < $length; $i++){
            $char = substr($str, $i-1, 1);
            if(!in_array($char, $skip) && $char === substr($str, $i, 1)){
                $new_str = substr_replace($str, 'っ', $i-1, 1);
            }
        }
        
        return $new_str;
    }
}
?>