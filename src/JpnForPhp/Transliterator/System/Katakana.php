<?php

/*
 * This file is part of the JpnForPhp package.
 *
 * (c) Matthieu Bilbille
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JpnForPhp\Transliterator\System;

use JpnForPhp\Helper\Helper;

/**
 * Transliteration system class to support transliteration into katakana.
 *
 * @author Matthieu Bilbille (@mbibille)
 */
class Katakana extends Kana
{
    private $longVowels = array(
      'ā' => 'aー',
      'ī' => 'iー',
      'ū' => 'uー',
      'ē' => 'eー',
      'ō' => 'oー',
      'â' => 'aー',
      'î' => 'iー',
      'û' => 'uー',
      'ê' => 'eー',
      'ô' => 'oー'
    );

    private $sokuon = 'ッ';

    /**
     * Override __toString().
     *
     * @see System
     */
    public function __toString()
    {
        return 'Katakana transliteration system (片仮名)';
    }

    /**
     * Override transliterate().
     *
     * @see System
     */
    public function transliterate($str) {

      $str = self::preTransliterate($str);

      // Workflow:
      //  1/ Prepare choonpu
      //  2/ Prepare long vowels
      //  3/ Sokuon
      //  4/ Quotation marks
      //  5/ Default characters

      $str = self::prepareChoonpuTransliteration($str);

      $str = self::prepareLongVowelsTransliteration($str, $this->longVowels);

      $str = self::transliterateSokuon($str, $this->sokuon);

      $str = self::transliterateQuotationMarks($str);

      $str = self::transliterateDefaultCharacters($str);

      $str = Helper::convertHiraganaToKatakana($str);

      return self::stripWhitespaces($str);
    }
}
