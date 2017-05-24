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

/**
 * Transliteration system class to support transliteration into hiragana.
 *
 * @author Matthieu Bilbille (@mbibille)
 */
class Hiragana extends Kana
{
    private $longVowels = array(
      'ā' => 'aa',
      'ī' => 'ii',
      'ū' => 'uu',
      'ē' => 'ee',
      'ō' => 'ou',
      'â' => 'aa',
      'î' => 'ii',
      'û' => 'uu',
      'ê' => 'ee',
      'ô' => 'ou'
    );

    private $sokuon = 'っ';

    /**
     * Override __toString().
     *
     * @see System
     */
    public function __toString()
    {
        return 'Hiragana transliteration system (平仮名)';
    }

    /**
     * Override transliterate().
     *
     * @see System
     */
    public function transliterate($str) {

      $str = self::preTransliterate($str);

      // Workflow:
      //  1/ Prepare long vowels
      //  2/ Sokuon
      //  3/ Quotation marks
      //  4/ Default characters

      $str = self::prepareLongVowelsTransliteration($str, $this->longVowels);

      $str = self::transliterateSokuon($str, $this->sokuon);

      $str = self::transliterateQuotationMarks($str);

      $str = self::transliterateDefaultCharacters($str);

      return self::stripWhitespaces($str);
    }
}
