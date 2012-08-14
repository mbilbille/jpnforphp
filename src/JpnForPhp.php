<?php

require_once 'Transliterator/Hepburn.php';
//require_once 'Transliterator/KunreiShiki.php';
//require_once 'Transliterator/NihonShiki.php';

/**
 * JpnForPhp library, brings some useful tools and functionalities to interact 
 * with Japanese characters.
 *
 * @author      Matthieu Bilbille
 * @link	https://github.com/mbilbille/jpnforphp
 * @version	0.3.1
 */

/**
 * JpnForPhp main class
 */
class JpnForPhp
{
    /**
     * JpnForPhp constants
     * Highly recommended to use these constant names rather than raw values.
     */
    
    // Syllabaries
    const JPNFORPHP_HIRAGANA = 0;                   // Hiragana
    const JPNFORPHP_KATAKANA = 1;                   // Katakana
    // Romanization systems
    const JPNFORPHP_HEPBURN = 'Hepburn';            // Hepburn romanization
    const JPNFORPHP_KUNREISHIKI = 'KunreiShiki';    // Kunrei-shiki Romaji
    const JPNFORPHP_NIHONSHIKI = 'NihonShiki';      // Nihon-shiki Romaji
    // Special characters
    const JPNFORPHP_SOKUON_HIRAGANA = 'っ';
    const JPNFORPHP_SOKUON_KATAKANA = 'ッ';
    const JPNFORPHP_CHOONPU = 'ー';

    /**
     * Get string length.
     * @see http://fr.php.net/manual/en/function.mb-strlen.php
     *
     * @param $str
     *   The string being measured for length.
     * @return int
     *   An integer.
     */
    public static function length($str)
    {
        return mb_strlen($str, 'UTF-8');
    }

    /**
     * Enhance default splitter function to handle UTF-8 characters.
     *
     * @param $str
     *   String to split.
     * @param $length (optional)
     *   Define an optional substring length. Default to 1.
     * @return array
     *   An array of strings.
     */
    public static function split($str, $length = 1)
    {
        $chrs = array();
        $str_length = self::length($str);
        for ($i = 0; $i < $str_length; $i++) {
            $chrs[] = mb_substr($str, $i, $length, 'UTF-8');
        }

        return $chrs;
    }

    /**
     * Returns a new string that is a substring of the given string.
     *
     * @param $str
     *   The input string.
     * @param $begin
     *   The beginning index, inclusive.
     * @param $len
     *   Maximum number of characters to use from str.
     * @return string
     *   A substring
     */
    public static function subString($str, $begin, $len)
    {
        return mb_substr($str, $begin, $len, 'UTF-8');
    }

    /**
     * Returns the character at the specified index.
     *
     * @param $str
     *   The input string.
     * @param $index
     *   The index of the character to return (0 based indexing).
     * @return string
     *   The character at the specified index.
     */
    public static function charAt($str, $index)
    {
        return self::subString($str, $index, 1);
    }

    /**
     * Inspects a given string and returns useful details about it.
     *
     * @param $str
     *   String to be inspected.
     * @return array
     *   An associative array containing the following items:
     *   - "length" : string length.
     *   - "kanji" : number of kanji within this string.
     *   - "hiragana" : number of hiragana within this string.
     *   - "katakana" : number of katakana within this string.
     */
    public static function inspect($str)
    {
        $result = array(
            'length' => 0,
            'kanji' => 0,
            'hiragana' => 0,
            'katakana' => 0,
        );

        $result['length'] = self::length($str);
        $result['kanji'] = self::countKanji($str);
        $result['hiragana'] = self::countHiragana($str);
        $result['katakana'] = self::countKatakana($str);

        return $result;
    }

    /**
     * Count number of kanji within the specified string.
     *
     * @param $str
     *   String to be inspected.
     * @return int
     *   An integer.
     */
    public static function countKanji($str)
    {
        $matches = array();

        return preg_match_all('/\p{Han}/u', $str, $matches);
    }

