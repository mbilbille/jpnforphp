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
 * Ichidan (一段) verb group.
 * - Kami-ichidan (上一段) verbs with a stem ending in i
 * - Shimo-ichidan (下一段) verbs with a stem ending in e
 *
 * @author Matthieu Bilbille (@mbibille)
 */
class Ichidan extends AbstractVerb
{

  protected $conjugationMap = array(
      // 'xx' => array(MIZENKEI, RENYOUKEI, SHUUSHIKEI, RENTAIKEI, KATEIKEI, MEIREIKEI);
      'v1' => array('', '', '', '', '', ''),
      'v1-s' => array('', '', '', '', '', ''), // @TODO

  );

  protected $suffixMap = array(
      // verbal_form => array(PLAIN, POLITE, PLAIN_NEGATIVE, POLITE_NEGATIVE)
      Inflector::NON_PAST_FORM => array('る', 'ます', 'ない', 'ません'),
      Inflector::PAST_FORM => array('た', 'ました', 'なかった', 'ませんでした'),
      Inflector::TE_FORM => array('て', 'まして', null, null),
      Inflector::PASSIVE_FORM => array('られる', 'られます', 'られない', 'られません'),
      Inflector::CAUSATIVE_FORM => array('させる', 'させます', 'させない', 'させません'),
      Inflector::CAUSATIVE_ALT_FORM => array('さす', null, null, null),
      Inflector::CAUSATIVE_PASSIVE_FORM => array('させられる', 'させられます', 'させられない', 'させられません'),
      Inflector::POTENTIAL_FORM => array('られる', 'られます', 'られない', 'られません'),
      Inflector::PROVISIONAL_CONDITIONAL_FORM => array('れば', null, 'なければ', null),
      Inflector::CONDITIONAL_FORM => array('たら', 'ましたら', 'なかったら', 'ませんでしたら'),
      Inflector::IMPERATIVE_FORM => array('ろ', 'てください', 'ませ', 'ないでください'),
      Inflector::COMMAND_FORM => array('なさい', null, 'るな', null),
      Inflector::VOLITIONAL_FORM => array('よう', 'ましょう', null, null),
      Inflector::GERUND_FORM => array('ながら', null, null, null),
      Inflector::OPTATIVE_FORM => array('たい', null, 'たくない', null)
  );

  function __construct(Entry $entry) {
    parent::__construct($entry);
  }
}
