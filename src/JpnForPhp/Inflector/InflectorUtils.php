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

use JpnForPhp\Analyzer\Analyzer;
use JpnForPhp\Transliterator\System;
use JpnForPhp\Transliterator\Transliterator;
use JpnForPhp\Inflector\Verb;
use PDO;

class InflectorUtils
{
  /**
   * Generates the SQLite database.
   * Note: The JMDict file may be downloaded separately.
   */
  public static function createDatabase()
  {
      $ddl = file_get_contents('verbs.sql');
      if (file_exists('verbs.db')) {
          unlink('verbs.db');
      }
      $connection = new PDO('sqlite:verbs.db');
      $connection->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
      $connection->exec($ddl);

      $entries = simplexml_load_file('JMdict');
      if ($entries === false) {
        echo 'Could not open JMdict file' . PHP_EOL;
      }

      $connection->beginTransaction();
      $sql = 'INSERT INTO verbs (kanji, kana, type) VALUES (:kanji, :kana, :type)';
      $statement = $connection->prepare($sql);

      foreach ($entries as $entry) {
        $poses = [];
        foreach ($entry->xpath('sense/pos') as $pos) {
          $poses[] = array_keys(get_object_vars($pos))[0];
        }
        
        foreach ($poses as $pos) {
          if (stripos($pos, 'v1') !== false || stripos($pos, 'v5') !== false || $pos == 'vz' || $pos == 'vk' || $pos == 'vn' || $pos == 'vr' || $pos == 'vs-s' || $pos == 'vs-i') {
            $kanji = $entry->k_ele->keb;
            $kana = $entry->r_ele->reb;
            $saved = $statement->execute(array(':kanji' => $kanji, ':kana' => $kana, ':type' => $pos));
            if ($saved === false) {
              die('Could not save entry : ' . implode(' ', $statement->errorInfo()));
            }
          }
        }
      }
      $connection->commit();
  }

  /**
   * Gets a verb entry from the database using either Kanji, Hiragana or Romaji
   *
   * @param $verb A String value
   * @return array Array of Verb instances
   */
  public static function getVerb($verb)
  {
      if (!Analyzer::hasJapaneseLetters($verb)) {
        $verb = (new Transliterator())->transliterate($verb, new System\Hiragana());
      }

      $sql = 'SELECT kanji, kana, type FROM verbs WHERE kanji = :kanji OR kana = :kana';
      $uri = 'sqlite:' . __DIR__ . DIRECTORY_SEPARATOR . 'verbs.db';
      $connection = new PDO($uri);
      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $connection->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
      $statement = $connection->prepare($sql);
      $statement->execute(array(':kanji' => $verb, ':kana' => $verb));
      $results = $statement->fetchAll(PDO::FETCH_CLASS, __NAMESPACE__ . '\\Verb');
      return $results;
  }
}
