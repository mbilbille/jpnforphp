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
        $this->assertEquals($result, 'kuruma');
    }

    public function testToRomajiWithDefaultParametersWhenEmptyString()
    {
        $result = Transliterator::toRomaji('');
        $this->assertEquals($result, '');
    }

    public function testToRomajiWithHepburn()
    {
        $result = Transliterator::toRomaji('くるま', NULL, $this->hepburn);
        $this->assertEquals($result, 'kuruma');
    }

    public function testToRomajiWithHepburnWhenLatinOnly()
    {
        $result = Transliterator::toRomaji('yahoo YAHOO', NULL, $this->hepburn);
        $this->assertEquals($result, 'yahoo YAHOO');
    }

    public function testToRomajiWithHepburnWhenLongVowels()
    {
        $result = Transliterator::toRomaji('がっこう', NULL, $this->hepburn);
        $this->assertEquals($result, 'gakkō');
    }

    public function testToRomajiWithHepburnWhenSokuonInHiragana()
    {
        $result = Transliterator::toRomaji('けっか', NULL, $this->hepburn);
        $this->assertEquals($result, 'kekka');
    }

    public function testToRomajiWithHepburnWhenSokuonInKatakana()
    {
        $result = Transliterator::toRomaji('サッカー', NULL, $this->hepburn);
        $this->assertEquals($result, 'sakkā');
    }

    public function testToRomajiWithHepburnWhenSokuonTchInHiragana()
    {
        $result = Transliterator::toRomaji('マッチャ', NULL, $this->hepburn);
        $this->assertEquals($result, 'matcha');
    }

    public function testToRomajiWithHepburnWhenParticles()
    {
        $result = Transliterator::toRomaji('サッカーをやる', NULL, $this->hepburn);
        $this->assertEquals($result, 'sakkāwoyaru');
    }

    public function testToRomajiWithHepburnWhenChoonpu()
    {
        $result = Transliterator::toRomaji('パーティー', NULL, $this->hepburn);
        $this->assertEquals($result, 'pātī');
    }

    public function testToRomajiWithHepburnWhenMixingHiraganaAndKatakana()
    {
        $result = Transliterator::toRomaji('サッカー を やる', NULL, $this->hepburn);
        $this->assertEquals($result, 'sakkā o yaru');
    }

    public function testToRomajiWithHepburnWhenNFollowedByVowel()
    {
        $result = Transliterator::toRomaji('きんえん', NULL, $this->hepburn);
        $this->assertEquals($result, 'kin\'en');
    }

    public function testToRomajiWithHepburnWhenNFollowedByConsonant()
    {
        $result = Transliterator::toRomaji('あんない', NULL, $this->hepburn);
        $this->assertEquals($result, 'annai');
    }

    public function testToRomajiWithHepburnWhenPunctuationMarks()
    {
        $result = Transliterator::toRomaji('｛｝（）［］【】、，…‥。・〽「」『』〜：！？　', NULL, $this->hepburn);
        $this->assertEquals($result, '{}()[][], , …….-\'\'\'""~:!? ');
    }

    public function testToRomajiWithKunrei()
    {
        $result = Transliterator::toRomaji('くるま', NULL, $this->kunrei);
        $this->assertEquals($result, 'kuruma');
    }

    public function testToRomajiWithKunreiWhenLatinOnly()
    {
        $result = Transliterator::toRomaji('yahoo YAHOO', NULL, $this->kunrei);
        $this->assertEquals($result, 'yahoo YAHOO');
    }

    public function testToRomajiWithKunreiWhenLongVowels()
    {
        $result = Transliterator::toRomaji('がっこう', NULL, $this->kunrei);
        $this->assertEquals($result, 'gakkô');
    }

    public function testToRomajiWithKunreiWhenSSounds()
    {
        $result = Transliterator::toRomaji('ほしい', NULL, $this->kunrei);
        $this->assertEquals($result, 'hosii');
    }

    public function testToRomajiWithKunreiWhenFuSound()
    {
        $result = Transliterator::toRomaji('フライドポテト', NULL, $this->kunrei);
        $this->assertEquals($result, 'huraidopoteto');
    }

    public function testToRomajiWithKunreiWhenTeiSound()
    {
        $result = Transliterator::toRomaji('ティーム', NULL, $this->kunrei);
        $this->assertEquals($result, 'tîmu');
    }

    public function testToRomajiWithKunreiWhenSokuonInHiragana()
    {
        $result = Transliterator::toRomaji('けっか', NULL, $this->kunrei);
        $this->assertEquals($result, 'kekka');
    }

    public function testToRomajiWithKunreiWhenSokuonInKatakana()
    {
        $result = Transliterator::toRomaji('サッカー', NULL, $this->kunrei);
        $this->assertEquals($result, 'sakkâ');
    }

    public function testToRomajiWithKunreiWhenSokuonTchInHiragana()
    {
        $result = Transliterator::toRomaji('マッチャ', NULL, $this->kunrei);
        $this->assertEquals($result, 'mattya');
    }

    public function testToRomajiWithKunreiWhenParticles()
    {
        $result = Transliterator::toRomaji('サッカーをやる', NULL, $this->kunrei);
        $this->assertEquals($result, 'sakkâwoyaru');
    }

    public function testToRomajiWithKunreiWhenChoonpu()
    {
        $result = Transliterator::toRomaji('パーティー', NULL, $this->kunrei);
        $this->assertEquals($result, 'pâtî');
    }

    public function testToRomajiWithKunreiWhenMixingHiraganaAndKatakana()
    {
        $result = Transliterator::toRomaji('サッカー を やる', NULL, $this->kunrei);
        $this->assertEquals($result, 'sakkâ o yaru');
    }

    public function testToRomajiWithKunreiWhenNFollowedByVowel()
    {
        $result = Transliterator::toRomaji('きんえん', NULL, $this->kunrei);
        $this->assertEquals($result, 'kin\'en');
    }

    public function testToRomajiWithKunreiWhenNFollowedByConsonant()
    {
        $result = Transliterator::toRomaji('あんない', NULL, $this->kunrei);
        $this->assertEquals($result, 'annai');
    }

    public function testToRomajiWithKunreiWhenPunctuationMarks()
    {
        $result = Transliterator::toRomaji('｛｝（）［］【】、，…‥。・〽「」『』〜：！？　', NULL, $this->kunrei);
        $this->assertEquals($result, '{}()[][], , …….-\'\'\'""~:!? ');
    }
    public function testToRomajiWithNihon()
    {
        $result = Transliterator::toRomaji('くるま', NULL, $this->nihon);
        $this->assertEquals($result, 'kuruma');
    }

    public function testToRomajiWithNihonWhenLatinOnly()
    {
        $result = Transliterator::toRomaji('yahoo YAHOO', NULL, $this->nihon);
        $this->assertEquals($result, 'yahoo YAHOO');
    }

    public function testToRomajiWithNihonWhenLongVowels()
    {
        $result = Transliterator::toRomaji('がっこう', NULL, $this->nihon);
        $this->assertEquals($result, 'gakkô');
    }

    public function testToRomajiWithNihonWhenSSounds()
    {
        $result = Transliterator::toRomaji('ほしい', NULL, $this->nihon);
        $this->assertEquals($result, 'hosii');
    }

    public function testToRomajiWithNihonWhenDuSound()
    {
        $result = Transliterator::toRomaji('かなづかい', NULL, $this->nihon);
        $this->assertEquals($result, 'kanadukai');
    }

    public function testToRomajiWithNihonWhenSokuonInHiragana()
    {
        $result = Transliterator::toRomaji('けっか', NULL, $this->nihon);
        $this->assertEquals($result, 'kekka');
    }

    public function testToRomajiWithNihonWhenSokuonInKatakana()
    {
        $result = Transliterator::toRomaji('サッカー', NULL, $this->nihon);
        $this->assertEquals($result, 'sakkâ');
    }

    public function testToRomajiWithNihonWhenSokuonTchInHiragana()
    {
        $result = Transliterator::toRomaji('マッチャ', NULL, $this->nihon);
        $this->assertEquals($result, 'mattya');
    }

    public function testToRomajiWithNihonWhenParticles()
    {
        $result = Transliterator::toRomaji('サッカーをやる', NULL, $this->nihon);
        $this->assertEquals($result, 'sakkâwoyaru');
    }

    public function testToRomajiWithNihonWhenChoonpu()
    {
        $result = Transliterator::toRomaji('パーティー', NULL, $this->nihon);
        $this->assertEquals($result, 'pâtî');
    }

    public function testToRomajiWithNihonWhenMixingHiraganaAndKatakana()
    {
        $result = Transliterator::toRomaji('サッカー を やる', NULL, $this->nihon);
        $this->assertEquals($result, 'sakkâ wo yaru');
    }

    public function testToRomajiWithNihonWhenNFollowedByVowel()
    {
        $result = Transliterator::toRomaji('きんえん', NULL, $this->nihon);
        $this->assertEquals($result, 'kin\'en');
    }

    public function testToRomajiWithNihonWhenNFollowedByConsonant()
    {
        $result = Transliterator::toRomaji('あんない', NULL, $this->nihon);
        $this->assertEquals($result, 'annai');
    }

    public function testToRomajiWithNihonWhenPunctuationMarks()
    {
        $result = Transliterator::toRomaji('｛｝（）［］【】、，…‥。・〽「」『』〜：！？　', NULL, $this->nihon);
        $this->assertEquals($result, '{}()[][], , …….-\'\'\'""~:!? ');
    }
}