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
 * @author Axel Bodart (@akeru) based on work by Fabien SK (@fabiensk)
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
    const IMPERATIVE = "IMPERATIVE";
    const IMPERATIVE_NEGATIVE = "IMPERATIVE_NEGATIVE";
    const IMPERATIVE_NEUTRAL = "IMPERATIVE_NEUTRAL";
    const IMPERATIVE_POLITE = "IMPERATIVE_POLITE";
    const IMPERATIVE_POLITE_NEGATIVE = "IMPERATIVE_POLITE_NEGATIVE";
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

    private static $ALL = array(
        self::NON_PAST_POLITE,
        self::NON_PAST_NEGATIVE,
        self::NON_PAST_NEGATIVE_POLITE,
        self::PAST,
        self::PAST_POLITE,
        self::PAST_NEGATIVE,
        self::PAST_NEGATIVE_POLITE,
        self::BASE_CONNECTIVE,
        self::SUSPENSIVE_FORM,
        self::PROGRESSIVE,
        self::PROGRESSIVE_POLITE,
        self::PROGRESSIVE_NEGATIVE,
        self::PROGRESSIVE_NEGATIVE_POLITE,
        self::PASSIVE,
        self::PASSIVE_SUSPENSIVE,
        self::IMPERATIVE,
        self::IMPERATIVE_NEGATIVE,
        self::IMPERATIVE_NEUTRAL,
        self::IMPERATIVE_POLITE,
        self::IMPERATIVE_POLITE_NEGATIVE,
        self::OPTATIVE,
        self::OPTATIVE_NEGATIVE_FAMILIAR,
        self::OPTATIVE_NEGATIVE_POLITE_1,
        self::OPTATIVE_NEGATIVE_POLITE_2,
        self::OPTATIVE_PAST,
        self::OPTATIVE_NEGATIVE,
        self::OPTATIVE_PAST_NEGATIVE_POLITE_1,
        self::OPTATIVE_PAST_NEGATIVE_POLITE_2,
        self::OPTATIVE_SUSPENSIVE,
        self::OPTATIVE_CONDITIONAL,
        self::GERUND,
        self::FACTITIVE,
        self::FACTITIVE_SHORTENED,
        self::POTENTIAL_NEUTRAL,
        self::POTENTIAL_POLITE,
        self::CONDITIONAL_BA,
        self::CONDITIONAL_TARA,
        self::VOLITIONAL_FAMILIAR,
        self::VOLITIONAL_POLITE,
        self::LOOK_LIKE_NEUTRAL,
        self::LOOK_LIKE_POLITE,
        self::NOT_LOOK_LIKE_NEUTRAL,
        self::NOT_LOOK_LIKE_POLITE
    );

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
                'imperative' => 'ろ',
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
                'imperative' => 'れ',
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
                'imperative' => 'ね',
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
                'imperative' => 'い',
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
                'base_passive' => 'さ',
                'base_fact' => 'さ',
                'imperative' => 'しろ',
                'volition' => 'そう',
                'connective' => 'して',
                'potential' => 'でき',
                'cond' => 'すれ',
            ),
            's-s' => array(
                'past' => 'した',
                'suspensive' => 'して',
                'base_i' => 'し',
                'base_neg' => 'し',
                'base_e' => 'せ',
                'base_passive' => 'さ',
                'base_fact' => 'さ',
                'imperative' => 'しろ',
                'volition' => 'そう',
                'connective' => 'して',
                'potential' => 'でき',
                'cond' => 'すれ',
            ),
            'z' => array(
                'past' => 'った',
                'suspensive' => 'って',
                'base_i' => 'り',
                'base_neg' => 'ら',
                'base_e' => 'れ',
                'volition' => 'ろう',
                'connective' => 'って'
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
        if (!array_key_exists('imperative', $verb)) {
            $verb['imperative'] = $verb['base_e'];
        }
        if (!array_key_exists('gerund', $verb)) {
            $verb['gerund'] = $verb['base_i'] . $gerund;
        }
        $verb['imperative_neutral'] = $verb['base_i'] . $imperative_neutral;
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
                case self::IMPERATIVE:
                case self::IMPERATIVE_POLITE_NEGATIVE:
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
        } elseif ($type == 's-s') {
            // Remove 'する' part
            $kanaRadical = Helper::subString($kana, 0, Analyzer::length($kana) - 2);
        }
        else {
            $kanaRadical = Helper::subString($kana, 0, Analyzer::length($kana) - 1);
        }
        if (!empty($kanji)) {
           if ($type == 's-s') {
               // Remove 'する' part
               $kanjiRadical = Helper::subString($kanji, 0, Analyzer::length($kanji) - 2);
           } else {
               $kanjiRadical = Helper::subString($kanji, 0, Analyzer::length($kanji) - 1);
           }
        } else {
            $kanjiRadical = null;
        }
        return array('kanji' => $kanjiRadical, 'kana' => $kanaRadical);
    }

    /**
     * Generates conjugation for the given verb to the given type using the
     * given mappings
     *
     * @param array $verb
     * @param array $mappings
     * @param $form
     * @return array
     * @throws Exception
     */
    private static function inflectForm(array $verb, array $mappings, $form)
    {
        $radicals = self::getRadicals($verb, $form);
        switch ($form) {
            case self::NON_PAST_POLITE:
                $suffix = $mappings['polite'];
                break;
            case self::NON_PAST_NEGATIVE:
                $suffix = $mappings['neg'];
                break;
            case self::NON_PAST_NEGATIVE_POLITE:
                $suffix = $mappings['base_i'] . 'ません';
                break;
            case self::PAST:
                $suffix = $mappings['past'];
                break;
            case self::PAST_POLITE:
                $suffix = $mappings['base_i'] . 'ました';
                break;
            case self::PAST_NEGATIVE:
                $suffix = $mappings['neg_past'];
                break;
            case self::PAST_NEGATIVE_POLITE:
                $suffix = $mappings['polite_past_neg'];
                break;
            case self::BASE_CONNECTIVE:
                if (array_key_exists('connective', $mappings)) {
                    $suffix = $mappings['connective'];
                } else {
                    $suffix = $mappings['base_i'];
                }
                $suffix .= '-';
                break;
            case self::SUSPENSIVE_FORM:
                $suffix = $mappings['suspensive'];
                break;
            case self::PROGRESSIVE:
                $suffix = $mappings['suspensive'] . 'いる';
                break;
            case self::PROGRESSIVE_POLITE:
                $suffix = $mappings['suspensive'] . 'います';
                break;
            case self::PROGRESSIVE_NEGATIVE:
                $suffix = $mappings['suspensive'] . 'ない';
                break;
            case self::PROGRESSIVE_NEGATIVE_POLITE:
                $suffix = $mappings['suspensive'] . 'いません';
                break;
            case self::PASSIVE:
                $suffix = $mappings['base_passive'] . 'れる';
                break;
            case self::PASSIVE_SUSPENSIVE:
                $suffix = $mappings['base_passive'] . 'れて';
                break;
            case self::IMPERATIVE:
                $suffix = $mappings['imperative'];
                break;
            case self::IMPERATIVE_NEGATIVE:
                $suffix = 'な';
                break;
            case self::IMPERATIVE_NEUTRAL:
                $suffix = $mappings['imperative_neutral'];
                break;
            case self::IMPERATIVE_POLITE:
                $suffix = $mappings['suspensive'] . 'ください';
                break;
            case self::IMPERATIVE_POLITE_NEGATIVE:
                $suffix = $mappings['neg'] . 'でください';
                break;
            case self::OPTATIVE:
                $suffix = $mappings['base_i'] . 'たい';
                break;
            case self::OPTATIVE_NEGATIVE_FAMILIAR:
                $suffix = $mappings['base_i'] . 'たくない';
                break;
            case self::OPTATIVE_NEGATIVE_POLITE_1:
                $suffix = $mappings['base_i'] . 'たくないです';
                break;
            case self::OPTATIVE_NEGATIVE_POLITE_2:
                $suffix = $mappings['base_i'] . 'たくありません';
                break;
            case self::OPTATIVE_PAST:
                $suffix = $mappings['base_i'] . 'たかった';
                break;
            case self::OPTATIVE_NEGATIVE:
                $suffix = $mappings['base_i'] . 'たくなかった';
                break;
            case self::OPTATIVE_PAST_NEGATIVE_POLITE_1:
                $suffix = $mappings['base_i'] . 'たくなかったです';
                break;
            case self::OPTATIVE_PAST_NEGATIVE_POLITE_2:
                $suffix = $mappings['base_i'] . 'たくありませんでした';
                break;
            case self::OPTATIVE_SUSPENSIVE:
                $suffix = $mappings['base_i'] . 'たくて';
                break;
            case self::OPTATIVE_CONDITIONAL:
                $suffix = $mappings['base_i'] . 'たければ';
                break;
            case self::GERUND:
                $suffix = $mappings['gerund'];
                break;
            case self::FACTITIVE:
                $suffix = $mappings['factitive'];
                break;
            case self::FACTITIVE_SHORTENED:
                $suffix = $mappings['factitive_c'];
                break;
            case self::POTENTIAL_NEUTRAL:
                if (array_key_exists('potential', $mappings)) {
                    $suffix = $mappings['potential'];
                } else {
                    $suffix = $mappings['base_e'];
                }
                $suffix .= 'る';
                break;
            case self::POTENTIAL_POLITE:
                if (array_key_exists('potential', $mappings)) {
                    $suffix = $mappings['potential'];
                } else {
                    $suffix = $mappings['base_e'];
                }
                $suffix .= 'ます';
                break;
            case self::CONDITIONAL_BA:
                if (array_key_exists('cond', $mappings)) {
                    $suffix = $mappings['cond'];
                } else {
                    $suffix = $mappings['base_e'];
                }
                $suffix .= 'ば';
                break;
            case self::CONDITIONAL_TARA:
                $suffix = $mappings['past'] . 'ら';
                break;
            case self::VOLITIONAL_FAMILIAR:
                $suffix = $mappings['volition'];
                break;
            case self::VOLITIONAL_POLITE:
                $suffix = $mappings['volition_polite'];
                break;
            case self::LOOK_LIKE_NEUTRAL:
                $suffix = $mappings['base_i'] . 'そうだ';
                break;
            case self::LOOK_LIKE_POLITE:
                $suffix = $mappings['base_i'] . "そうです";
                break;
            case self::NOT_LOOK_LIKE_NEUTRAL:
                $suffix = $mappings['base_neg'] . "なさそうだ";
                break;
            case self::NOT_LOOK_LIKE_POLITE:
                $suffix = $mappings['base_neg'] . "なさそうです";
                break;
            default:
                throw new Exception('Unknown form ' . $form);
        }
        // Fix #62 support IMPERATIVE_NEGATIVE ; do not use radical with this form
        // but dictionary-form.
        $base = array('kanji' => '', 'kana' => '');
        if($form == self::IMPERATIVE_NEGATIVE) {
            $base['kanji'] = !empty($verb['kanji']) ? $verb['kanji'] : null;
            $base['kana'] = $verb['kana'];
        } else {
            $base['kanji'] = !empty($radicals['kanji']) ? $radicals['kanji'] : null;
            $base['kana'] = $radicals['kana'];
        }

        return array_map(function($val) use ($suffix) {
            return ($val !== null) ? ($val . $suffix) : $val;
        }, $base);
    }

    /**
     * Helper method the generate the database. The JMDict file my be downloaded
     * separately
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
     * Gets a verb entry from the database using either Kanji, Hiragana or Romaji
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
     * Inflects the verb to given forms or all if none input
     *
     * @param $verb
     * @param array $forms
     * @return array
     * @throws Exception
     */
    public static function inflect($verb, $forms = array())
    {
        $result = array();

        if (!$verb) {
            return $result;
        }

        $type = $verb['type'];
        $mapVerbs = self::makeVerbMappings();
        if (!array_key_exists($type, $mapVerbs)) {
            throw new Exception("Unknown verb type : " . $type);
        }

        $mappings = $mapVerbs[$type];
        if (is_string($forms)) {
            return self::inflectForm($verb, $mappings, $forms);
        } elseif (!$forms) {
            $forms = self::$ALL;
        }
        foreach ($forms as $form) {
            $result[$form] = self::inflectForm($verb, $mappings, $form);
        }

        return $result;
    }
}
