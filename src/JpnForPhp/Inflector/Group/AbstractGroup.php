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

    protected $inflectionRules = array();

    protected $suffixMap = array();

    function __construct(Verb $verb)
    {
        $this->verb = $verb;
    }

    public function getKanjiStem()
    {
      return Helper::subString($this->verb->getKanji(), 0, Analyzer::length($this->verb->getKanji()) - 1);
    }

    public function getKanaStem()
    {
        return Helper::subString($this->verb->getKana(), 0, Analyzer::length($this->verb->getKana()) - 1);
    }

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

        return (!array_key_exists($verbalForm, $this->overriddenRules) ||
          !array_key_exists($languageForm, $this->overriddenRules[$verbalForm]) ||
          $this->overriddenRules[$verbalForm][$languageForm] === false) ?
          $conjugations[0] : $conjugations[1];
   }

   public function getSuffix($verbalForm, $languageForm)
   {
     return isset($this->suffixMap[$verbalForm]) && isset($this->suffixMap[$verbalForm][$languageForm]) ?
      $this->suffixMap[$verbalForm][$languageForm] : null;
   }
}