    /**
     * Count number of hiragana within the specified string.
     *
     * @param $str
     *   String to be inspected.
     * @return int
     *   An integer.
     */
    public static function countHiragana($str)
    {
        $matches = array();

        return preg_match_all('/\p{Hiragana}/u', $str, $matches);
    }

    /**
     * Count number of katakana within the specified string. Chōonpu 
     * (http://en.wikipedia.org/wiki/Chōonpu) is considered as Katakana here.
     *
     * @param $str
     *   String to be inspected.
     * @return int
     *   An integer.
     */
    public static function countKatakana($str)
    {
        $matches = array();

        return preg_match_all('/\p{Katakana}|' . self::JPNFORPHP_CHOONPU . '/u', $str, $matches);
    }

    /**
     * Determines whether the given string contains kanji characters.
     *
     * @param $str
     *   String to inspect.
     * @return bool
     *   TRUE if it contains at least one kanji, otherwise FALSE.
     */
    public static function hasKanji($str)
    {
        return preg_match('/\p{Han}/u', $str) > 0;
    }

    /**
     * Determines whether the given string contains hiragana characters.
     *
     * @param $str
     *   String to inspect.
     * @return bool
     *   TRUE if it contains at least one hiragana, otherwise FALSE.
     */
    public static function hasHiragana($str)
    {
        return preg_match('/\p{Hiragana}/u', $str) > 0;
    }

    /**
     * Determines whether the given string contains katakana characters.
     *
     * @param $str
     *   String to inspect.
     * @return bool
     *   TRUE if it contains at least one katakana, otherwise FALSE.
     */
    public static function hasKatakana($str)
    {
        return preg_match('/\p{Katakana}/u', $str) > 0;
    }

    /**
     * Determines whether the given string contains
     * Japanese characters (kanji, hiragana or katakana).
     *
     * @param $str
     *   String to inspect.
     * @return bool
     *   TRUE if it contains either kanji, hiragana or katakana, otherwise 
     *   FALSE.
     */
    public static function hasJapaneseChars($str)
    {
        return self::hasKanji($str) || self::hasHiragana($str) || self::hasKatakana($str);
    }

    /**
     * Remove hidden LTR Mark character. trim() and variant
     * will ignore it
     *
     * @param $str
     * 	String to look into
     * @return string
     * 	Cleaned string
     */
    public static function removeLTRM($str)
    {
        return preg_replace('/\xe2\x80\x8e/', '', $str);
    }

    /**
     * Remove diacritics from the specified string
     *
     * @param $str
     * 	String to look into
     * @return string
     * 	Cleaned string
     */
    public static function removeDiacritics($str)
    {
        $newChars = array();
        $chars = self::split($str);
        if (!empty($chars)) {
            foreach ($chars as $char) {
                $newChar = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $char);
                if ($newChar != $char) {
                    $newChar = preg_replace('/\p{P}|\^|\`|~/u', '', $newChar);
                }
                $newChars[] = $newChar;
            }
        }

