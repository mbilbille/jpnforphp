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

use Exception;
use JpnForPhp\Analyzer\Analyzer;
use JpnForPhp\Helper\Helper;
use JpnForPhp\Transliterator\Kana;
use PDO;

/**
 * Provides support for inflecting Japanese verbs.
 *
 * @author Matthieu Bilbille
 */
class Inflector
{

    const NON_PAST_POLITE = "NON_PAST_POLITE";
    const NON_PAST_NEGATIVE = "NON_PAST_NEGATIVE";
    const NON_PAST_NEGATIVE_POLITE = "NON_PAST_NEGATIVE_POLITE";
    const PAST = "PAST";
    const PAST_POLITE = "PAST_POLITE";
    const PAST_NEGATIVE = "PAST_NEGATIVE";
    const PAST_NEGATIVE_POLITE = "PAST_NEGATIVE_POLITE";
    const BASE_CONNECTIVE = "BASE_CONNECTIVE";
    const SUSPENSIVE_FORM = "SUSPENSIVE_FORM";
    const PROGRESSIVE = "PROGRESSIVE";
    const PROGRESSIVE_POLITE = "PROGRESSIVE_POLITE";
    const PROGRESSIVE_NEGATIVE = "PROGRESSIVE_NEGATIVE";
    const PROGRESSIVE_NEGATIVE_POLITE = "PROGRESSIVE_NEGATIVE_POLITE";
    const PASSIVE = "PASSIVE";
    const PASSIVE_SUSPENSIVE = "PASSIVE_SUSPENSIVE";
    const IMPERATIVE_NEUTRAL = "IMPERATIVE_NEUTRAL";
    const IMPERATIVE_POLITE = "IMPERATIVE_POLITE";
    const IMPERATIVE_POLITE_NEGATIVE = "IMPERATIVE_POLITE_NEGATIVE";
    const IMPERATIVE_HARD = "IMPERATIVE_HARD";
    const OPTATIVE = "OPTATIVE";
    const OPTATIVE_NEGATIVE_FAMILIAR = "OPTATIVE_NEGATIVE_FAMILIAR";
    const OPTATIVE_NEGATIVE_POLITE_1 = "OPTATIVE_NEGATIVE_POLITE_1";
    const OPTATIVE_NEGATIVE_POLITE_2 = "OPTATIVE_NEGATIVE_POLITE_2";
    const OPTATIVE_PAST = "OPTATIVE_PAST";
    const OPTATIVE_NEGATIVE = "OPTATIVE_NEGATIVE";
    const OPTATIVE_PAST_NEGATIVE_POLITE_1 = "OPTATIVE_PAST_NEGATIVE_POLITE_1";
    const OPTATIVE_PAST_NEGATIVE_POLITE_2 = "OPTATIVE_PAST_NEGATIVE_POLITE_2";
    const OPTATIVE_SUSPENSIVE = "OPTATIVE_SUSPENSIVE";
    const OPTATIVE_CONDITIONAL = "OPTATIVE_CONDITIONAL";
    const GERUND = "GERUND";
    const FACTITIVE = "FACTITIVE";
    const FACTITIVE_SHORTENED = "FACTITIVE_SHORTENED";
    const POTENTIAL_NEUTRAL = "POTENTIAL_NEUTRAL";
    const POTENTIAL_POLITE = "POTENTIAL_POLITE";
    const CONDITIONAL_BA = "CONDITIONAL_BA";
    const CONDITIONAL_TARA = "CONDITIONAL_TARA";
    const VOLITIONAL_FAMILIAR = "VOLITIONAL_FAMILIAR";
    const VOLITIONAL_POLITE = "VOLITIONAL_POLITE";
    const LOOK_LIKE_NEUTRAL = "LOOK_LIKE_NEUTRAL_";
    const LOOK_LIKE_POLITE = "LOOK_LIKE_POLITE_";
    const NOT_LOOK_LIKE_NEUTRAL = "NOT_LOOK_LIKE_NEUTRAL";
    const NOT_LOOK_LIKE_POLITE = "NOT_LOOK_LIKE_POLITE";

