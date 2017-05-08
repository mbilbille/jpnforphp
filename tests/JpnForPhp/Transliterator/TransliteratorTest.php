<?php

/*
 * This file is part of the JpnForPhp package.
 *
 * (c) Matthieu Bilbille
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JpnForPhp\Tests\Transliterator;

use JpnForPhp\Transliterator\Romaji;
use JpnForPhp\Transliterator\Kana;

/**
 * JpnForPhp Testcase for Transliterator component
 */
class TransliteratorTest extends \PHPUnit_Framework_TestCase
{
    protected static $romaji;
    protected static $hepburn;
    protected static $hepburn_traditional;
    protected static $kunrei;
    protected static $nihon;
    protected static $wapuro;
    protected static $kana;
    protected static $hiragana;
    protected static $katakana;

    public static function setUpBeforeClass()
    {
        self::$romaji = new Romaji();
        self::$hepburn = new Romaji('hepburn');
        self::$hepburn_traditional = new Romaji('hepburn_traditional');
        self::$kunrei = new Romaji('kunrei');
        self::$nihon = new Romaji('nihon');
        self::$wapuro = new Romaji('wapuro');
        self::$kana = new Kana();
        self::$hiragana = new Kana('hiragana');
        self::$katakana = new Kana('katakana');
    }

    public function testTransliterateToRomajiWithDefaultParameters()
    {
        $result = self::$romaji->transliterate('くるま');
        $this->assertEquals('kuruma', $result);
    }

    public function testTransliterateToRomajiWithDefaultParametersWhenEmptyString()
    {
        $result = self::$romaji->transliterate('');
        $this->assertEquals('', $result);
    }

    public function testTransliterateToRomajiWithHepburn()
    {
        $result = self::$hepburn->transliterate('くるま');
        $this->assertEquals('kuruma', $result);
    }

    public function testTransliterateToRomajiWithHepburnWhenLatinOnly()
    {
        $result = self::$hepburn->transliterate('yahoo YAHOO');
        $this->assertEquals('yahoo YAHOO', $result);
    }

    public function testTransliterateToRomajiWithHepburnWhenLatinForMultipleTimes()
    {
        $result = self::$hepburn->transliterate('1st time, いかいめ');
        $this->assertEquals('1st time, ikaime', $result);

        $result = self::$hepburn->transliterate('2nd time, にかいめ');
        $this->assertEquals('2nd time, nikaime', $result);
    }

    public function testTransliterateToRomajiWithHepburnWhenLongVowels()
    {
        $result = self::$hepburn->transliterate('がっこう');
        $this->assertEquals('gakkō', $result);
    }

    public function testTransliterateToRomajiWithHepburnWhenLongA()
    {
        $result = self::$hepburn->transliterate('おばあさん');
        $this->assertEquals('obāsan', $result);
    }

    public function testTransliterateToRomajiWithHepburnWhenLongI()
    {
        $result = self::$hepburn->transliterate('おにいさん');
        $this->assertEquals('oniisan', $result);
    }

    public function testTransliterateToRomajiWithHepburnWhenSokuonInHiragana()
    {
        $result = self::$hepburn->transliterate('けっか');
        $this->assertEquals('kekka', $result);
    }

    public function testTransliterateToRomajiWithHepburnWhenSokuonInKatakana()
    {
        $result = self::$hepburn->transliterate('サッカー');
        $this->assertEquals('sakkā', $result);
    }

    public function testTransliterateToRomajiWithHepburnWhenSokuonTchInHiragana()
    {
        $result = self::$hepburn->transliterate('マッチャ');
        $this->assertEquals('matcha', $result);
    }

    public function testTransliterateToRomajiWithHepburnWhenParticles()
    {
        $result = self::$hepburn->transliterate('サッカーをやる');
        $this->assertEquals('sakkāwoyaru', $result);
    }

    public function testTransliterateToRomajiWithHepburnWhenChoonpu()
    {
        $result = self::$hepburn->transliterate('パーティー');
        $this->assertEquals('pātī', $result);
    }

    public function testTransliterateToRomajiWithHepburnWhenMixingHiraganaAndKatakana()
    {
        $result = self::$hepburn->transliterate('サッカー を やる');
        $this->assertEquals('sakkā o yaru', $result);
    }

    public function testTransliterateToRomajiWithHepburnWhenNFollowedByVowel()
    {
        $result = self::$hepburn->transliterate('きんえん');
        $this->assertEquals('kin\'en', $result);
    }

