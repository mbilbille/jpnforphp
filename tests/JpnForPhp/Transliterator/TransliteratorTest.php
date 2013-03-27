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

use JpnForPhp\Transliterator\Transliterator;
use JpnForPhp\Transliterator\Hepburn;
use JpnForPhp\Transliterator\Kunrei;
use JpnForPhp\Transliterator\Nihon;

/**
 * JpnForPhp Testcase for Transliterator component
 */
class TransliteratorTest extends \PHPUnit_Framework_TestCase
{
    private $hepburn;
    private $kunrei;
    private $nihon;

    protected function setUp()
    {
        $this->hepburn = new Hepburn();
        $this->kunrei = new Kunrei();
        $this->nihon = new Nihon();
        parent::setUp();
    }

    public function testToRomajiWithDefaultParameters()
    {
        $result = Transliterator::toRomaji('くるま');
        $this->assertEquals('kuruma', $result);
    }

    public function testToRomajiWithDefaultParametersWhenEmptyString()
    {
        $result = Transliterator::toRomaji('');
        $this->assertEquals('', $result);
    }

    public function testToRomajiWithHepburn()
    {
        $result = Transliterator::toRomaji('くるま', NULL, $this->hepburn);
        $this->assertEquals('kuruma', $result);
    }

    public function testToRomajiWithHepburnWhenLatinOnly()
    {
        $result = Transliterator::toRomaji('yahoo YAHOO', NULL, $this->hepburn);
        $this->assertEquals('yahoo YAHOO', $result);
    }

    public function testToRomajiWithHepburnWhenLongVowels()
    {
        $result = Transliterator::toRomaji('がっこう', NULL, $this->hepburn);
        $this->assertEquals('gakkō', $result);
    }

    public function testToRomajiWithHepburnWhenSokuonInHiragana()
    {
        $result = Transliterator::toRomaji('けっか', NULL, $this->hepburn);
        $this->assertEquals('kekka', $result);
    }

    public function testToRomajiWithHepburnWhenSokuonInKatakana()
    {
        $result = Transliterator::toRomaji('サッカー', NULL, $this->hepburn);
        $this->assertEquals('sakkā', $result);
    }

    public function testToRomajiWithHepburnWhenSokuonTchInHiragana()
    {
        $result = Transliterator::toRomaji('マッチャ', NULL, $this->hepburn);
        $this->assertEquals('matcha', $result);
    }

    public function testToRomajiWithHepburnWhenParticles()
    {
        $result = Transliterator::toRomaji('サッカーをやる', NULL, $this->hepburn);
        $this->assertEquals('sakkāwoyaru', $result);
    }

    public function testToRomajiWithHepburnWhenChoonpu()
    {
        $result = Transliterator::toRomaji('パーティー', NULL, $this->hepburn);
        $this->assertEquals('pātī', $result);
    }

    public function testToRomajiWithHepburnWhenMixingHiraganaAndKatakana()
    {
        $result = Transliterator::toRomaji('サッカー を やる', NULL, $this->hepburn);
        $this->assertEquals('sakkā o yaru', $result);
    }

    public function testToRomajiWithHepburnWhenNFollowedByVowel()
    {
        $result = Transliterator::toRomaji('きんえん', NULL, $this->hepburn);
        $this->assertEquals('kin\'en', $result);
    }

    public function testToRomajiWithHepburnWhenNFollowedByConsonant()
    {
        $result = Transliterator::toRomaji('あんない', NULL, $this->hepburn);
        $this->assertEquals('annai', $result);
    }

    public function testToRomajiWithHepburnWhenPunctuationMarks()
    {
        $result = Transliterator::toRomaji('｛｝（）［］【】、，…‥。・〽「」『』〜：！？　', NULL, $this->hepburn);
        $this->assertEquals('{}()[][], , …….-\'\'\'""~:!? ', $result);
    }

    public function testToRomajiWithKunrei()
    {
        $result = Transliterator::toRomaji('くるま', NULL, $this->kunrei);
        $this->assertEquals('kuruma', $result);
    }

    public function testToRomajiWithKunreiWhenLatinOnly()
    {
        $result = Transliterator::toRomaji('yahoo YAHOO', NULL, $this->kunrei);
        $this->assertEquals('yahoo YAHOO', $result);
    }

