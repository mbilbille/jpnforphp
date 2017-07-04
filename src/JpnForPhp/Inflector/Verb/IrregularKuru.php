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
 * Irregular conjugation of the verb "kuru" (カ行変格活用).
 *
 * @author Matthieu Bilbille (@mbibille)
 */
class IrregularKuru extends AbstractVerb
{

  protected $conjugationMap = array(
      // 'xx' => array(MIZENKEI, RENYOUKEI, SHUUSHIKEI, RENTAIKEI, KATEIKEI, MEIREIKEI);
      'vk' => array('こ', 'き', 'くる', 'くる', 'くれ|こ', 'こい')
  );

  protected $alternativeConjugationRules = array(
      // verbal_form => array(PLAIN, POLITE, PLAIN_NEGATIVE, POLITE_NEGATIVE)
      Inflector::POTENTIAL_FORM => array(true, true, true, true)
  );

  protected $suffixMap = array(
      // verbal_form => array(PLAIN, POLITE, PLAIN_NEGATIVE, POLITE_NEGATIVE)
      Inflector::NON_PAST_FORM => array('', 'ます', 'ない', 'ません'),
      Inflector::PAST_FORM => array('た', 'ました', 'なかった', 'ませんでした'),
      Inflector::TE_FORM => array('て', 'まして', null, null),
      Inflector::PASSIVE_FORM => array('られる', 'られます', 'られない', 'られません'),
      Inflector::CAUSATIVE_FORM => array('させる', 'させます', 'させない', 'させません'),
      Inflector::CAUSATIVE_ALT_FORM => array('さす', null, null, null),
      Inflector::CAUSATIVE_PASSIVE_FORM => array('させられる', 'させられます', 'させられない', 'させられません'),
      Inflector::POTENTIAL_FORM => array('られる', 'られます', 'られない', 'られません'),
      Inflector::PROVISIONAL_CONDITIONAL_FORM => array('ば', null, 'なければ', null),
      Inflector::CONDITIONAL_FORM => array('たら', 'ましたら', 'なかったら', 'ませんでしたら'),
      Inflector::IMPERATIVE_FORM => array('', 'てください', 'ませ', 'ないでください'),
      Inflector::COMMAND_FORM => array('なさい', null, 'な', null),
      Inflector::VOLITIONAL_FORM => array('よう', 'ましょう', null, null),
      Inflector::GERUND_FORM => array('ながら', null, null, null),
      Inflector::OPTATIVE_FORM => array('たい', null, 'たくない', null)
  );


  function __construct(Entry $entry) {
    parent::__construct($entry);

    // Override stems when it is part of the conjugation string
    $this->stem[Inflector::KANJI_FORM] = (Helper::subString($this->stem[Inflector::KANJI_FORM], -1, 1) === '来') ? $this->stem[Inflector::KANJI_FORM] : Helper::subString($entry->getKanji(), 0, Analyzer::length($entry->getKanji()) - 2);
    $this->stem[Inflector::KANA_FORM] = Helper::subString($entry->getKana(), 0, Analyzer::length($entry->getKana()) - 2);
  }
}