    public function testTransliterateToRomajiWithHepburnWhenNFollowedByConsonant()
    {
        $result = self::$hepburn->transliterate('あんない');
        $this->assertEquals('annai', $result);
    }

    public function testTransliterateToRomajiWithHepburnWhenNFollowedByLabialConsonant()
    {
        $result = self::$hepburn->transliterate('ぐんま');
        $this->assertEquals('gunma', $result);
    }

    public function testTransliterateToRomajiWithHepburnWhenPunctuationMarks()
    {
        $result = self::$hepburn->transliterate('｛｝（）［］【】、，…‥。・〽「」『』〜：！？　');
        $this->assertEquals('{}()[][], , …….-\'\'\'""~:!? ', $result);
    }

    public function testTransliterateToRomajiWithHepburnTraditional()
    {
        $result = self::$hepburn_traditional->transliterate('くるま');
        $this->assertEquals('kuruma', $result);
    }

    public function testTransliterateToRomajiWithHepburnTraditionalWhenLatinOnly()
    {
        $result = self::$hepburn_traditional->transliterate('yahoo YAHOO');
        $this->assertEquals('yahoo YAHOO', $result);
    }

    public function testTransliterateToRomajiWithHepburnTraditionalWhenLongVowels()
    {
        $result = self::$hepburn_traditional->transliterate('がっこう');
        $this->assertEquals('gakkō', $result);
    }

    public function testTransliterateToRomajiWithHepburnTraditionalWhenLongA()
    {
        $result = self::$hepburn_traditional->transliterate('おばあさん');
        $this->assertEquals('obaasan', $result);
    }

    public function testTransliterateToRomajiWithHepburnTraditionalWhenLongI()
    {
        $result = self::$hepburn_traditional->transliterate('おにいさん');
        $this->assertEquals('oniisan', $result);
    }

    public function testTransliterateToRomajiWithHepburnTraditionalWhenSokuonInHiragana()
    {
        $result = self::$hepburn_traditional->transliterate('けっか');
        $this->assertEquals('kekka', $result);
    }

    public function testTransliterateToRomajiWithHepburnTraditionalWhenSokuonInKatakana()
    {
        $result = self::$hepburn_traditional->transliterate('サッカー');
        $this->assertEquals('sakkā', $result);
    }

    public function testTransliterateToRomajiWithHepburnTraditionalWhenSokuonTchInHiragana()
    {
        $result = self::$hepburn_traditional->transliterate('マッチャ');
        $this->assertEquals('matcha', $result);
    }

    public function testTransliterateToRomajiWithHepburnTraditionalWhenParticles()
    {
        $result = self::$hepburn_traditional->transliterate('サッカーをやる');
        $this->assertEquals('sakkāwoyaru', $result);
    }

    public function testTransliterateToRomajiWithHepburnTraditionalWhenChoonpu()
    {
        $result = self::$hepburn_traditional->transliterate('パーティー');
        $this->assertEquals('pātī', $result);
    }

    public function testTransliterateToRomajiWithHepburnTraditionalWhenMixingHiraganaAndKatakana()
    {
        $result = self::$hepburn_traditional->transliterate('サッカー を やる');
        $this->assertEquals('sakkā wo yaru', $result);
    }

    public function testTransliterateToRomajiWithHepburnTraditionalWhenNFollowedByVowel()
    {
        $result = self::$hepburn_traditional->transliterate('きんえん');
        $this->assertEquals('kin-en', $result);
    }

    public function testTransliterateToRomajiWithHepburnTraditionalWhenNFollowedByConsonant()
    {
        $result = self::$hepburn_traditional->transliterate('あんない');
        $this->assertEquals('annai', $result);
    }

    public function testTransliterateToRomajiWithHepburnTraditionalWhenNFollowedByLabialConsonant()
    {
        $result = self::$hepburn_traditional->transliterate('ぐんま');
        $this->assertEquals('gumma', $result);
    }

    public function testTransliterateToRomajiWithHepburnTraditionalWhenPunctuationMarks()
    {
        $result = self::$hepburn_traditional->transliterate('｛｝（）［］【】、，…‥。・〽「」『』〜：！？　');
        $this->assertEquals('{}()[][], , …….-\'\'\'""~:!? ', $result);
    }

    public function testTransliterateToRomajiWithKunrei()
    {
        $result = self::$kunrei->transliterate('くるま');
        $this->assertEquals('kuruma', $result);
    }