    public function testToRomajiWithKunreiWhenLongVowels()
    {
        $result = Transliterator::toRomaji('がっこう', NULL, $this->kunrei);
        $this->assertEquals('gakkô', $result);
    }

    public function testToRomajiWithKunreiWhenSSounds()
    {
        $result = Transliterator::toRomaji('ほしい', NULL, $this->kunrei);
        $this->assertEquals('hosii', $result);
    }

    public function testToRomajiWithKunreiWhenFuSound()
    {
        $result = Transliterator::toRomaji('フライドポテト', NULL, $this->kunrei);
        $this->assertEquals('huraidopoteto', $result);
    }

    public function testToRomajiWithKunreiWhenTeiSound()
    {
        $result = Transliterator::toRomaji('ティーム', NULL, $this->kunrei);
        $this->assertEquals('tîmu', $result);
    }

    public function testToRomajiWithKunreiWhenSokuonInHiragana()
    {
        $result = Transliterator::toRomaji('けっか', NULL, $this->kunrei);
        $this->assertEquals('kekka', $result);
    }

    public function testToRomajiWithKunreiWhenSokuonInKatakana()
    {
        $result = Transliterator::toRomaji('サッカー', NULL, $this->kunrei);
        $this->assertEquals('sakkâ', $result);
    }

    public function testToRomajiWithKunreiWhenSokuonTchInHiragana()
    {
        $result = Transliterator::toRomaji('マッチャ', NULL, $this->kunrei);
        $this->assertEquals('mattya', $result);
    }

    public function testToRomajiWithKunreiWhenParticles()
    {
        $result = Transliterator::toRomaji('サッカーをやる', NULL, $this->kunrei);
        $this->assertEquals('sakkâwoyaru', $result);
    }

    public function testToRomajiWithKunreiWhenChoonpu()
    {
        $result = Transliterator::toRomaji('パーティー', NULL, $this->kunrei);
        $this->assertEquals('pâtî', $result);
    }

    public function testToRomajiWithKunreiWhenMixingHiraganaAndKatakana()
    {
        $result = Transliterator::toRomaji('サッカー を やる', NULL, $this->kunrei);
        $this->assertEquals('sakkâ o yaru', $result);
    }

    public function testToRomajiWithKunreiWhenNFollowedByVowel()
    {
        $result = Transliterator::toRomaji('きんえん', NULL, $this->kunrei);
        $this->assertEquals('kin\'en', $result);
    }

    public function testToRomajiWithKunreiWhenNFollowedByConsonant()
    {
        $result = Transliterator::toRomaji('あんない', NULL, $this->kunrei);
        $this->assertEquals('annai', $result);
    }

    public function testToRomajiWithKunreiWhenPunctuationMarks()
    {
        $result = Transliterator::toRomaji('｛｝（）［］【】、，…‥。・〽「」『』〜：！？　', NULL, $this->kunrei);
        $this->assertEquals('{}()[][], , …….-\'\'\'""~:!? ', $result);
    }
    public function testToRomajiWithNihon()
    {
        $result = Transliterator::toRomaji('くるま', NULL, $this->nihon);
        $this->assertEquals('kuruma', $result);
    }

    public function testToRomajiWithNihonWhenLatinOnly()
    {
        $result = Transliterator::toRomaji('yahoo YAHOO', NULL, $this->nihon);
        $this->assertEquals('yahoo YAHOO', $result);
    }

    public function testToRomajiWithNihonWhenLongVowels()
    {
        $result = Transliterator::toRomaji('がっこう', NULL, $this->nihon);
        $this->assertEquals('gakkô', $result);
    }

    public function testToRomajiWithNihonWhenSSounds()
    {
        $result = Transliterator::toRomaji('ほしい', NULL, $this->nihon);
        $this->assertEquals('hosii', $result);
    }

    public function testToRomajiWithNihonWhenDuSound()
    {
        $result = Transliterator::toRomaji('かなづかい', NULL, $this->nihon);
        $this->assertEquals('kanadukai', $result);
    }

    public function testToRomajiWithNihonWhenSokuonInHiragana()
    {
        $result = Transliterator::toRomaji('けっか', NULL, $this->nihon);
        $this->assertEquals('kekka', $result);
    }

