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

use JpnForPhp\Helper\Helper;
use JpnForPhp\Transliterator\Transliterator;
use JpnForPhp\Transliterator\System;
use Exception;

/**
 * Provides support for inflecting Japanese verbs.
 *
 * @author Matthieu Bilbille (@mbilbille) and Axel Bodart (@akeru) based on work by Fabien SK (@fabiensk)
 */
class Inflector
{
    // Verbal forms
    const NON_PAST_FORM = 'non_past';
    const PAST_FORM = 'past';
    const TE_FORM = 'te_form';
    const POTENTIAL_FORM = 'potential';
    const PASSIVE_FORM = 'passive';
    const CAUSATIVE_FORM = 'causative';
    const CAUSATIVE_ALT_FORM = 'causative_alternative';
    const CAUSATIVE_PASSIVE_FORM = 'causative_passive';
    const PROVISIONAL_CONDITIONAL_FORM = 'provisional_conditional';
    const CONDITIONAL_FORM = 'conditional';
    const IMPERATIVE_FORM = 'imperative';
    const COMMAND_FORM = 'command';
    const VOLITIONAL_FORM = 'volitional';
    const GERUND_FORM = 'gerund';
    const OPTATIVE_FORM = 'optative';

    // Conjugated forms (活用形)
    const MIZENKEI = 0; // 未然形
    const RENYOUKEI = 1; // 連用形
    const SHUUSHIKEI = 2; // 終止形
    const RENTAIKEI = 3; // 連体形
    const KATEIKEI= 4; // 仮定形
    const MEIREIKEI = 5; // 命令形

    // Language forms
    // ⚠ $inflectionRules and inflect() arrays use below constants as array keys
    const PLAIN_FORM = 0; // くだけた
    const POLITE_FORM = 1; // 丁寧語
    const PLAIN_NEGATIVE_FORM = 2;
    const POLITE_NEGATIVE_FORM = 3;

    // Transliteration forms
    const KANJI_FORM = 'kanji';
    const KANA_FORM = 'kana';
    const ROMAJI_FORM = 'romaji';

    // Rules which describe for a given `verbal form` which `conjugated form` to
    // apply to inflect a verb in a given `language form`.
    // => verbal_form => array(plain, polite, plain negative, polite negative)
    private static $inflectionRules = array(
        self::NON_PAST_FORM => array(self::RENTAIKEI, self::RENYOUKEI, self::MIZENKEI, self::RENYOUKEI),
        self::PAST_FORM => array(self::RENYOUKEI, self::RENYOUKEI, self::MIZENKEI, self::RENYOUKEI),
        self::TE_FORM => array(self::RENYOUKEI, self::RENYOUKEI, null, null),
        self::PASSIVE_FORM => array(self::MIZENKEI, self::MIZENKEI, self::MIZENKEI, self::MIZENKEI),
        self::CAUSATIVE_FORM => array(self::MIZENKEI, self::MIZENKEI, self::MIZENKEI, self::MIZENKEI),
        self::CAUSATIVE_ALT_FORM => array(self::MIZENKEI, null, null, null),
        self::CAUSATIVE_PASSIVE_FORM => array(self::MIZENKEI, self::MIZENKEI, self::MIZENKEI, self::MIZENKEI),
        self::POTENTIAL_FORM => array(self::KATEIKEI, self::KATEIKEI, self::KATEIKEI, self::KATEIKEI),
        self::PROVISIONAL_CONDITIONAL_FORM => array(self::KATEIKEI, null, self::MIZENKEI, null),
        self::CONDITIONAL_FORM => array(self::RENYOUKEI, self::RENYOUKEI, self::MIZENKEI, self::RENYOUKEI),
        self::IMPERATIVE_FORM => array(self::MEIREIKEI, self::RENYOUKEI, self::RENYOUKEI, self::MIZENKEI),
        self::COMMAND_FORM => array(self::RENYOUKEI, null, self::RENTAIKEI, null),
        self::VOLITIONAL_FORM => array(self::MIZENKEI, self::RENYOUKEI, null, null),
        self::GERUND_FORM => array(self::RENYOUKEI, null, null, null),
        self::OPTATIVE_FORM => array(self::RENYOUKEI, null, self::RENYOUKEI, null)
    );