    public function testTransliterateToRomajiWithKunreiWhenLatinOnly()
    {
        $result = self::$kunrei->transliterate('yahoo YAHOO');
        $this->assertEquals('yahoo YAHOO', $result);
    }

    public function testTransliterateToRomajiWithKunreiWhenLongVowels()
    {
        $result = self::$kunrei->transliterate('がっこう');
        $this->assertEquals('gakkô', $result);
    }

    public function testTransliterateToRomajiWithKunreiWhenSSounds()
    {
        $result = self::$kunrei->transliterate('ほしい');
        $this->assertEquals('hosii', $result);
    }

    public function testTransliterateToRomajiWithKunreiWhenFuSound()
    {
        $result = self::$kunrei->transliterate('フライドポテト');
        $this->assertEquals('huraidopoteto', $result);
    }

    public function testTransliterateToRomajiWithKunreiWhenTeiSound()
    {
        $result = self::$kunrei->transliterate('ティーム');
        $this->assertEquals('tîmu', $result);
    }

    public function testTransliterateToRomajiWithKunreiWhenSokuonInHiragana()
    {
        $result = self::$kunrei->transliterate('けっか');
        $this->assertEquals('kekka', $result);
    }

    public function testTransliterateToRomajiWithKunreiWhenSokuonInKatakana()
    {
        $result = self::$kunrei->transliterate('サッカー');
        $this->assertEquals('sakkâ', $result);
    }

    public function testTransliterateToRomajiWithKunreiWhenSokuonTchInHiragana()
    {
        $result = self::$kunrei->transliterate('マッチャ');
        $this->assertEquals('mattya', $result);
    }

    public function testTransliterateToRomajiWithKunreiWhenParticles()
    {
        $result = self::$kunrei->transliterate('サッカーをやる');
        $this->assertEquals('sakkâwoyaru', $result);
    }

    public function testTransliterateToRomajiWithKunreiWhenChoonpu()
    {
        $result = self::$kunrei->transliterate('パーティー');
        $this->assertEquals('pâtî', $result);
    }

    public function testTransliterateToRomajiWithKunreiWhenMixingHiraganaAndKatakana()
    {
        $result = self::$kunrei->transliterate('サッカー を やる');
        $this->assertEquals('sakkâ o yaru', $result);
    }

    public function testTransliterateToRomajiWithKunreiWhenNFollowedByVowel()
    {
        $result = self::$kunrei->transliterate('きんえん');
        $this->assertEquals('kin\'en', $result);
    }

    public function testTransliterateToRomajiWithKunreiWhenNFollowedByConsonant()
    {
        $result = self::$kunrei->transliterate('あんない');
        $this->assertEquals('annai', $result);
    }

    public function testTransliterateToRomajiWithKunreiWhenPunctuationMarks()
    {
        $result = self::$kunrei->transliterate('｛｝（）［］【】、，…‥。・〽「」『』〜：！？　');
        $this->assertEquals('{}()[][], , …….-\'\'\'""~:!? ', $result);
    }
    public function testTransliterateToRomajiWithNihon()
    {
        $result = self::$nihon->transliterate('くるま');
        $this->assertEquals('kuruma', $result);
    }

    public function testTransliterateToRomajiWithNihonWhenLatinOnly()
    {
        $result = self::$nihon->transliterate('yahoo YAHOO');
        $this->assertEquals('yahoo YAHOO', $result);
    }

    public function testTransliterateToRomajiWithNihonWhenLongVowels()
    {
        $result = self::$nihon->transliterate('がっこう');
        $this->assertEquals('gakkô', $result);
    }

    public function testTransliterateToRomajiWithNihonWhenSSounds()
    {
        $result = self::$nihon->transliterate('ほしい');
        $this->assertEquals('hosii', $result);
    }

    public function testTransliterateToRomajiWithNihonWhenDuSound()
    {
        $result = self::$nihon->transliterate('かなづかい');
        $this->assertEquals('kanadukai', $result);
    }

    public function testTransliterateToRomajiWithNihonWhenSokuonInHiragana()
    {
        $result = self::$nihon->transliterate('けっか');
        $this->assertEquals('kekka', $result);
    }

    public function testTransliterateToRomajiWithNihonWhenSokuonInKatakana()
    {
        $result = self::$nihon->transliterate('サッカー');
        $this->assertEquals('sakkâ', $result);
    }