    public function testToRomajiWithNihonWhenSokuonInKatakana()
    {
        $result = Transliterator::toRomaji('サッカー', NULL, $this->nihon);
        $this->assertEquals('sakkâ', $result);
    }

    public function testToRomajiWithNihonWhenSokuonTchInHiragana()
    {
        $result = Transliterator::toRomaji('マッチャ', NULL, $this->nihon);
        $this->assertEquals('mattya', $result);
    }

    public function testToRomajiWithNihonWhenParticles()
    {
        $result = Transliterator::toRomaji('サッカーをやる', NULL, $this->nihon);
        $this->assertEquals('sakkâwoyaru', $result);
    }

    public function testToRomajiWithNihonWhenChoonpu()
    {
        $result = Transliterator::toRomaji('パーティー', NULL, $this->nihon);
        $this->assertEquals('pâtî', $result);
    }

    public function testToRomajiWithNihonWhenMixingHiraganaAndKatakana()
    {
        $result = Transliterator::toRomaji('サッカー を やる', NULL, $this->nihon);
        $this->assertEquals('sakkâ wo yaru', $result);
    }

    public function testToRomajiWithNihonWhenNFollowedByVowel()
    {
        $result = Transliterator::toRomaji('きんえん', NULL, $this->nihon);
        $this->assertEquals('kin\'en', $result);
    }

    public function testToRomajiWithNihonWhenNFollowedByConsonant()
    {
        $result = Transliterator::toRomaji('あんない', NULL, $this->nihon);
        $this->assertEquals('annai', $result);
    }

    public function testToRomajiWithNihonWhenPunctuationMarks()
    {
        $result = Transliterator::toRomaji('｛｝（）［］【】、，…‥。・〽「」『』〜：！？　', NULL, $this->nihon);
        $this->assertEquals('{}()[][], , …….-\'\'\'""~:!? ', $result);
    }

    public function testToKanaUsingHiraganaInNormalCase()
    {
        $result = Transliterator::toKana('kuruma', Transliterator::HIRAGANA);
        $this->assertEquals('くるま', $result);
    }

    public function testToKanaUsingHiraganaWithAnEmptyString()
    {
        $result = Transliterator::toKana('', Transliterator::HIRAGANA);
        $this->assertEquals('', $result);
    }

    public function testToKanaUsingHiraganaWithMacron()
    {
        $result = Transliterator::toKana('gakkō ni ikimasu', Transliterator::HIRAGANA);
        $this->assertEquals('がっこう　に　いきます', $result);
    }

    public function testToKanaUsingHiraganaWithPunctuationMarks()
    {
        $result = Transliterator::toKana('\'iie\'teiimashita', Transliterator::HIRAGANA);
        $this->assertEquals('「いいえ」ていいました', $result);
    }

    public function testToKanaUsingKatakanaInNormalCase()
    {
        $result = Transliterator::toKana('furansu', Transliterator::KATAKANA);
        $this->assertEquals('フランス', $result);
    }

    public function testToKanaUsingKatakanaWithAnEmptyString()
    {
        $result = Transliterator::toKana('', Transliterator::KATAKANA);
        $this->assertEquals('', $result);
    }

    public function testToKanaUsingKatakanaWithSokuon()
    {
        $result = Transliterator::toKana('chakku', Transliterator::KATAKANA);
        $this->assertEquals('チャック', $result);
    }

    public function testToKanaUsingKatakanaWithChoonpu()
    {
        $result = Transliterator::toKana('foodo', Transliterator::KATAKANA);
        $this->assertEquals('フォード', $result);
    }

    public function testToKanaUsingKatakanaWithMacron()
    {
        $result = Transliterator::toKana('fōdo', Transliterator::KATAKANA);
        $this->assertEquals('フォード', $result);
    }

    public function testToKanaUsingKatakanaWithCircumflex()
    {
        $result = Transliterator::toKana('fôdo', Transliterator::KATAKANA);
        $this->assertEquals('フォード', $result);
    }

    public function testToKanaUsingKatakanaWithPunctuationMarks()
    {
        $result = Transliterator::toKana('\'iie\'teiimashita', Transliterator::KATAKANA);
        $this->assertEquals('「イイエ」テイイマシタ', $result);
    }
}
