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
 * @author Axel Bodart (@akeru)
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
    const LOOK_LIKE_NEUTRAL = "LOOK_LIKE_NEUTRAL";
    const LOOK_LIKE_POLITE = "LOOK_LIKE_POLITE";
    const NOT_LOOK_LIKE_NEUTRAL = "NOT_LOOK_LIKE_NEUTRAL";
    const NOT_LOOK_LIKE_POLITE = "NOT_LOOK_LIKE_POLITE";

    /**
     * Generates full mapping for all known verb types
     * @return array
     */
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
                'suspensive' => 'って',
                'base_i' => 'り',
                'base_neg' => 'ら',
                'base_e' => 'れ',
                'volition' => 'ろう',
            ),
            '5u' => array(
                'past' => 'った',
                'suspensive' => 'って',
                'base_i' => 'い',
                'base_neg' => 'わ',
                'base_e' => 'え',
                'volition' => 'おう',
            ),
            '5t' => array(
                'past' => 'った',
                'suspensive' => 'って',
                'base_i' => 'ち',
                'base_neg' => 'た',
                'base_e' => 'て',
                'volition' => 'とう',
            ),
            '5aru' => array(
                'past' => 'った',
                'suspensive' => 'って',
                'base_i' => 'あり',
                'base_passive' => 'れ',
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
                'imper_hard' => 'ね',
                'base_e' => 'べ',
                'volition' => 'のう',
            ),
            'k' => array(
                'past' => 'た',
                'suspensive' => 'て',
                'base_i' => '',
                'base_neg' => '',
                'base_fact' => 'さ',
                'base_passive' => 'ら',
                'imper_hard' => 'い',
                'base_e' => 'られ',
                'cond' => 'れ',
                'volition' => 'よう',
            ),
            's-i' => array(
                'past' => 'した',
                'suspensive' => 'して',
                'base_i' => 'し',
                'base_neg' => 'し',
                'base_e' => 'せ',
                'volition' => '',
                'connective' => 'して',
            )
        );
        foreach ($verbs as $key => &$values) {
            self::makeVerbMapping($values);
        }
        return $verbs;
    }

    /**
     * Generates stub mapping for a given verb type
     *
     * @param array $verb
     * @return array
     */
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

    /**
     * Inflects radical for the given verb to the given form
     *
     * @param array $verb
     * @param $form
     * @return array
     */
    public static function getRadicals(array $verb, $form)
    {
        $kanji = $verb['kanji'];
        $kana = $verb['kana'];
        $type = $verb['type'];
        if ($type == 'k') {
            switch ($form) {
                case self::NON_PAST_NEGATIVE:
                case self::PAST_NEGATIVE:
                case self::PASSIVE:
                case self::PASSIVE_SUSPENSIVE:
                case self::IMPERATIVE_POLITE_NEGATIVE:
                case self::IMPERATIVE_HARD:
                case self::FACTITIVE:
                case self::FACTITIVE_SHORTENED:
                case self::POTENTIAL_NEUTRAL:
                case self::POTENTIAL_POLITE:
                case self::VOLITIONAL_FAMILIAR:
                case self::NOT_LOOK_LIKE_POLITE:
                case self::NOT_LOOK_LIKE_NEUTRAL:
                    $kanaRadical = 'こ';
                    break;
                default:
                    $kanaRadical = 'き';
            }
        } elseif ($type == 's-i') {
            $kanaRadical = '';
        } else {
            $kanaRadical = Helper::subString($kana, 0, Analyzer::length($kana) - 1);
        }
        if (!empty($kanji)) {
            $kanjiRadical = Helper::subString($kanji, 0, Analyzer::length($kanji) - 1);
        } else {
            $kanjiRadical = null;
        }
        return array('kanji' => $kanjiRadical, 'kana' => $kanaRadical);
    }

    /**
     * Generates conjugation for the given verb to the given type using the given suffix
     *
     * @param array $verb
     * @param $suffix
     * @param $type
     * @return array
     */
    private static function conjugateEntry(array $verb, $suffix, $type)
    {
        $radicals = self::getRadicals($verb, $type);
        $kanjiRadical = $radicals['kanji'];
        if (!empty($kanjiRadical)) {
            $kanjiValue = $kanjiRadical . $suffix;
        } else {
            $kanjiValue = null;
        }
        $kanaValue = $radicals['kana'] . $suffix;
        return array('kanji' => $kanjiValue, 'kana' => $kanaValue);
    }

    /**
     * Helper method the generate the database. The JMDict file my be downloaded separately
     */
    public static function generate()
    {
        $ddl = file_get_contents('verbs.sql');
        if (file_exists('verbs.db')) {
            unlink('verbs.db');
        }
        $connection = new PDO('sqlite:verbs.db');
        $connection->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
        $connection->exec($ddl);
        $entries = simplexml_load_file('JMdict');
        if ($entries !== false) {
            $connection->beginTransaction();
            $sql = 'INSERT INTO verbs (kanji, kana, type) VALUES (:kanji, :kana, :type)';
            $statement = $connection->prepare($sql);
            foreach ($entries as $entry) {
                $poses = array_keys(get_object_vars($entry->sense->pos));
                foreach ($poses as $pos) {
                    if (stripos($pos, 'v1') !== false || stripos($pos, 'v5') !== false || $pos == 'vz' || $pos == 'vk' || $pos == 'vn' || $pos == 'vr' || $pos == 'vs-s' || $pos == 'vs-i') {
                        $kanji = $entry->k_ele->keb;
                        $kana = $entry->r_ele->reb;
                        $type = str_replace('v', '', $pos);
                        $saved = $statement->execute(array(':kanji' => $kanji, ':kana' => $kana, ':type' => $type));
                        if ($saved === false) {
                            die('Could not save entry : ' . implode(' ', $statement->errorInfo()));
                        }
                    }
                }
            }
            $connection->commit();
        } else {
            echo 'Could not open JMdict file' . PHP_EOL;
        }
    }

    /**
     * Gets a verb entry from the database using eith kanji, hiragana or romaji
     *
     * @param $verb
     * @return array
     */
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

    /**
     * Conjugates the verb to all known forms
     *
     * @param $verb
     * @return array
     * @throws Exception
     */
    public static function conjugate($verb)
    {
        $ret = array();
        if (!empty($verb)) {
            $type = $verb['type'];
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
                $base_neg = $entries['base_neg'];
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
                if (array_key_exists('cond', $entries)) {
                    $cond = $entries['cond'];
                } else {
                    $cond = $base_e;
                }
                if (array_key_exists('connective', $entries)) {
                    $connective = $entries['connective'];
                } else {
                    $connective = $base_i;
                }
                $cond .= 'ば';
                $cond_tara = $past . 'ら';
                $look_like = $base_i . 'そうだ';
                $look_like_polite = $base_i . "そうです";
                $not_look_like = $base_neg . "なさそうだ";
                $not_look_like_polite = $base_neg . "なさそうです";
                $ret[self::NON_PAST_POLITE] = self::conjugateEntry($verb, $polite, self::NON_PAST_POLITE);
                $ret[self::NON_PAST_NEGATIVE] = self::conjugateEntry($verb, $neg, self::NON_PAST_NEGATIVE);
                $ret[self::NON_PAST_NEGATIVE_POLITE] = self::conjugateEntry($verb, $neg_polite, self::NON_PAST_NEGATIVE_POLITE);
                $ret[self::PAST] = self::conjugateEntry($verb, $past, self::PAST);
                $ret[self::PAST_POLITE] = self::conjugateEntry($verb, $polite_past, self::PAST_POLITE);
                $ret[self::PAST_NEGATIVE] = self::conjugateEntry($verb, $neg_past, self::PAST_NEGATIVE);
                $ret[self::PAST_NEGATIVE_POLITE] = self::conjugateEntry($verb, $polite_past_neg, self::PAST_NEGATIVE_POLITE);
                $ret[self::BASE_CONNECTIVE] = self::conjugateEntry($verb, $connective . '-', self::BASE_CONNECTIVE);
                $ret[self::SUSPENSIVE_FORM] = self::conjugateEntry($verb, $suspensive, self::SUSPENSIVE_FORM);
                $ret[self::PROGRESSIVE] = self::conjugateEntry($verb, $suspensive . 'いる', self::PROGRESSIVE);
                $ret[self::PROGRESSIVE_POLITE] = self::conjugateEntry($verb, $suspensive . 'います', self::PROGRESSIVE_POLITE);
                $ret[self::PROGRESSIVE_NEGATIVE] = self::conjugateEntry($verb, $suspensive . 'ない', self::PROGRESSIVE_NEGATIVE);
                $ret[self::PROGRESSIVE_NEGATIVE_POLITE] = self::conjugateEntry($verb, $suspensive . 'いません', self::PROGRESSIVE_NEGATIVE_POLITE);
                $ret[self::PASSIVE] = self::conjugateEntry($verb, $passive, self::PASSIVE);
                $ret[self::PASSIVE_SUSPENSIVE] = self::conjugateEntry($verb, $passive_suspensive, self::PASSIVE_SUSPENSIVE);
                $ret[self::IMPERATIVE_NEUTRAL] = self::conjugateEntry($verb, $imperative_neutral, self::IMPERATIVE_NEUTRAL);
                $ret[self::IMPERATIVE_POLITE] = self::conjugateEntry($verb, $suspensive . 'ください', self::IMPERATIVE_POLITE);
                $ret[self::IMPERATIVE_POLITE_NEGATIVE] = self::conjugateEntry($verb, $neg . 'でください', self::IMPERATIVE_POLITE_NEGATIVE);
                $ret[self::IMPERATIVE_HARD] = self::conjugateEntry($verb, $imper_hard, self::IMPERATIVE_HARD);
                $ret[self::OPTATIVE] = self::conjugateEntry($verb, $optative, self::OPTATIVE);
                $ret[self::OPTATIVE_NEGATIVE_FAMILIAR] = self::conjugateEntry($verb, $optative_neg, self::OPTATIVE_NEGATIVE_FAMILIAR);
                $ret[self::OPTATIVE_NEGATIVE_POLITE_1] = self::conjugateEntry($verb, $optative_neg_polite_1, self::OPTATIVE_NEGATIVE_POLITE_1);
                $ret[self::OPTATIVE_NEGATIVE_POLITE_2] = self::conjugateEntry($verb, $optative_neg_polite_2, self::OPTATIVE_NEGATIVE_POLITE_2);
                $ret[self::OPTATIVE_PAST] = self::conjugateEntry($verb, $optative_past, self::OPTATIVE_PAST);
                $ret[self::OPTATIVE_NEGATIVE] = self::conjugateEntry($verb, $optative_past_neg, self::OPTATIVE_NEGATIVE);
                $ret[self::OPTATIVE_PAST_NEGATIVE_POLITE_1] = self::conjugateEntry($verb, $optative_past_neg_polite_1, self::OPTATIVE_PAST_NEGATIVE_POLITE_1);
                $ret[self::OPTATIVE_PAST_NEGATIVE_POLITE_2] = self::conjugateEntry($verb, $optative_past_neg_polite_2, self::OPTATIVE_PAST_NEGATIVE_POLITE_2);
                $ret[self::OPTATIVE_SUSPENSIVE] = self::conjugateEntry($verb, $optative_suspensive, self::OPTATIVE_SUSPENSIVE);
                $ret[self::OPTATIVE_CONDITIONAL] = self::conjugateEntry($verb, $optative_cond, self::OPTATIVE_CONDITIONAL);
                $ret[self::GERUND] = self::conjugateEntry($verb, $gerund, self::GERUND);
                $ret[self::FACTITIVE] = self::conjugateEntry($verb, $factitive, self::FACTITIVE);
                $ret[self::FACTITIVE_SHORTENED] = self::conjugateEntry($verb, $factitive_c, self::FACTITIVE_SHORTENED);
                $ret[self::POTENTIAL_NEUTRAL] = self::conjugateEntry($verb, $potential, self::POTENTIAL_NEUTRAL);
                $ret[self::POTENTIAL_POLITE] = self::conjugateEntry($verb, $potential_polite, self::POTENTIAL_POLITE);
                $ret[self::CONDITIONAL_BA] = self::conjugateEntry($verb, $cond, self::CONDITIONAL_BA);
                $ret[self::CONDITIONAL_TARA] = self::conjugateEntry($verb, $cond_tara, self::CONDITIONAL_TARA);
                $ret[self::VOLITIONAL_FAMILIAR] = self::conjugateEntry($verb, $volition, self::VOLITIONAL_FAMILIAR);
                $ret[self::VOLITIONAL_POLITE] = self::conjugateEntry($verb, $volition_polite, self::VOLITIONAL_POLITE);
                $ret[self::LOOK_LIKE_NEUTRAL] = self::conjugateEntry($verb, $look_like, self::LOOK_LIKE_NEUTRAL);
                $ret[self::LOOK_LIKE_POLITE] = self::conjugateEntry($verb, $look_like_polite, self::LOOK_LIKE_POLITE);
                $ret[self::NOT_LOOK_LIKE_NEUTRAL] = self::conjugateEntry($verb, $not_look_like, self::NOT_LOOK_LIKE_NEUTRAL);
                $ret[self::NOT_LOOK_LIKE_POLITE] = self::conjugateEntry($verb, $not_look_like_polite, self::NOT_LOOK_LIKE_POLITE);
            } else {
                throw new Exception("Unknown verb type : " . $type);
            }
        }
        return $ret;
    }
}

//Inflector::generate();

