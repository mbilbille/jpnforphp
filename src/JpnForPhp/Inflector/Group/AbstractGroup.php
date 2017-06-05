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

 /**
  * TODO.
  *
  * @author Matthieu Bilbille (@mbibille)
  */
 abstract class AbstractGroup implements Group
 {
   public function getKanjiStem(Verb $verb)
   {
     return Helper::subString($verb->getKanji(), 0, Analyzer::length($verb->getKanji()) - 1);
   }

   public function getKanaStem(Verb $verb)
   {
     return Helper::subString($verb->getKana(), 0, Analyzer::length($verb->getKana()) - 1);
   }

   public function getKei($form)
   {
     return isset($this->keiPerForm[$form]) ? $this->keiPerForm[$form] : null;
   }

   public function getKeiMapping(Verb $verb, $kei)
   {
     return $this->keiMapping[$verb->getType()][$kei];
   }

   public function getSuffix($form)
   {
     return isset($this->suffixPerForm[$form]) ? $this->suffixPerForm[$form] : null;
   }
 }
