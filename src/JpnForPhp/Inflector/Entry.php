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

class Entry
{

  private $kanji;

  private $kana;

  private $type;

  public function setKanji($kanji) {
      $this->kanji = $kanji;
  }

  public function getKanji() {
    return $this->kanji;
  }

  public function setKana($kana) {
      $this->kana = $kana;
  }

  public function getKana() {
      return $this->kana;
  }

  public function setType($type) {
      $this->type = $type;
  }

  public function getType() {
      return $this->type;
  }
}