    public function testTransliterateToRomajiWithNihonWhenSokuonTchInHiragana()
    {
        $result = self::$nihon->transliterate('マッチャ');
        $this->assertEquals('mattya', $result);
    }

    public function testTransliterateToRomajiWithNihonWhenParticles()
    {
        $result = self::$nihon->transliterate('サッカーをやる');
        $this->assertEquals('sakkâwoyaru', $result);
    }

    public function testTransliterateToRomajiWithNihonWhenChoonpu()
    {
        $result = self::$nihon->transliterate('パーティー');
        $this->assertEquals('pâtî', $result);
    }

    public function testTransliterateToRomajiWithNihonWhenMixingHiraganaAndKatakana()
    {
        $result = self::$nihon->transliterate('サッカー を やる');
        $this->assertEquals('sakkâ wo yaru', $result);
    }

    public function testTransliterateToRomajiWithNihonWhenNFollowedByVowel()
    {
        $result = self::$nihon->transliterate('きんえん');
        $this->assertEquals('kin\'en', $result);
    }

    public function testTransliterateToRomajiWithNihonWhenNFollowedByConsonant()
    {
        $result = self::$nihon->transliterate('あんない');
        $this->assertEquals('annai', $result);
    }

    public function testTransliterateToRomajiWithNihonWhenPunctuationMarks()
    {
        $result = self::$nihon->transliterate('｛｝（）［］【】、，…‥。・〽「」『』〜：！？　');
        $this->assertEquals('{}()[][], , …….-\'\'\'""~:!? ', $result);
    }

    public function testTransliterateToRomajiWithWapuro()
    {
        $result = self::$wapuro->transliterate('くるま');
        $this->assertEquals('kuruma', $result);
    }

    public function testTransliterateToRomajiWithWapuroWhenLatinOnly()
    {
        $result = self::$wapuro->transliterate('yahoo YAHOO');
        $this->assertEquals('yahoo YAHOO', $result);
    }

    public function testTransliterateToRomajiWithWapuroWhenLongVowels()
    {
        $result = self::$wapuro->transliterate('がっこう');
        $this->assertEquals('gakkou', $result);
    }

    public function testTransliterateToRomajiWithWapuroWhenSokuonInHiragana()
    {
        $result = self::$wapuro->transliterate('けっか');
        $this->assertEquals('kekka', $result);
    }

    public function testTransliterateToRomajiWithWapuroWhenSokuonInKatakana()
    {
        $result = self::$wapuro->transliterate('サッカー');
        $this->assertEquals('sakka-', $result);
    }

    public function testTransliterateToRomajiWithWapuroWhenSokuonTchInHiragana()
    {
        $result = self::$wapuro->transliterate('マッチャ');
        $this->assertEquals('maccha', $result);
    }

    public function testTransliterateToRomajiWithWapuroWhenParticles()
    {
        $result = self::$wapuro->transliterate('サッカーをやる');
        $this->assertEquals('sakka-woyaru', $result);
    }

    public function testTransliterateToRomajiWithWapuroWhenChoonpu()
    {
        $result = self::$wapuro->transliterate('パーティー');
        $this->assertEquals('pa-teli-', $result);
    }

    public function testTransliterateToRomajiWithWapuroWhenMixingHiraganaAndKatakana()
    {
        $result = self::$wapuro->transliterate('サッカー を やる');
        $this->assertEquals('sakka- wo yaru', $result);
    }

    public function testTransliterateToRomajiWithWapuroWhenNFollowedByVowel()
    {
        $result = self::$wapuro->transliterate('きんえん');
        $this->assertEquals('kinnenn', $result);
    }

    public function testTransliterateToRomajiWithWapuroWhenNFollowedByConsonant()
    {
        $result = self::$wapuro->transliterate('あんない');
        $this->assertEquals('annnai', $result);
    }

    public function testTransliterateToRomajiWithWapuroWhenPunctuationMarks()
    {
        $result = self::$wapuro->transliterate('｛｝（）［］【】、，…‥。・〽「」『』〜：！？　');
        $this->assertEquals('{}()[][], , …….-\'\'\'""~:!? ', $result);
    }

    public function testTransliterateToKanaWithDefaultParameters()
    {
        $result = self::$kana->transliterate('kuruma');
        $this->assertEquals('くるま', $result);
    }

    public function testTransliterateToKanaWithWhitespaceStripping()
    {
        $result = self::$kana->transliterate('Nagoya jō', Kana::STRIP_WHITESPACE_ALL);
        $this->assertEquals('なごやじょう', $result);
    }