        return implode('', $newChars);
    }

    /**
     * Transliterate a string from romaji to hiragana.
     *
     * @param $str
     *   The string to be converted.
     * @return string
     *   Converted string into hiragana.
     */
    public static function romajiToHiragana($str)
    {
        $str = self::prepareKanaTransliteration($str);
        $str = self::convertSokuon($str, self::JPNFORPHP_HIRAGANA);
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
            ' ' => '　', ',' => '、', ', ' => '、',
        );
        $output = strtr($str, $table);

        return $output;
    }

    /**
     * Transliterate a string from romaji to katakana.
     *
     * @param $str
     *   The string to be converted.
     * @return string
     *   Converted string into katakana.
     */
    public static function romajiToKatakana($str)
    {
        $str = self::prepareKanaTransliteration($str);
        $str = self::convertSokuon($str, self::JPNFORPHP_KATAKANA);
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
            'tyu' => 'テュ',
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
        $output = strtr($str, $table);

        return $output;
    }

    /**
     * Wrap all transliteration functions and perform intelligente verification 
     * to properly convert a given string into romaji.
     *
     * @param $hiragana
     *   The string to be converted.
     * @param $transliterator
     *   (Optional) Transliterator class name, set by default to Hepburn.
     * @param $syllabary
     *   (Optional) Force source syllabary.
     * @return string
     *   Converted string into romaji.
     */
    public static function toRomaji($str, $transliterator = self::JPNFORPHP_HEPBURN, $syllabary = '')
    {
        $output = $str;

        // Get a transliterator object as per the specified system.
        if (class_exists($transliterator)) {
            $transliterator = new $transliterator();
        } else {
            return $output;
        }

        // Force source syllabary
        if ($syllabary !== '') {
            if ($syllabary === self::JPNFORPHP_HIRAGANA) {
                $output = $transliterator->fromHiragana($str);
            } elseif ($syllabary === self::JPNFORPHP_KATAKANA) {
                $output = $transliterator->fromKatakana($str);
            }
        } else {
            // It first tries to transliterate word by word, if not possible
            // character by character.
            mb_regex_encoding('UTF-8');
            mb_internal_encoding("UTF-8");
            $words = mb_split("[\s　]", $str);
            foreach ($words as $i => $word) {
                $length = self::length($word);
                if ($length === self::countHiragana($word)) {
                    $words[$i] = $transliterator->fromHiragana($word);
                } elseif ($length === self::countKatakana($word)) {
                    $words[$i] = $transliterator->fromKatakana($word);
                } else {
                    $chars = self::split($word);
                    foreach ($chars as $j => $char) {
                        if (self::hasHiragana($char)) {
                            $chars[$j] = $transliterator->fromHiragana($char);
                        } elseif (self::hasKatakana($char)) {
                            $chars[$j] = $transliterator->fromKatakana($char);
                        }
                    }
                    $words[$i] = implode('', $chars);
                    $words[$i] = $transliterator->fromHiragana($words[$i]);
                    $words[$i] = $transliterator->fromKatakana($words[$i]);
                }
                $output = implode(' ', $words);
            }
        }


        return $output;
    }

    /**
     * Parse a string to identify and convert Sokuon characters 
     * (http://en.wikipedia.org/wiki/Sokuon).
     *
     * @param $str
     *   String to look into.
     * @param $syllabary
     *   Syllabary to be used ; either Hiragana or Katakana.
     * @return string
     *   Converted string.
     */
    private static function convertSokuon($str, $syllabary)
    {
        $new_str = $str;
        $length = self::length($str);

        //No need to go further.
        if ($length < 2) {
            return $new_str;
        }

        $sokuon = ($syllabary === self::JPNFORPHP_HIRAGANA) ? self::JPNFORPHP_SOKUON_HIRAGANA : self::JPNFORPHP_SOKUON_KATAKANA;
        $skip = array('a', 'i', 'u', 'e', 'o', 'n');

        for ($i = 1; $i < $length; $i++) {
            $prev_char = substr($str, $i - 1, 1);
            if (!in_array($prev_char, $skip)) {
                if ($prev_char === substr($str, $i, 1) || ($prev_char === 't' && substr($str, $i, 2) === 'ch')) {
                    $new_str = substr_replace($str, $sokuon, $i - 1, 1);
                }
            }
        }

        return $new_str;
    }

    /**
     * Prepare a string for its transliteration in kana (ie: Hiragana or 
     * Katakana).
     * 
     * @param $str
     *   String to be prepared.
     * @return string
     *   Prepared string.
     * 
     * @see romajiToHiragana()
     * @see romajiToKatakana()
     */
    private static function prepareKanaTransliteration($str)
    {
        $str = mb_strtolower($str, 'UTF-8');
        $table = array(
            'ā' => 'aa', 'ī' => 'ii', 'ū' => 'uu', 'ē' => 'ee', 'ō' => 'ou',
        );
        $prepared_s = strtr($str, $table);
        return $prepared_s;
    }

}
