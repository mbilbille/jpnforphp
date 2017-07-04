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

 use JpnForPhp\Inflector\Verb;

 /**
  * TODO.
  *
  * @author Matthieu Bilbille (@mbibille)
  */
 interface Group
 {
   function __construct(Verb $verb);

   function getStem($transliterationForm, $verbalForm, $languageForm);

   function getConjugation($conjugatedForm, $verbalForm, $languageForm);

   function getSuffix($verbalForm, $languageForm);
 }