    public function testTransliterateToKanaWithAutoWhitespaceStripping()
    {
        $result = self::$kana->transliterate('Nagoya jō', Kana::STRIP_WHITESPACE_AUTO);
        $this->assertEquals('なごやじょう', $result);
    }

    public function testTransliterateToKanaWithAutoWhitespaceStrippingOnLongText()
    {
        $result = self::$kana->transliterate('Nagoya ha kyōto no higashi no hou ni aru', Kana::STRIP_WHITESPACE_AUTO);
        $this->assertEquals('なごや　は　きょうと　の　ひがし　の　ほう　に　ある', $result);
    }

    public function testTransliterateToKanaUsingHiraganaInNormalCase()
    {
        $result = self::$hiragana->transliterate('kuruma');
        $this->assertEquals('くるま', $result);
    }

    public function testTransliterateToKanaUsingHiraganaWithAnEmptyString()
    {
        $result = self::$hiragana->transliterate('');
        $this->assertEquals('', $result);
    }

    public function testTransliterateToKanaUsingHiraganaWithMacron()
    {
        $result = self::$hiragana->transliterate('gakkō ni ikimasu');
        $this->assertEquals('がっこう　に　いきます', $result);
    }

    public function testTransliterateToKanaUsingHiraganaWithPunctuationMarks()
    {
        $result = self::$hiragana->transliterate('\'iie\'teiimashita');
        $this->assertEquals('「いいえ」ていいました', $result);
    }

    public function testTransliterateToKanaUsingKatakanaInNormalCase()
    {
        $result = self::$katakana->transliterate('furansu');
        $this->assertEquals('フランス', $result);
    }

    public function testTransliterateToKanaUsingKatakanaWithAnEmptyString()
    {
        $result = self::$katakana->transliterate('');
        $this->assertEquals('', $result);
    }

    public function testTransliterateToKanaUsingKatakanaWithSokuon()
    {
        $result = self::$katakana->transliterate('chakku');
        $this->assertEquals('チャック', $result);
    }

    public function testTransliterateToKanaUsingKatakanaWithChoonpu()
    {
        $result = self::$katakana->transliterate('foodo');
        $this->assertEquals('フォード', $result);
    }

    public function testTransliterateToKanaUsingKatakanaWithMacron()
    {
        $result = self::$katakana->transliterate('fōdo');
        $this->assertEquals('フォード', $result);
    }

    public function testTransliterateToKanaUsingKatakanaWithCircumflex()
    {
        $result = self::$katakana->transliterate('fôdo');
        $this->assertEquals('フォード', $result);
    }

    public function testTransliterateToKanaUsingKatakanaWithPunctuationMarks()
    {
        $result = self::$katakana->transliterate('\'iie\'teiimashita');
        $this->assertEquals('「イイエ」テイイマシタ', $result);
    }

    public function testTransliterateToKana27_1()
    {
        $result = self::$hiragana->transliterate('wha');
        $this->assertEquals('うぁ', $result);
    }

    public function testTransliterateToKana27_2()
    {
        $result = self::$katakana->transliterate('wha');
        $this->assertEquals('ウァ', $result);
    }

    public function testTransliterateToKana41_1()
    {
        $result = self::$hiragana->transliterate('JR東日本');
        $this->assertEquals('JR東日本', $result);
    }

    public function testTransliterateToKana41_2()
    {
        $result = self::$hiragana->transliterate('NHKオンライン');
        $this->assertEquals('NHKオンライン', $result);
    }

    public function testTransliterateToKana41_3()
    {
        $result = self::$hiragana->transliterate('Kuruma');
        $this->assertEquals('くるま', $result);
    }

    public function testTransliterateToKana41_4()
    {
        $result = self::$hiragana->transliterate('TOYOTA no kuruma');
        $this->assertEquals('TOYOTA　の　くるま', $result);
    }

    public function testTransliterateToKana41_5()
    {
        $result = self::$katakana->transliterate('L saizu');
        $this->assertEquals('L　サイズ', $result);
    }

    public function testTransliterateToKana41_6()
    {
        $result = self::$hiragana->transliterate('Ōsaka');
        $this->assertEquals('おうさか', $result);
    }

    public function testTransliterateToKana41_7()
    {
        $result = self::$hiragana->transliterate('Tōkyō');
        $this->assertEquals('とうきょう', $result);
    }
}
