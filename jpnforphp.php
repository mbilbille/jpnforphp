<?php

/**
 * JpnForPhp library, brings some usefull tools and functionalities
 * to interact with Japanese characters.
 *
 * @author      Matthieu Bilbille
 * @link	https://github.com/mbilbille/jpnforphp
 * @version	0.0.1
 */

/**
 * Looks for kanji within a given string.
 * 
 * @param $str
 *  The string to process.
 * @return
 *  TRUE if it contains at least one kanji, otherwise FALSE.
 */
function has_kanji($str) {
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
function has_hiragana($str) {
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
function has_katakana($str) {
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
function is_japanese($str) {
    return has_kanji($str) || has_hiragana($str) || has_katakana($str);
}
