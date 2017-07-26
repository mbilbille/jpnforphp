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

 use JpnForPhp\Inflector\Entry;

 /**
  * Verb interface for inflecting Japanese verbs .
  *
  * @author Matthieu Bilbille (@mbibille)
  */
 interface Verb
 {
   function __construct(Entry $entry);

   function getType();

   function getStem($transliterationForm, $verbalForm, $languageForm);

   function getConjugation($transliterationForm, $conjugatedForm, $verbalForm, $languageForm);

   function getSuffix($verbalForm, $languageForm);
 }
