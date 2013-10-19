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
    private $romaji;
    private $hepburn;
    private $kunrei;
    private $nihon;
    private $wapuro;
    private $kana;
    private $hiragana;
    private $katakana;

    protected function setUp()
    {
        $this->romaji = new Romaji();
        $this->hepburn = new Romaji('hepburn');
        $this->kunrei = new Romaji('kunrei');
        $this->nihon = new Romaji('nihon');
        $this->wapuro = new Romaji('wapuro');
        $this->kana = new Kana();
        $this->hiragana = new Kana('hiragana');
        $this->katakana = new Kana('katakana');
        parent::setUp();
    }

    public function testTransliterateToRomajiWithDefaultParameters()
    {
        $result = $this->romaji->transliterate('くるま');
        $this->assertEquals('kuruma', $result);
    }

    public function testTransliterateToRomajiWithDefaultParametersWhenEmptyString()
    {
        $result = $this->romaji->transliterate('');
        $this->assertEquals('', $result);
    }

    public function testTransliterateToRomajiWithHepburn()
    {
        $result = $this->hepburn->transliterate('くるま');
        $this->assertEquals('kuruma', $result);
    }

    public function testTransliterateToRomajiWithHepburnWhenLatinOnly()
    {
        $result = $this->hepburn->transliterate('yahoo YAHOO');
        $this->assertEquals('yahoo YAHOO', $result);
    }

    public function testTransliterateToRomajiWithHepburnWhenLongVowels()
    {
        $result = $this->hepburn->transliterate('がっこう');
        $this->assertEquals('gakkō', $result);
    }

    public function testTransliterateToRomajiWithHepburnWhenSokuonInHiragana()
    {
        $result = $this->hepburn->transliterate('けっか');
        $this->assertEquals('kekka', $result);
    }

    public function testTransliterateToRomajiWithHepburnWhenSokuonInKatakana()
    {
        $result = $this->hepburn->transliterate('サッカー');
        $this->assertEquals('sakkā', $result);
    }

    public function testTransliterateToRomajiWithHepburnWhenSokuonTchInHiragana()
    {
        $result = $this->hepburn->transliterate('マッチャ');
        $this->assertEquals('matcha', $result);
    }

    public function testTransliterateToRomajiWithHepburnWhenParticles()
    {
        $result = $this->hepburn->transliterate('サッカーをやる');
        $this->assertEquals('sakkāwoyaru', $result);
    }

    public function testTransliterateToRomajiWithHepburnWhenChoonpu()
    {
        $result = $this->hepburn->transliterate('パーティー');
        $this->assertEquals('pātī', $result);
    }

    public function testTransliterateToRomajiWithHepburnWhenMixingHiraganaAndKatakana()
    {
        $result = $this->hepburn->transliterate('サッカー を やる');
        $this->assertEquals('sakkā o yaru', $result);
    }

    public function testTransliterateToRomajiWithHepburnWhenNFollowedByVowel()
    {
        $result = $this->hepburn->transliterate('きんえん');
        $this->assertEquals('kin\'en', $result);
    }

    public function testTransliterateToRomajiWithHepburnWhenNFollowedByConsonant()
    {
        $result = $this->hepburn->transliterate('あんない');
        $this->assertEquals('annai', $result);
    }

    public function testTransliterateToRomajiWithHepburnWhenPunctuationMarks()
    {
        $result = $this->hepburn->transliterate('｛｝（）［］【】、，…‥。・〽「」『』〜：！？　');
        $this->assertEquals('{}()[][], , …….-\'\'\'""~:!? ', $result);
    }

    public function testTransliterateToRomajiWithKunrei()
    {
        $result = $this->kunrei->transliterate('くるま');
        $this->assertEquals('kuruma', $result);
    }

    public function testTransliterateToRomajiWithKunreiWhenLatinOnly()
    {
        $result = $this->kunrei->transliterate('yahoo YAHOO');
        $this->assertEquals('yahoo YAHOO', $result);
    }

    public function testTransliterateToRomajiWithKunreiWhenLongVowels()
    {
        $result = $this->kunrei->transliterate('がっこう');
        $this->assertEquals('gakkô', $result);
    }

    public function testTransliterateToRomajiWithKunreiWhenSSounds()
    {
        $result = $this->kunrei->transliterate('ほしい');
        $this->assertEquals('hosii', $result);
    }

    public function testTransliterateToRomajiWithKunreiWhenFuSound()
    {
        $result = $this->kunrei->transliterate('フライドポテト');
        $this->assertEquals('huraidopoteto', $result);
    }

    public function testTransliterateToRomajiWithKunreiWhenTeiSound()
    {
        $result = $this->kunrei->transliterate('ティーム');
        $this->assertEquals('tîmu', $result);
    }

    public function testTransliterateToRomajiWithKunreiWhenSokuonInHiragana()
    {
        $result = $this->kunrei->transliterate('けっか');
        $this->assertEquals('kekka', $result);
    }

    public function testTransliterateToRomajiWithKunreiWhenSokuonInKatakana()
    {
        $result = $this->kunrei->transliterate('サッカー');
        $this->assertEquals('sakkâ', $result);
    }

    public function testTransliterateToRomajiWithKunreiWhenSokuonTchInHiragana()
    {
        $result = $this->kunrei->transliterate('マッチャ');
        $this->assertEquals('mattya', $result);
    }

    public function testTransliterateToRomajiWithKunreiWhenParticles()
    {
        $result = $this->kunrei->transliterate('サッカーをやる');
        $this->assertEquals('sakkâwoyaru', $result);
    }

    public function testTransliterateToRomajiWithKunreiWhenChoonpu()
    {
        $result = $this->kunrei->transliterate('パーティー');
        $this->assertEquals('pâtî', $result);
    }

    public function testTransliterateToRomajiWithKunreiWhenMixingHiraganaAndKatakana()
    {
        $result = $this->kunrei->transliterate('サッカー を やる');
        $this->assertEquals('sakkâ o yaru', $result);
    }

    public function testTransliterateToRomajiWithKunreiWhenNFollowedByVowel()
    {
        $result = $this->kunrei->transliterate('きんえん');
        $this->assertEquals('kin\'en', $result);
    }

    public function testTransliterateToRomajiWithKunreiWhenNFollowedByConsonant()
    {
        $result = $this->kunrei->transliterate('あんない');
        $this->assertEquals('annai', $result);
    }

    public function testTransliterateToRomajiWithKunreiWhenPunctuationMarks()
    {
        $result = $this->kunrei->transliterate('｛｝（）［］【】、，…‥。・〽「」『』〜：！？　');
        $this->assertEquals('{}()[][], , …….-\'\'\'""~:!? ', $result);
    }
    public function testTransliterateToRomajiWithNihon()
    {
        $result = $this->nihon->transliterate('くるま');
        $this->assertEquals('kuruma', $result);
    }

    public function testTransliterateToRomajiWithNihonWhenLatinOnly()
    {
        $result = $this->nihon->transliterate('yahoo YAHOO');
        $this->assertEquals('yahoo YAHOO', $result);
    }

    public function testTransliterateToRomajiWithNihonWhenLongVowels()
    {
        $result = $this->nihon->transliterate('がっこう');
        $this->assertEquals('gakkô', $result);
    }

    public function testTransliterateToRomajiWithNihonWhenSSounds()
    {
        $result = $this->nihon->transliterate('ほしい');
        $this->assertEquals('hosii', $result);
    }

    public function testTransliterateToRomajiWithNihonWhenDuSound()
    {
        $result = $this->nihon->transliterate('かなづかい');
        $this->assertEquals('kanadukai', $result);
    }

    public function testTransliterateToRomajiWithNihonWhenSokuonInHiragana()
    {
        $result = $this->nihon->transliterate('けっか');
        $this->assertEquals('kekka', $result);
    }

    public function testTransliterateToRomajiWithNihonWhenSokuonInKatakana()
    {
        $result = $this->nihon->transliterate('サッカー');
        $this->assertEquals('sakkâ', $result);
    }

    public function testTransliterateToRomajiWithNihonWhenSokuonTchInHiragana()
    {
        $result = $this->nihon->transliterate('マッチャ');
        $this->assertEquals('mattya', $result);
    }

    public function testTransliterateToRomajiWithNihonWhenParticles()
    {
        $result = $this->nihon->transliterate('サッカーをやる');
        $this->assertEquals('sakkâwoyaru', $result);
    }

    public function testTransliterateToRomajiWithNihonWhenChoonpu()
    {
        $result = $this->nihon->transliterate('パーティー');
        $this->assertEquals('pâtî', $result);
    }

    public function testTransliterateToRomajiWithNihonWhenMixingHiraganaAndKatakana()
    {
        $result = $this->nihon->transliterate('サッカー を やる');
        $this->assertEquals('sakkâ wo yaru', $result);
    }

    public function testTransliterateToRomajiWithNihonWhenNFollowedByVowel()
    {
        $result = $this->nihon->transliterate('きんえん');
        $this->assertEquals('kin\'en', $result);
    }

    public function testTransliterateToRomajiWithNihonWhenNFollowedByConsonant()
    {
        $result = $this->nihon->transliterate('あんない');
        $this->assertEquals('annai', $result);
    }

    public function testTransliterateToRomajiWithNihonWhenPunctuationMarks()
    {
        $result = $this->nihon->transliterate('｛｝（）［］【】、，…‥。・〽「」『』〜：！？　');
        $this->assertEquals('{}()[][], , …….-\'\'\'""~:!? ', $result);
    }

    public function testTransliterateToRomajiWithWapuro()
    {
        $result = $this->wapuro->transliterate('くるま');
        $this->assertEquals('kuruma', $result);
    }

    public function testTransliterateToRomajiWithWapuroWhenLatinOnly()
    {
        $result = $this->wapuro->transliterate('yahoo YAHOO');
        $this->assertEquals('yahoo YAHOO', $result);
    }

    public function testTransliterateToRomajiWithWapuroWhenLongVowels()
    {
        $result = $this->wapuro->transliterate('がっこう');
        $this->assertEquals('gakkou', $result);
    }

    public function testTransliterateToRomajiWithWapuroWhenSokuonInHiragana()
    {
        $result = $this->wapuro->transliterate('けっか');
        $this->assertEquals('kekka', $result);
    }

    public function testTransliterateToRomajiWithWapuroWhenSokuonInKatakana()
    {
        $result = $this->wapuro->transliterate('サッカー');
        $this->assertEquals('sakka-', $result);
    }

    public function testTransliterateToRomajiWithWapuroWhenSokuonTchInHiragana()
    {
        $result = $this->wapuro->transliterate('マッチャ');
        $this->assertEquals('maccha', $result);
    }

    public function testTransliterateToRomajiWithWapuroWhenParticles()
    {
        $result = $this->wapuro->transliterate('サッカーをやる');
        $this->assertEquals('sakka-woyaru', $result);
    }

    public function testTransliterateToRomajiWithWapuroWhenChoonpu()
    {
        $result = $this->wapuro->transliterate('パーティー');
        $this->assertEquals('pa-teli-', $result);
    }

    public function testTransliterateToRomajiWithWapuroWhenMixingHiraganaAndKatakana()
    {
        $result = $this->wapuro->transliterate('サッカー を やる');
        $this->assertEquals('sakka- wo yaru', $result);
    }

    public function testTransliterateToRomajiWithWapuroWhenNFollowedByVowel()
    {
        $result = $this->wapuro->transliterate('きんえん');
        $this->assertEquals('kinnenn', $result);
    }

    public function testTransliterateToRomajiWithWapuroWhenNFollowedByConsonant()
    {
        $result = $this->wapuro->transliterate('あんない');
        $this->assertEquals('annnai', $result);
    }

    public function testTransliterateToRomajiWithWapuroWhenPunctuationMarks()
    {
        $result = $this->wapuro->transliterate('｛｝（）［］【】、，…‥。・〽「」『』〜：！？　');
        $this->assertEquals('{}()[][], , …….-\'\'\'""~:!? ', $result);
    }

    public function testTransliterateToKanaWithDefaultParameters()
    {
        $result = $this->kana->transliterate('kuruma');
        $this->assertEquals('くるま', $result);
    }

    public function testTransliterateToKanaUsingHiraganaInNormalCase()
    {
        $result = $this->hiragana->transliterate('kuruma');
        $this->assertEquals('くるま', $result);
    }

    public function testTransliterateToKanaUsingHiraganaWithAnEmptyString()
    {
        $result = $this->hiragana->transliterate('');
        $this->assertEquals('', $result);
    }

    public function testTransliterateToKanaUsingHiraganaWithMacron()
    {
        $result = $this->hiragana->transliterate('gakkō ni ikimasu');
        $this->assertEquals('がっこう　に　いきます', $result);
    }

    public function testTransliterateToKanaUsingHiraganaWithPunctuationMarks()
    {
        $result = $this->hiragana->transliterate('\'iie\'teiimashita');
        $this->assertEquals('「いいえ」ていいました', $result);
    }

    public function testTransliterateToKanaUsingKatakanaInNormalCase()
    {
        $result = $this->katakana->transliterate('furansu');
        $this->assertEquals('フランス', $result);
    }

    public function testTransliterateToKanaUsingKatakanaWithAnEmptyString()
    {
        $result = $this->katakana->transliterate('');
        $this->assertEquals('', $result);
    }

    public function testTransliterateToKanaUsingKatakanaWithSokuon()
    {
        $result = $this->katakana->transliterate('chakku');
        $this->assertEquals('チャック', $result);
    }

    public function testTransliterateToKanaUsingKatakanaWithChoonpu()
    {
        $result = $this->katakana->transliterate('foodo');
        $this->assertEquals('フォード', $result);
    }

    public function testTransliterateToKanaUsingKatakanaWithMacron()
    {
        $result = $this->katakana->transliterate('fōdo');
        $this->assertEquals('フォード', $result);
    }

    public function testTransliterateToKanaUsingKatakanaWithCircumflex()
    {
        $result = $this->katakana->transliterate('fôdo');
        $this->assertEquals('フォード', $result);
    }

    public function testTransliterateToKanaUsingKatakanaWithPunctuationMarks()
    {
        $result = $this->katakana->transliterate('\'iie\'teiimashita');
        $this->assertEquals('「イイエ」テイイマシタ', $result);
    }
    
    public function testTransliterateToKana27_1()
    {
        $result = $this->hiragana->transliterate('wha');
        $this->assertEquals('うぁ', $result);
    }
    
    public function testTransliterateToKana27_2()
    {
        $result = $this->katakana->transliterate('wha');
        $this->assertEquals('ウァ', $result);
    }
}