    private static function makeVerbMappings()
    {
        $verbs = array(
            '1' => array(
                'past' => 'た',
                'suspensive' => 'て',
                'base_i' => '',
                'base_neg' => '',
                'base_fact' => 'さ',
                'base_passive' => 'ら',
                'imper_hard' => 'ろ',
                'base_e' => 'れ',
                'volition' => 'よう',
            ),
            '5s' => array(
                'past' => 'した',
                'suspensive' => 'して',
                'base_i' => 'し',
                'base_neg' => 'さ',
                'base_e' => 'せ',
                'volition' => 'そう',
            ),
            '5k' => array(
                'past' => 'いた',
                'suspensive' => 'いて',
                'base_i' => 'き',
                'base_neg' => 'か',
                'base_e' => 'け',
                'volition' => 'こう',
            ),
            '5k-s' => array(
                'past' => 'った',
                'suspensive' => 'って',
                'base_i' => 'き',
                'base_neg' => 'か',
                'base_e' => 'け',
                'volition' => 'こう',
            ),
            '5g' => array(
                'past' => 'いだ',
                'suspensive' => 'いで',
                'base_i' => 'ぎ',
                'base_neg' => 'が',
                'base_e' => 'げ',
                'volition' => 'ごう',
            ),
            '5r' => array(
                'past' => 'った',
                'suspensive' => 'った',
                'base_i' => 'り',
                'base_neg' => 'ら',
                'base_e' => 'れ',
                'volition' => 'ろう',
            ),
            '5u' => array(
                'past' => 'った',
                'suspensive' => 'った',
                'base_i' => 'い',
                'base_neg' => 'わ',
                'base_e' => 'え',
                'volition' => 'おう',
            ),
            '5t' => array(
                'past' => 'った',
                'suspensive' => 'った',
                'base_i' => 'ち',
                'base_neg' => 'た',
                'base_e' => 'て',
                'volition' => 'とう',
            ),
            '5aru' => array(
                'past' => 'った',
                'suspensive' => 'った',
                'base_i' => 'あり',
                'base_neg' => 'ら',
                'base_e' => 'あれ',
                'volition' => 'あろう',
            ),
            '5m' => array(
                'past' => 'んだ',
                'suspensive' => 'んで',
                'base_i' => 'み',
                'base_neg' => 'ま',
                'base_e' => 'め',
                'volition' => 'もう',
            ),
            '5b' => array(
                'past' => 'んだ',
                'suspensive' => 'んで',
                'base_i' => 'び',
                'base_neg' => 'ば',
                'base_e' => 'べ',
                'volition' => 'ぼう',
            ),
            '5n' => array(
                'past' => 'んだ',
                'suspensive' => 'んで',
                'base_i' => 'に',
                'base_neg' => 'な',
                'base_e' => 'べ',
                'volition' => 'のう',
            ),
        );
        foreach ($verbs as $key => &$values) {
            self::makeVerbMapping($values);
        }
        return $verbs;
    }

    private static function makeVerbMapping(array &$verb)
    {
        $imperative_neutral = 'なさい';
        $gerund = 'ながら';
        $polite = 'ます';
        $volition_polite = 'ましょう';
        $polite_past_neg = 'ませんでした';
        $neg = 'ない';
        $neg_past = 'なかった';
        $factitive = 'せる';
        $factitive_c = 'す';
        if (!array_key_exists('base_fact', $verb)) {
            $verb['base_fact'] = $verb['base_neg'];
        }
        if (!array_key_exists('base_passive', $verb)) {
            $verb['base_passive'] = $verb['base_neg'];
        }
        if (!array_key_exists('imper_hard', $verb)) {
            $verb['imper_hard'] = $verb['base_e'];
        }
        $verb['imperative_neutral'] = $verb['base_i'] . $imperative_neutral;
        $verb['gerund'] = $verb['base_i'] . $gerund;
        $verb['polite'] = $verb['base_i'] . $polite;
        $verb['volition_polite'] = $verb['base_i'] . $volition_polite;
        $verb['polite_past_neg'] = $verb['base_i'] . $polite_past_neg;
        $verb['neg'] = $verb['base_neg'] . $neg;
        $verb['neg_past'] = $verb['base_neg'] . $neg_past;
        $verb['factitive'] = $verb['base_fact'] . $factitive;
        $verb['factitive_c'] = $verb['base_fact'] . $factitive_c;
        return $verb;
    }

    public static function generate()
    {
        $ddl = file_get_contents('verbs.sql');
        if (file_exists('verbs.db')) {
            unlink('verbs.db');
        }
        $connection = new PDO('sqlite:verbs.db');
        $connection->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
        $connection->exec($ddl);
        $handle = fopen('verbs.csv', 'r');
        if ($handle !== false) {
            $connection->beginTransaction();
            $sql = 'INSERT INTO verbs (kanji, kana, type) VALUES (:kanji, :kana, :type)';
            $statement = $connection->prepare($sql);
            while (($verb = fgetcsv($handle)) !== false) {
                $statement->execute(array(':kanji' => $verb[3], ':kana' => $verb[4], ':type' => $verb[1] . $verb[2]));
            }
            $connection->commit();
        } else {
            echo 'Could not open file' . PHP_EOL;
        }
    }

