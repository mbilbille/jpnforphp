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

use JpnForPhp\Helper\Helper;
use JpnForPhp\Analyzer\Analyzer;
use JpnForPhp\Inflector\Inflector;
use JpnForPhp\Inflector\Verb;
use Exception;

/**
  * TODO.
  *
  * @author Matthieu Bilbille (@mbibille)
  */
abstract class AbstractGroup implements Group
{
    protected $verb;

    protected $conjugationMap = array();

    protected $alternativeConjugationRules = array();

    protected $inflectionRules = array();

    protected $kanjiStem;

    protected $kanaStem;

    protected $suffixMap = array();

    function __construct(Verb $verb)
    {
        $this->verb = $verb;
        $this->kanjiStem = Helper::subString($this->verb->getKanji(), 0, Analyzer::length($this->verb->getKanji()) - 1);
        $this->kanaStem = Helper::subString($this->verb->getKana(), 0, Analyzer::length($this->verb->getKana()) - 1);
        if($this->kanjiStem === '') { // Support verbs without kanji (such as irassharu)
          $this->kanjiStem = $this->kanaStem;
        }
    }

    /**
     * Basic `getStem` implementation which returns the kanji form otherwise the
     * kana form, no matter which verbal and language forms have been given.
     */
    public function getStem($transliterationForm, $verbalForm, $languageForm)
    {
      return ($transliterationForm === Inflector::KANJI_FORM) ? $this->kanjiStem : $this->kanaStem;
    }

    /**
     * Get a conjugation for a given conjugated, verbal and language forms.
     */
    public function getConjugation($conjugatedForm, $verbalForm, $languageForm)
    {
        if(!array_key_exists($this->verb->getType(), $this->conjugationMap) ||
        !array_key_exists($conjugatedForm, $this->conjugationMap[$this->verb->getType()])) {
            throw new Exception('Failed to conjugate ' . $this->verb->getKanji() . ' (' . $this->verb->getType() . ')');
        }
        $conjugation = $this->conjugationMap[$this->verb->getType()][$conjugatedForm];

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
