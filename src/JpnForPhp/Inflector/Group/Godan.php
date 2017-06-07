<?php

/*
 * This file is part of the JpnForPhp package.
 *
 * (c) Matthieu Bilbille
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JpnForPhp\Inflector\Group;

use JpnForPhp\Inflector\Inflector;

/**
* TODO.
*
* @author Matthieu Bilbille (@mbibille)
*/
class Godan extends AbstractGroup
{
  protected $conjugationMap = array(
      // 'xx' => array(MIZENKEI, RENYOUKEI, SHUUSHIKEI, RENTAIKEI, KATEIKEI, MEIREIKEI);
      'v5k' => array('か|こ', 'き|い', 'く', 'く', 'け', 'け'),
      'v5m' => array('ま|も', 'み|ん', 'む', 'む', 'め', 'め'),
      // @TODO
  );

  protected $overriddenRules = array(
      // verbal_form => array(PLAIN, POLITE, PLAIN_NEGATIVE, POLITE_NEGATIVE)
      Inflector::PAST_FORM => array(true, false, false, false),
      Inflector::TE_FORM => array(true, false, false, false),
      Inflector::CONDITIONAL_FORM => array(true, false, false, false),
      Inflector::IMPERATIVE_FORM => array(false, true, false, false),
      Inflector::VOLITIONAL_FORM => array(true, false, false, false),
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
      Inflector::IMPERATIVE_FORM => array('', 'でください', 'ませ', 'ないでください'),
      Inflector::COMMAND_FORM => array('なさい', null, 'な', null),
      Inflector::VOLITIONAL_FORM => array('う', 'ましょう', null, null),
      Inflector::GERUND_FORM => array('ながら', null, null, null),
      Inflector::OPTATIVE_FORM => array('たい', null, 'たくない', null)
  );
}