    public static function getVerb($verb)
    {
        if (!Analyzer::hasJapaneseLetters($verb)) {
            $hepburn = new Kana();
            $verb = $hepburn->transliterate($verb);
        }
        $sql = 'SELECT * FROM verbs WHERE kanji = :kanji OR kana = :kana';
        $uri = 'sqlite:' . __DIR__ . DIRECTORY_SEPARATOR . 'verbs.db';
        $connection = new PDO($uri);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $connection->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
        $statement = $connection->prepare($sql);
        $statement->execute(array(':kanji' => $verb, ':kana' => $verb));
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

    public static function conjugate($verb)
    {
        $ret = array();
        if (!empty($verb)) {
            $type = $verb['type'];
            $kanji = $verb['kanji'];
            $kana = $verb['kana'];
            $kanjiRadical = Helper::subString($kanji, 0, Analyzer::length($kanji) - 1);
            $kanaRadical = Helper::subString($kana, 0, Analyzer::length($kana) - 1);
            $mapVerbs = self::makeVerbMappings();
            if (array_key_exists($type, $mapVerbs)) {
                $entries = $mapVerbs[$type];
                $past = $entries['past'];
                $suspensive = $entries['suspensive'];
                $base_i = $entries['base_i'];
                $imperative_neutral = $entries['imperative_neutral'];
                $gerund = $entries['gerund'];
                $polite = $entries['polite'];
                $volition_polite = $entries['volition_polite'];
                $polite_past_neg = $entries['polite_past_neg'];
                $neg = $entries['neg'];
                $neg_past = $entries['neg_past'];
                $factitive = $entries['factitive'];
                $factitive_c = $entries['factitive_c'];
                $base_passive = $entries['base_passive'];
                $imper_hard = $entries['imper_hard'];
                $base_e = $entries['base_e'];
                $volition = $entries['volition'];
                $potential = $base_e . 'る';
                $potential_polite = $base_e . 'ます';
                $polite_past = $base_i . 'ました';
                $neg_polite = $base_i . 'ません';
                $optative = $base_i . 'たい';
                $optative_cond = $base_i . 'たければ';
                $optative_neg = $base_i . 'たくない';
                $optative_neg_polite_1 = $base_i . 'たくないです';
                $optative_neg_polite_2 = $base_i . 'たくありません';
                $optative_past = $base_i . 'たかった';
                $optative_past_neg = $base_i . 'たくなかった';
                $optative_past_neg_polite_1 = $base_i . 'たくなかったです';
                $optative_past_neg_polite_2 = $base_i . 'たくありませんでした';
                $optative_suspensive = $base_i . 'たくて';
                $passive = $base_passive . 'れる';
                $passive_suspensive = $base_passive . 'れて';
                $cond = $base_e . 'ば';
                $cond_tara = $past . 'ら';
                $look_like = $base_i . 'そうだ';
                $ret[self::NON_PAST_POLITE] = array('kanji' => $kanjiRadical . $polite, 'kana' => $kanaRadical . $polite);
                $ret[self::NON_PAST_NEGATIVE] = array('kanji' => $kanjiRadical . $neg, 'kana' => $kanaRadical . $neg);
                $ret[self::NON_PAST_NEGATIVE_POLITE] = array('kanji' => $kanjiRadical . $neg_polite, 'kana' => $kanaRadical . $neg_polite);
                $ret[self::PAST] = array('kanji' => $kanjiRadical . $past, 'kana' => $kanaRadical . $past);
                $ret[self::PAST_POLITE] = array('kanji' => $kanjiRadical . $polite_past, 'kana' => $kanaRadical . $polite_past);
                $ret[self::PAST_NEGATIVE] = array('kanji' => $kanjiRadical . $neg_past, 'kana' => $kanaRadical . $neg_past);
                $ret[self::PAST_NEGATIVE_POLITE] = array('kanji' => $kanjiRadical . $polite_past_neg, 'kana' => $kanaRadical . $polite_past_neg);
                $ret[self::BASE_CONNECTIVE] = array('kanji' => $kanjiRadical . $base_i . '-', 'kana' => $kanaRadical . $base_i . '-');
                $ret[self::SUSPENSIVE_FORM] = array('kanji' => $kanjiRadical . $suspensive, 'kana' => $kanaRadical . $suspensive);
                $ret[self::PROGRESSIVE] = array('kanji' => $kanjiRadical . $suspensive . 'いる', 'kana' => $kanaRadical . $suspensive . 'いる');
                $ret[self::PROGRESSIVE_POLITE] = array('kanji' => $kanjiRadical . $suspensive . 'います', 'kana' => $kanaRadical . $suspensive . 'います');
                $ret[self::PROGRESSIVE_NEGATIVE] = array('kanji' => $kanjiRadical . $suspensive . 'ない', 'kana' => $kanaRadical . $suspensive . 'ない');
                $ret[self::PROGRESSIVE_NEGATIVE_POLITE] = array('kanji' => $kanjiRadical . $suspensive . 'いません', 'kana' => $kanaRadical . $suspensive . 'いません');
                $ret[self::PASSIVE] = array('kanji' => $kanjiRadical . $passive, 'kana' => $kanaRadical . $passive);
                $ret[self::PASSIVE_SUSPENSIVE] = array('kanji' => $kanjiRadical . $passive_suspensive, 'kana' => $kanaRadical . $passive_suspensive);
                $ret[self::IMPERATIVE_NEUTRAL] = array('kanji' => $kanjiRadical . $imperative_neutral, 'kana' => $kanaRadical . $imperative_neutral);
                $ret[self::IMPERATIVE_POLITE] = array('kanji' => $kanjiRadical . $suspensive . 'ください', 'kana' => $kanaRadical . $suspensive . 'ください');
                $ret[self::IMPERATIVE_POLITE_NEGATIVE] = array('kanji' => $kanjiRadical . $neg . 'でください', 'kana' => $kanaRadical . $neg . 'でください');
                $ret[self::IMPERATIVE_HARD] = array('kanji' => $kanjiRadical . $imper_hard, 'kana' => $kanaRadical . $imper_hard);
                $ret[self::OPTATIVE] = array('kanji' => $kanjiRadical . $optative, 'kana' => $kanaRadical . $optative);
                $ret[self::OPTATIVE_NEGATIVE_FAMILIAR] = array('kanji' => $kanjiRadical . $optative_neg, 'kana' => $kanaRadical . $optative_neg);
                $ret[self::OPTATIVE_NEGATIVE_POLITE_1] = array('kanji' => $kanjiRadical . $optative_neg_polite_1, 'kana' => $kanaRadical . $optative_neg_polite_1);
                $ret[self::OPTATIVE_NEGATIVE_POLITE_1] = array('kanji' => $kanjiRadical . $optative_neg_polite_2, 'kana' => $kanaRadical . $optative_neg_polite_2);
                $ret[self::OPTATIVE_PAST] = array('kanji' => $kanjiRadical . $optative_past, 'kana' => $kanaRadical . $optative_past);
                $ret[self::OPTATIVE_NEGATIVE] = array('kanji' => $kanjiRadical . $optative_past_neg, 'kana' => $kanaRadical . $optative_past_neg);
                $ret[self::OPTATIVE_NEGATIVE_POLITE_1] = array('kanji' => $kanjiRadical . $optative_past_neg_polite_1, 'kana' => $kanaRadical . $optative_past_neg_polite_1);
                $ret[self::OPTATIVE_NEGATIVE_POLITE_2] = array('kanji' => $kanjiRadical . $optative_past_neg_polite_2, 'kana' => $kanaRadical . $optative_past_neg_polite_2);
                $ret[self::OPTATIVE_SUSPENSIVE] = array('kanji' => $kanjiRadical . $optative_suspensive, 'kana' => $kanaRadical . $optative_suspensive);
                $ret[self::OPTATIVE_CONDITIONAL] = array('kanji' => $kanjiRadical . $optative_cond, 'kana' => $kanaRadical . $optative_cond);
                $ret[self::GERUND] = array('kanji' => $kanjiRadical . $gerund, 'kana' => $kanaRadical . $gerund);
                $ret[self::FACTITIVE] = array('kanji' => $kanjiRadical . $factitive, 'kana' => $kanaRadical . $factitive);
                $ret[self::FACTITIVE_SHORTENED] = array('kanji' => $kanjiRadical . $factitive_c, 'kana' => $kanaRadical . $factitive_c);
                $ret[self::POTENTIAL_NEUTRAL] = array('kanji' => $kanjiRadical . $potential, 'kana' => $kanaRadical . $potential);
                $ret[self::POTENTIAL_POLITE] = array('kanji' => $kanjiRadical . $potential_polite, 'kana' => $kanaRadical . $potential_polite);
                $ret[self::CONDITIONAL_BA] = array('kanji' => $kanjiRadical . $cond, 'kana' => $kanaRadical . $cond);
                $ret[self::CONDITIONAL_TARA] = array('kanji' => $kanjiRadical . $cond_tara, 'kana' => $kanaRadical . $cond_tara);
                $ret[self::VOLITIONAL_FAMILIAR] = array('kanji' => $kanjiRadical . $volition, 'kana' => $kanaRadical . $volition);
                $ret[self::VOLITIONAL_POLITE] = array('kanji' => $kanjiRadical . $volition_polite, 'kana' => $kanaRadical . $volition_polite);
                $ret[self::LOOK_LIKE_NEUTRAL] = array('kanji' => $kanjiRadical . $look_like, 'kana' => $kanaRadical . $look_like);
            } else {
                throw new Exception("Unknown verb type : " . $type);
            }
        }
        return $ret;
    }
}

//Inflector::generate();

