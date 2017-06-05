<?php

/*
 * This file is part of the JpnForPhp package.
 *
 * (c) Matthieu Bilbille
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JpnForPhp\Inflector;

use Exception;


class Inflector
{
  const NON_PAST_FORM = "Non past";
  const PAST_FORM = "Past";
  const TE_FORM = "Te form";
  const POTENTIAL_FORM = "Potential";
  const PASSIVE_FORM = "Passive";
  const CAUSATIVE_FORM = "Causative";
  const CAUSATIVE_PASSIVE_FORM = "Causative passive";
  const PROVISIONAL_CONDITIONAL_FORM = "Provisional conditional";
  const CONDITIONAL_FORM = "Conditional";
  const IMPERATIVE_FORM = "Imperative";
  const COMMAND_FORM = "Command";
  const VOLITIONAL_FORM = "Volitional";
  const GERUND_FORM = "Gerund";
  const OPTATIVE_FORM = "Optative";

  const MIZENKEI = 0;
  const RENYOUKEI = 1;
  const SHUUSHIKEI = 2;
  const RENTAIKEI = 3;
  const KATEIKEI= 4;
  const MEIREIKEI = 5;
  const MIZENKEI_ALT = 6;
  const RENYOUKEI_ALT = 7;

  private static $keiPerForm = array(
    NON_PAST_FORM => array(self::RENTAIKEI, self::RENYOUKEI, self::MIZENKEI, self::RENYOUKEI),
    PAST_FORM => array(self::RENYOUKEI, self::RENYOUKEI, self::RENYOUKEI, self::RENYOUKEI),
    TE_FORM => array(self::RENYOUKEI, self::RENYOUKEI, null, null),
    PASSIVE_FORM => array(self::MIZENKEI, self::MIZENKEI, self::MIZENKEI, self::MIZENKEI),
    CAUSATIVE_FORM => array(self::MIZENKEI, self::MIZENKEI, self::MIZENKEI, self::MIZENKEI),
    CAUSATIVE_ALT_FORM => array(self::MIZENKEI, null, null, null),
    CAUSATIVE_PASSIVE_FORM => array(self::MIZENKEI, self::MIZENKEI, self::MIZENKEI, self::MIZENKEI),
    POTENTIAL_FORM => array(self::KATEIKEI, self::KATEIKEI, self::KATEIKEI, self::KATEIKEI),
    PROVISIONAL_CONDITIONAL_FORM => array(self::KATEIKEI, null, self::MIZENKEI, null),
    CONDITIONAL_FORM => array(self::RENYOUKEI, self::RENYOUKEI, self::MIZENKEI, self::RENYOUKEI),
    IMPERATIVE_FORM => array(self::MEIREIKEI, self::RENYOUKEI, self::RENYOUKEI, self::MIZENKEI),
    COMMAND_FORM => array(self::RENTAIKEI, self::RENYOUKEI, null, null),
    VOLITIONAL_FORM => array(self::MIZENKEI, self::RENYOUKEI, null, null),
    GERUND_FORM => array(self::RENYOUKEI, null, null, null),
    OPTATIVE_FORM => array(self::RENYOUKEI, null, self::RENYOUKEI, null)
  );


  /**
   * Inflects the verb to given forms or all if none input
   *
   * @param Verb $verb
   * @param array $forms
   * @return array
   */
  public static function inflect(Verb $verb, $forms = array())
  {
    $result = array();

    if (!$verb) {
      return $result;
    }

    // Get group using verb type
    switch ($verb->getType()) {
      case 'v1':
        $group = new Group\Ichidan();
        break;
      case 'v5aru':
      case 'v5b':
      case 'v5g':
      case 'v5k':
      case 'v5k':
      case 'v5m':
      case 'v5n':
      case 'v5r':
      case 'v5r':
      case 'v5s':
      case 'v5t':
      case 'v5u':
      case 'v5u':
      case 'v5uru':
        $group = new Group\Godan();
        break;
      case 'vk':
      case 'vs-i':
      case 'vs-s':
      case 'vz':
        // @TODO
      default:
        throw new Exception("Unknown verb type : " . $verb->getType());
    }

    // 1/ Get stem
    $stem = $group->getKanjiStem($verb);

    // @TODO
    $forms = array_keys(Inflector::$keiPerForm);

    foreach ($forms as $form) {

        // 2/ Which kei to use? use override otherwise default
        $kei = Inflector::$keiPerForm[$form][0];
        if($group->getKei($form)[0] != null) {
          $kei = $group->getKei($form)[0];
        }

        // 3/ Get kei
        $k = $group->getKeiMapping($verb, $kei);

        // 4/ Get suffix
        $suffix = $group->getSuffix($form)[0];

        // 5/ if kei ends by "n" change suffix "t" -> "d"
        if($k === 'ん') {
          $suffix = strtr($suffix, array('た' => 'だ', 'て' => 'で'));
        }

        // 6/ Contact stem + kei + suffix
        $result[$form] = $stem . $k . $suffix;
    }

    return $result;
  }
}
