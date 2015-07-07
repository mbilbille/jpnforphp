<?php

/*
 * This file is part of the JpnForPhp package.
 *
 * (c) Matthieu Bilbille
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JpnForPhp\Converter;

/**
 * Provides useful methods for Japanese units conversion.
 *
 * @author Matthieu Bilbille
 */
class Converter
{

    /**
     * Converts a number in Arabic/Western format into Japanese numeral.
     *
     * @param integer $number The input number.
     *
     * @return string The Japanese numeral.
     */
    public static function toJapaneseNumeral($number) 
    {
        // Mapping between digits and kanjis
        $mapDigits = array(
            0 => '〇',
            1 => '一',
            2 => '二',
            3 => '三',
            4 => '四',
            5 => '五',
            6 => '六',
            7 => '七',
            8 => '八',
            9 => '九'
        );
        
        // Mapping powers of ten and kanjis
        $mapPowersOfTen = array(
            1 => '十',
            2 => '百',
            3 => '千',
            4 => '万',
            8 => '億',
            12 => '兆',
            16 => '京'
        );
        
        // Before doing need ensure that an integer value has been given
        if(!preg_match('/^[1-9]?[0-9]*$/', $number)) {
            throw new Exception('Wrong input value');
        }
        // ... and force type to integer
        $number = intval($number);
        
        // Easy with digits...
        if($number < 10) {
            return $mapDigits[$number];
        }
        
        // Split number by group of 4 digits (!! starting from the end)
        $chunks = self::rstr_split($number, 4);
        
        $res = '';
        for ($i = count($chunks) - 1; $i >= 0; $i--) {
            $chunk = '';
            for ($j = 1; $j <= strlen($chunks[$i]); $j++) {
                
                $d = substr($chunks[$i], $j * -1, 1);

                // 0 (ie: zero) is not use for number superior to 0.
                if(!$d) {
                    continue;
                }
                
                $d = intval($d);
                if($d > 1) {
                    $chunk = $mapDigits[$d] . (isset($mapPowersOfTen[$j - 1]) ? $mapPowersOfTen[$j - 1] : '') . $chunk;
                }
                else { // ie: $d == 1
                    $chunk = (isset($mapPowersOfTen[$j - 1]) ? $mapPowersOfTen[$j - 1] : '') . $chunk;
                }
            }
            $res .= $chunk . (isset($mapPowersOfTen[$i * 4]) ? $mapPowersOfTen[$i * 4] : '');
        }

        return $res;
    }
    
    /**
     * Reverse version of str_split.
     * @see str_split()
     */
    private static function rstr_split($string, $split_length) {
        $splits = array();
        $tmp = '';
        for ($i = 1; $i <= strlen($string); $i++) {
            $tmp = substr($string, $i * -1, 1) . $tmp;
            if(strlen($tmp) === $split_length || $i === strlen($string)) {
                $splits[] = $tmp;
                $tmp = '';
            }
        }
        
        return $splits;
    }
}
