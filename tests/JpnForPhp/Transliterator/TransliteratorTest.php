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
use JpnForPhp\Transliterator\Wapuro;

/**
 * JpnForPhp Testcase for Transliterator component
 */
class TransliteratorTest extends \PHPUnit_Framework_TestCase
{
    private $hepburn;
    private $kunrei;
    private $nihon;
    private $wapuro;

    protected function setUp()
    {
        $this->hepburn = new Hepburn();
        $this->kunrei = new Kunrei();
        $this->nihon = new Nihon();
        $this->wapuro = new Wapuro();
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
        $result = Transliterator::toRomaji('くるま', $this->hepburn);
        $this->assertEquals('kuruma', $result);
    }

    public function testToRomajiWithHepburnWhenLatinOnly()
    {
        $result = Transliterator::toRomaji('yahoo YAHOO', $this->hepburn);
        $this->assertEquals('yahoo YAHOO', $result);
    }

    public function testToRomajiWithHepburnWhenLongVowels()
    {
        $result = Transliterator::toRomaji('がっこう', $this->hepburn);
        $this->assertEquals('gakkō', $result);
    }

    public function testToRomajiWithHepburnWhenSokuonInHiragana()
    {
        $result = Transliterator::toRomaji('けっか', $this->hepburn);
        $this->assertEquals('kekka', $result);
    }

    public function testToRomajiWithHepburnWhenSokuonInKatakana()
    {
        $result = Transliterator::toRomaji('サッカー', $this->hepburn);
        $this->assertEquals('sakkā', $result);
    }

    public function testToRomajiWithHepburnWhenSokuonTchInHiragana()
    {
        $result = Transliterator::toRomaji('マッチャ', $this->hepburn);
        $this->assertEquals('matcha', $result);
    }

    public function testToRomajiWithHepburnWhenParticles()
    {
        $result = Transliterator::toRomaji('サッカーをやる', $this->hepburn);
        $this->assertEquals('sakkāwoyaru', $result);
    }

    public function testToRomajiWithHepburnWhenChoonpu()
    {
        $result = Transliterator::toRomaji('パーティー', $this->hepburn);
        $this->assertEquals('pātī', $result);
    }

    public function testToRomajiWithHepburnWhenMixingHiraganaAndKatakana()
    {
        $result = Transliterator::toRomaji('サッカー を やる', $this->hepburn);
        $this->assertEquals('sakkā o yaru', $result);
    }

    public function testToRomajiWithHepburnWhenNFollowedByVowel()
    {
        $result = Transliterator::toRomaji('きんえん', $this->hepburn);
        $this->assertEquals('kin\'en', $result);
    }

    public function testToRomajiWithHepburnWhenNFollowedByConsonant()
    {
        $result = Transliterator::toRomaji('あんない', $this->hepburn);
        $this->assertEquals('annai', $result);
    }

    public function testToRomajiWithHepburnWhenPunctuationMarks()
    {
        $result = Transliterator::toRomaji('｛｝（）［］【】、，…‥。・〽「」『』〜：！？　', $this->hepburn);
        $this->assertEquals('{}()[][], , …….-\'\'\'""~:!? ', $result);
    }

    public function testToRomajiWithKunrei()
    {
        $result = Transliterator::toRomaji('くるま', $this->kunrei);
        $this->assertEquals('kuruma', $result);
    }

    public function testToRomajiWithKunreiWhenLatinOnly()
    {
        $result = Transliterator::toRomaji('yahoo YAHOO', $this->kunrei);
        $this->assertEquals('yahoo YAHOO', $result);
    }

    public function testToRomajiWithKunreiWhenLongVowels()
    {
        $result = Transliterator::toRomaji('がっこう', $this->kunrei);
        $this->assertEquals('gakkô', $result);
    }

    public function testToRomajiWithKunreiWhenSSounds()
    {
        $result = Transliterator::toRomaji('ほしい', $this->kunrei);
        $this->assertEquals('hosii', $result);
    }

