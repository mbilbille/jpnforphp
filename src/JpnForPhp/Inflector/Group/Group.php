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
   function getKanjiStem(Verb $verb);

   function getKanaStem(Verb $verb);

   function getKei($form);

   function getKeiMapping(Verb $verb, $kei);

   function getSuffix($form);
 }