    /**
     * Inflects a verb to given forms or all supported verbal forms if none
     * provided.
     *
     * Return an array formatted as below:
     *  array(
     *    verbal_form_1 => (plain_form, polite_form, plain_negative_form, polite_negative_form),
     *    ...
     *    verbal_form_n => (plain_form, polite_form, plain_negative_form, polite_negative_form)
     *  )
     *
     * @param Verb $verb
     * @param array $verbalForms
     * @return array
     */
    public static function inflect(Entry $entry, $verbalForms = array())
    {
        $result = array();

        if (!$entry) {
            return $result;
        }

        // Get a Transliterator component instance to return the romaji form.
        $transliterator = (new Transliterator())->setSystem(new System\HepburnTraditional());

        // Get all verbal forms if none provided
        if(!$verbalForms) {
            $verbalForms = array_keys(Inflector::$inflectionRules);
        }

        // Get a `Verb` instance using the verb type
        switch ($entry->getType()) {
            case 'v1':
                $group = new Verb\Ichidan($entry);
                break;
            case 'v5k':
            case 'v5k-s':
            case 'v5g':
            case 'v5s':
            case 'v5t':
            case 'v5n':
            case 'v5b':
            case 'v5m':
            case 'v5r':
            case 'v5aru':
            case 'v5r-i':
            case 'v5u':
            case 'v5u-s':
                $group = new Verb\Godan($entry);
                break;
            case 'vk':
                $group = new Verb\IrregularKuru($entry);
                break;
            case 'vs-i':
            case 'vs-s':
                $group = new Verb\IrregularSuru($entry);
                break;
            case 'vz':
                $group = new Verb\IrregularZuru($entry);
                break;
            default:
                throw new Exception('Unknown verb type : ' . $entry->getType());
      }

      // Inflection algorithm:
      // 1/ Which conjugated form to use?
      // 2/ Get stem
      // 3/ Get conjugation
      // 4/ Get suffix
      // 5/ If the conjugation ends by 'n' change suffix 't' -> 'd'
      // 6/ Concat stem + conjugated form + suffix
      foreach ($verbalForms as $verbalForm) {
          $result[$verbalForm] = array();

          $rule = Inflector::$inflectionRules[$verbalForm];
          foreach ($rule as $languageForm => $conjugatedForm) {

              if($conjugatedForm === null) {
                  $result[$verbalForm][$languageForm] = null;
                  continue;
              }

              $stemKanji = $group->getStem(self::KANJI_FORM, $verbalForm, $languageForm);
              $stemKana = $group->getStem(self::KANA_FORM, $verbalForm, $languageForm);

              $conjugationKanji = $group->getConjugation(self::KANJI_FORM, $conjugatedForm, $verbalForm, $languageForm);
              $conjugationKana = $group->getConjugation(self::KANA_FORM, $conjugatedForm, $verbalForm, $languageForm);

              $suffix = $group->getSuffix($verbalForm, $languageForm);

              if(Helper::subString($conjugationKanji, -1, 1) === 'ん') { // No need to test both transliteration forms.
                  $suffix = strtr($suffix, array('た' => 'だ', 'て' => 'で'));
                  // @TODO need to support more cases?
              }

              $result[$verbalForm][$languageForm] = array(
                  self::KANJI_FORM =>  $stemKanji . $conjugationKanji . $suffix,
                  self::KANA_FORM => $stemKana . $conjugationKana . $suffix);
              $result[$verbalForm][$languageForm][self::ROMAJI_FORM] = $transliterator->transliterate($result[$verbalForm][$languageForm][self::KANA_FORM]);
          }
      }
      return $result;
    }
}