    public function testToRomajiWithKunreiWhenFuSound()
    {
        $result = Transliterator::toRomaji('フライドポテト', $this->kunrei);
        $this->assertEquals('huraidopoteto', $result);
    }

    public function testToRomajiWithKunreiWhenTeiSound()
    {
        $result = Transliterator::toRomaji('ティーム', $this->kunrei);
        $this->assertEquals('tîmu', $result);
    }

    public function testToRomajiWithKunreiWhenSokuonInHiragana()
    {
        $result = Transliterator::toRomaji('けっか', $this->kunrei);
        $this->assertEquals('kekka', $result);
    }

    public function testToRomajiWithKunreiWhenSokuonInKatakana()
    {
        $result = Transliterator::toRomaji('サッカー', $this->kunrei);
        $this->assertEquals('sakkâ', $result);
    }

    public function testToRomajiWithKunreiWhenSokuonTchInHiragana()
    {
        $result = Transliterator::toRomaji('マッチャ', $this->kunrei);
        $this->assertEquals('mattya', $result);
    }

    public function testToRomajiWithKunreiWhenParticles()
    {
        $result = Transliterator::toRomaji('サッカーをやる', $this->kunrei);
        $this->assertEquals('sakkâwoyaru', $result);
    }

    public function testToRomajiWithKunreiWhenChoonpu()
    {
        $result = Transliterator::toRomaji('パーティー', $this->kunrei);
        $this->assertEquals('pâtî', $result);
    }

    public function testToRomajiWithKunreiWhenMixingHiraganaAndKatakana()
    {
        $result = Transliterator::toRomaji('サッカー を やる', $this->kunrei);
        $this->assertEquals('sakkâ o yaru', $result);
    }

    public function testToRomajiWithKunreiWhenNFollowedByVowel()
    {
        $result = Transliterator::toRomaji('きんえん', $this->kunrei);
        $this->assertEquals('kin\'en', $result);
    }

    public function testToRomajiWithKunreiWhenNFollowedByConsonant()
    {
        $result = Transliterator::toRomaji('あんない', $this->kunrei);
        $this->assertEquals('annai', $result);
    }

    public function testToRomajiWithKunreiWhenPunctuationMarks()
    {
        $result = Transliterator::toRomaji('｛｝（）［］【】、，…‥。・〽「」『』〜：！？　', $this->kunrei);
        $this->assertEquals('{}()[][], , …….-\'\'\'""~:!? ', $result);
    }
    public function testToRomajiWithNihon()
    {
        $result = Transliterator::toRomaji('くるま', $this->nihon);
        $this->assertEquals('kuruma', $result);
    }

    public function testToRomajiWithNihonWhenLatinOnly()
    {
        $result = Transliterator::toRomaji('yahoo YAHOO', $this->nihon);
        $this->assertEquals('yahoo YAHOO', $result);
    }

    public function testToRomajiWithNihonWhenLongVowels()
    {
        $result = Transliterator::toRomaji('がっこう', $this->nihon);
        $this->assertEquals('gakkô', $result);
    }

    public function testToRomajiWithNihonWhenSSounds()
    {
        $result = Transliterator::toRomaji('ほしい', $this->nihon);
        $this->assertEquals('hosii', $result);
    }

    public function testToRomajiWithNihonWhenDuSound()
    {
        $result = Transliterator::toRomaji('かなづかい', $this->nihon);
        $this->assertEquals('kanadukai', $result);
    }

    public function testToRomajiWithNihonWhenSokuonInHiragana()
    {
        $result = Transliterator::toRomaji('けっか', $this->nihon);
        $this->assertEquals('kekka', $result);
    }

    public function testToRomajiWithNihonWhenSokuonInKatakana()
    {
        $result = Transliterator::toRomaji('サッカー', $this->nihon);
        $this->assertEquals('sakkâ', $result);
    }

    public function testToRomajiWithNihonWhenSokuonTchInHiragana()
    {
        $result = Transliterator::toRomaji('マッチャ', $this->nihon);
        $this->assertEquals('mattya', $result);
    }

