<?php

/*
 * This file is part of the JpnForPhp package.
 *
 * (c) Matthieu Bilbille
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JpnForPhp\Inflector\Verb;

use JpnForPhp\Helper\Helper;
use JpnForPhp\Analyzer\Analyzer;
use JpnForPhp\Inflector\Inflector;
use JpnForPhp\Inflector\Entry;

/**
 * Godan (五段) verb group.
 * Verbs with a stem ending in a consonant
 *
 * @author Matthieu Bilbille (@mbibille)
 */
class Godan extends AbstractVerb
{

  protected $conjugationMap = array(
      // 'xx' => array(MIZENKEI, RENYOUKEI, SHUUSHIKEI, RENTAIKEI, KATEIKEI, MEIREIKEI);
      'v5k' => array('か|こ', 'き|い', 'く', 'く', 'け', 'け'),
      'v5k-s' => array('か|こ', 'き|っ', 'く', 'く', 'け', 'け'),
      'v5g' => array('が|ご', 'ぎ|い', 'ぐ', 'ぐ', 'げ', 'げ'),
      'v5s' => array('さ|そ', 'し|し', 'す', 'す', 'せ', 'せ'),
      'v5t' => array('た|と', 'ち|っ', 'つ', 'つ', 'て', 'て'),
      'v5n' => array('な|の', 'に|ん', 'ぬ', 'ぬ', 'ね', 'ね'),
      'v5b' => array('ば|ぼ', 'び|ん', 'ぶ', 'ぶ', 'べ', 'べ'),
      'v5m' => array('ま|も', 'み|ん', 'む', 'む', 'め', 'め'),
      'v5r' => array('ら|ろ', 'り|っ', 'る', 'る', 'れ', 'れ'),
      'v5aru' => array('ら|ろ', 'り|っ', 'る', 'る', 'れ', 'れ'),
      'v5r-i' => array('ら|ろ', 'り|っ', 'る', 'る', 'れ', 'れ'),
      'v5u' => array('わ|お', 'い|っ', 'う', 'う', 'え', 'え'),
      'v5u-s' => array('わ|お', 'い|う', 'う', 'う', 'え', 'え'),
  );

  protected $alternativeConjugationRules = array(
      // verbal_form => array(PLAIN, POLITE, PLAIN_NEGATIVE, POLITE_NEGATIVE)
      Inflector::PAST_FORM => array(true, false, false, false),
      Inflector::TE_FORM => array(true, false, false, false),
      Inflector::CONDITIONAL_FORM => array(true, false, false, false),
      Inflector::IMPERATIVE_FORM => array(false, true, false, false),
      Inflector::VOLITIONAL_FORM => array(true, false, false, false)
  );

  protected $suffixMap = array(
      // verbal_form => array(PLAIN, POLITE, PLAIN_NEGATIVE, POLITE_NEGATIVE)
      Inflector::NON_PAST_FORM => array('', 'ます', 'ない', 'ません'),
      Inflector::PAST_FORM => array('た', 'ました', 'なかった', 'ませんでした'),
      Inflector::TE_FORM => array('て', 'まして', null, null),
      Inflector::PASSIVE_FORM => array('れる', 'れます', 'れない', 'れません'),
      Inflector::CAUSATIVE_FORM => array('せる', 'せます', 'せない', 'せません'),
      Inflector::CAUSATIVE_ALT_FORM => array('す', null, null, null),
      Inflector::CAUSATIVE_PASSIVE_FORM => array('せられる', 'せられます', 'せられない', 'せられません'),
      Inflector::POTENTIAL_FORM => array('る', 'ます', 'ない', 'ません'),
      Inflector::PROVISIONAL_CONDITIONAL_FORM => array('ば', null, 'なければ', null),
      Inflector::CONDITIONAL_FORM => array('たら', 'ましたら', 'なかったら', 'ませんでしたら'),
      Inflector::IMPERATIVE_FORM => array('', 'てください', 'ませ', 'ないでください'),
      Inflector::COMMAND_FORM => array('なさい', null, 'な', null),
      Inflector::VOLITIONAL_FORM => array('う', 'ましょう', null, null),
      Inflector::GERUND_FORM => array('ながら', null, null, null),
      Inflector::OPTATIVE_FORM => array('たい', null, 'たくない', null)
  );

  function __construct(Entry $entry) {
    parent::__construct($entry);

    // Override default Godan default suffix map
    if(in_array($this->type, array('v5g', 'v5b'), true)) {
      $this->suffixMap[Inflector::PAST_FORM][Inflector::PLAIN_FORM] = 'だ';
      $this->suffixMap[Inflector::TE_FORM][Inflector::PLAIN_FORM] = 'で';
      $this->suffixMap[Inflector::CONDITIONAL_FORM][Inflector::PLAIN_FORM] = 'だら';
      $this->suffixMap[Inflector::IMPERATIVE_FORM][Inflector::POLITE_FORM] = 'でください';
    }
  }

  // Override `getStem`
  public function getStem($transliterationForm, $verbalForm, $languageForm)
  {
    $stem = parent::getStem($transliterationForm, $verbalForm, $languageForm);

    if($this->isIrregularForm_v5ri($verbalForm, $languageForm)) {
      $stem = Helper::subString($stem, 0, Analyzer::length($stem) - 1);
    }
    return $stem;
  }

  // Override `getConjugation`
  public function getConjugation($transliterationForm, $conjugatedForm, $verbalForm, $languageForm)
  {
    $conjugation = parent::getConjugation($transliterationForm, $conjugatedForm, $verbalForm, $languageForm);

    if($this->isIrregularForm_v5ri($verbalForm, $languageForm)) {
      $conjugation = Helper::subString($conjugation, 1, null);
    }
    else if($this->isIrregularForm_v5us($verbalForm, $languageForm)) {
      $conjugation = Helper::subString($conjugation, 1, null);
    }

    return $conjugation;
  }

  /**
   * Detect v5r-i irregular form(s)
   * ある・在る・有る has an irregular negative ( ～ない ) form: ない
   */
  private function isIrregularForm_v5ri($verbalForm, $languageForm) {
    if($this->type !== 'v5r-i') {
      return false;
    }

    if(in_array($verbalForm, array(Inflector::NON_PAST_FORM, Inflector::PAST_FORM,
      Inflector::PROVISIONAL_CONDITIONAL_FORM, Inflector::CONDITIONAL_FORM), true)
      && $languageForm === Inflector::PLAIN_NEGATIVE_FORM) {
        return true;
    }

    if(in_array($verbalForm, array(Inflector::IMPERATIVE_FORM), true)
      && $languageForm === Inflector::POLITE_NEGATIVE_FORM) {
        return true;
    }

    return false;
  }

  /**
   * Detect v5u-s irregular form(s)
   * Irregular て / た form
   *  “to ask” とう・問う とうて and とうた
   *  “to request” こう・請う・乞う こうて and こうた
   */
  private function isIrregularForm_v5us($verbalForm, $languageForm) {
    return false; // @TODO
  }
}
