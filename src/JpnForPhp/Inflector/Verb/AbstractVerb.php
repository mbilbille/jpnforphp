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
use Exception;

/**
  * Abstract implementation of Verb interface which provide common methods for
  * each verb group (日本語動詞の活用の種類).
  *
  * @author Matthieu Bilbille (@mbibille)
  */
abstract class AbstractVerb implements Verb
{
    protected $type;

    protected $stem = array(
      Inflector::KANJI_FORM => '',
      Inflector::KANA_FORM => ''
    );

    protected $conjugationMap = array();

    protected $alternativeConjugationRules = array();

    protected $inflectionRules = array();

    protected $suffixMap = array();

    function __construct(Entry $entry)
    {
        $this->type = $entry->getType();
        $this->stem[Inflector::KANJI_FORM] = Helper::subString($entry->getKanji(), 0, Analyzer::length($entry->getKanji()) - 1);
        $this->stem[Inflector::KANA_FORM] = Helper::subString($entry->getKana(), 0, Analyzer::length($entry->getKana()) - 1);
        // Support verbs without kanji (such as irassharu)
        if($this->stem[Inflector::KANJI_FORM] === '') {
          $this->stem[Inflector::KANJI_FORM] = $this->stem[Inflector::KANA_FORM];
        }
    }

    /**
     * Getter method for `type`
     */
    public function getType() {
      return $this->type;
    }

    /**
     * Basic `getStem` implementation which returns the kanji form otherwise the
     * kana form, no matter which verbal and language forms have been given.
     */
    public function getStem($transliterationForm, $verbalForm, $languageForm)
    {
      return ($transliterationForm === Inflector::KANJI_FORM) ? $this->stem[Inflector::KANJI_FORM] : $this->stem[Inflector::KANA_FORM];
    }

    /**
     * Get a conjugation for a given conjugated, verbal and language forms.
     * Note: `$transliterationForm` argument is not used here but it might be
     * useful for overriding methods.
     */
    public function getConjugation($transliterationForm, $conjugatedForm, $verbalForm, $languageForm)
    {
        if(!array_key_exists($this->type, $this->conjugationMap) ||
        !array_key_exists($conjugatedForm, $this->conjugationMap[$this->type])) {
            throw new Exception('Failed to conjugate ' . $entry->getKanji() . ' (' . $this->type . ')');
        }
        $conjugation = $this->conjugationMap[$this->type][$conjugatedForm];

        if(strpos($conjugation, '|') === false) {
            return $conjugation;
        }

        $conjugations = explode('|', $conjugation);

        return (
          !array_key_exists($verbalForm, $this->alternativeConjugationRules) ||
          !array_key_exists($languageForm, $this->alternativeConjugationRules[$verbalForm]) ||
          $this->alternativeConjugationRules[$verbalForm][$languageForm] === false
        ) ? $conjugations[0] : $conjugations[1];
   }

   /**
    * Get inflection suffix for a given verbal and language forms.
    */
   public function getSuffix($verbalForm, $languageForm)
   {
     return isset($this->suffixMap[$verbalForm]) && isset($this->suffixMap[$verbalForm][$languageForm]) ?
      $this->suffixMap[$verbalForm][$languageForm] : null;
   }
}
