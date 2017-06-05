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
  protected $keiMapping = array(
      // 'xx' => array(MIZENKEI, RENYOUKEI, SHUUSHIKEI, RENTAIKEI, KATEIKEI, MEIREIKEI, MIZENKEI_ALT, RENYOUKEI_ALT);
      'v5k' => array('か', 'き', 'く', 'く', 'け', 'け', 'こ', 'い'),
      'v5m' => array('ま', 'み', 'む', 'む', 'め', 'め', 'も', 'ん'),
      // @TODO
  );

  protected $keiPerForm = array(
      PAST_FORM => array(Inflector::RENYOUKEI_ALT, null, null, null),
      TE_FORM => array(Inflector::RENYOUKEI_ALT, null, null, null),
      CONDITIONAL_FORM => array(Inflector::RENYOUKEI_ALT, null, null, null),
      VOLITIONAL_FORM => array(Inflector::MIZENKEI_ALT, null, null, null),
  );

  protected $suffixPerForm = array(
      NON_PAST_FORM => array('', 'ます', 'ない', 'ません'),
      PAST_FORM => array('た', 'ました', 'なかった', 'ませんでした'),
      TE_FORM => array('て', 'まして', null, null),
      PASSIVE_FORM => array('れる', 'れます', 'れない', 'れません'),
      CAUSATIVE_FORM => array('せる', 'せます', 'せない', 'せません'),
      CAUSATIVE_ALT_FORM => array('す', null, null, null),
      CAUSATIVE_PASSIVE_FORM => array('せられる', 'せられます', 'せられない', 'せられません'),
      POTENTIAL_FORM => array('る', 'ます', 'ない', 'ません'),
      PROVISIONAL_CONDITIONAL_FORM => array('ば', null, 'なければ', null),
      CONDITIONAL_FORM => array('たら', 'ましたら', 'なかったら', 'ませんでしたら'),
      IMPERATIVE_FORM => array('', 'でください', 'ませ', 'ないでください'),
      COMMAND_FORM => array('な', 'なさい', null, null),
      VOLITIONAL_FORM => array('う', 'ましょう', null, null),
      GERUND_FORM => array('ながら', null, null, null),
      OPTATIVE_FORM => array('たい', null, 'たくない', null)
  );
}