    public function testToRomajiWithNihonWhenParticles()
    {
        $result = Transliterator::toRomaji('サッカーをやる', $this->nihon);
        $this->assertEquals('sakkâwoyaru', $result);
    }

    public function testToRomajiWithNihonWhenChoonpu()
    {
        $result = Transliterator::toRomaji('パーティー', $this->nihon);
        $this->assertEquals('pâtî', $result);
    }

    public function testToRomajiWithNihonWhenMixingHiraganaAndKatakana()
    {
        $result = Transliterator::toRomaji('サッカー を やる', $this->nihon);
        $this->assertEquals('sakkâ wo yaru', $result);
    }

    public function testToRomajiWithNihonWhenNFollowedByVowel()
    {
        $result = Transliterator::toRomaji('きんえん', $this->nihon);
        $this->assertEquals('kin\'en', $result);
    }

    public function testToRomajiWithNihonWhenNFollowedByConsonant()
    {
        $result = Transliterator::toRomaji('あんない', $this->nihon);
        $this->assertEquals('annai', $result);
    }

    public function testToRomajiWithNihonWhenPunctuationMarks()
    {
        $result = Transliterator::toRomaji('｛｝（）［］【】、，…‥。・〽「」『』〜：！？　', $this->nihon);
        $this->assertEquals('{}()[][], , …….-\'\'\'""~:!? ', $result);
    }
    
public function testToRomajiWithWapuro()
    {
        $result = Transliterator::toRomaji('くるま', $this->wapuro);
        $this->assertEquals('kuruma', $result);
    }

    public function testToRomajiWithWapuroWhenLatinOnly()
    {
        $result = Transliterator::toRomaji('yahoo YAHOO', $this->wapuro);
        $this->assertEquals('yahoo YAHOO', $result);
    }

    public function testToRomajiWithWapuroWhenLongVowels()
    {
        $result = Transliterator::toRomaji('がっこう', $this->wapuro);
        $this->assertEquals('gakkou', $result);
    }

    public function testToRomajiWithWapuroWhenSokuonInHiragana()
    {
        $result = Transliterator::toRomaji('けっか', $this->wapuro);
        $this->assertEquals('kekka', $result);
    }

    public function testToRomajiWithWapuroWhenSokuonInKatakana()
    {
        $result = Transliterator::toRomaji('サッカー', $this->wapuro);
        $this->assertEquals('sakka-', $result);
    }

    public function testToRomajiWithWapuroWhenSokuonTchInHiragana()
    {
        $result = Transliterator::toRomaji('マッチャ', $this->wapuro);
        $this->assertEquals('maccha', $result);
    }

    public function testToRomajiWithWapuroWhenParticles()
    {
        $result = Transliterator::toRomaji('サッカーをやる', $this->wapuro);
        $this->assertEquals('sakka-woyaru', $result);
    }

    public function testToRomajiWithWapuroWhenChoonpu()
    {
        $result = Transliterator::toRomaji('パーティー', $this->wapuro);
        $this->assertEquals('pa-teli-', $result);
    }

    public function testToRomajiWithWapuroWhenMixingHiraganaAndKatakana()
    {
        $result = Transliterator::toRomaji('サッカー を やる', $this->wapuro);
        $this->assertEquals('sakka- wo yaru', $result);
    }

    public function testToRomajiWithWapuroWhenNFollowedByVowel()
    {
        $result = Transliterator::toRomaji('きんえん', $this->wapuro);
        $this->assertEquals('kinnenn', $result);
    }

    public function testToRomajiWithWapuroWhenNFollowedByConsonant()
    {
        $result = Transliterator::toRomaji('あんない', $this->wapuro);
        $this->assertEquals('annnai', $result);
    }

    public function testToRomajiWithWapuroWhenPunctuationMarks()
    {
        $result = Transliterator::toRomaji('｛｝（）［］【】、，…‥。・〽「」『』〜：！？　', $this->wapuro);
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
