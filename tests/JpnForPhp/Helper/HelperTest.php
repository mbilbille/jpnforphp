<?php

/*
 * This file is part of the JpnForPhp package.
 *
 * (c) Matthieu Bilbille
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JpnForPhp\Tests\Helper;

use JpnForPhp\Helper\Helper;

/**
 * JpnForPhp Testcase for Helper component
 */
class HelperTest extends \PHPUnit_Framework_TestCase
{
    protected $mixCharacters;
    protected $kanjiCharacters;
    protected $hiraganaCharacters;
    protected $katakanaCharacters;

    protected function setUp()
    {
        $this->mixCharacters = '今日、Joo「ジョオ」は学校にいます。';
        $this->kanjiCharacters = '漢字';
        $this->hiraganaCharacters = 'ひらがな';
        $this->katakanaCharacters = 'カタカナ';
        parent::setUp();
    }

    public function testSplitAnEmptySequenceOfCharacters()
    {
        $result = Helper::split($this->mixCharacters);
        $this->assertSame(array('今', '日', '、', 'J', 'o', 'o', '「', 'ジ', 'ョ', 'オ', '」', 'は', '学', '校', 'に', 'い', 'ま', 'す', '。'), $result);
    }

    public function testSplitSequenceOfCharacters()
    {
        $result = Helper::split($this->mixCharacters);
        $this->assertSame(array('今', '日', '、', 'J', 'o', 'o', '「', 'ジ', 'ョ', 'オ', '」', 'は', '学', '校', 'に', 'い', 'ま', 'す', '。'), $result);
    }

    public function testGetCharAtMiddleOfString()
    {
        $result = Helper::charAt($this->mixCharacters, 13);
        $this->assertEquals('校', $result);
    }

    public function testGetCharAtStartOfString()
    {
        $result = Helper::charAt($this->mixCharacters, 0);
        $this->assertEquals('今', $result);
    }

    public function testGetCharAtEndOfString()
    {
        $result = Helper::charAt($this->mixCharacters, -2);
        $this->assertEquals('す', $result);
    }

    public function testSubStringInTheMiddle()
    {
        $result = Helper::subString($this->mixCharacters, 4, 5);
        $this->assertEquals('oo「ジョ', $result);
    }

    public function testSubStringFromTheBeginning()
    {
        $result = Helper::subString($this->mixCharacters, 0, 3);
        $this->assertEquals('今日、', $result);
    }

    public function testSubStringFromTheEnd()
    {
        $result = Helper::subString($this->mixCharacters, -3, 3);
        $this->assertEquals('ます。', $result);
    }
    
    public function testCountSubStringWhenOccurencesFound()
    {
        $result = Helper::countSubString($this->mixCharacters, '学');
        $this->assertEquals(1, $result);
    }
    
    public function testCountSubStringWhenNoOccurencesFound()
    {
        $result = Helper::countSubString($this->mixCharacters, '漢');
        $this->assertEquals(0, $result);
    }

    public function testExtractKanjiWhenNoKanji()
    {
        $result = Helper::extractKanji($this->hiraganaCharacters);
        $this->assertSame(array(), $result);
    }

    public function testExtractKanjiWhenKanjiOnly()
    {
        $result = Helper::extractKanji($this->kanjiCharacters);
        $this->assertEquals(array('漢字'), $result);
    }

    public function testExtractKanjiWhenMixedCharacters()
    {
        $result = Helper::extractKanji($this->mixCharacters);
        $this->assertSame(array('今日','学校'), $result);
    }

    public function testExtractKanjiWithLengthEqualsOneWhenKanjiOnly()
    {
        $result = Helper::extractKanji($this->kanjiCharacters, 1);
        $this->assertEquals(array('漢', '字'), $result);
    }

    public function testExtractKanjiWithLengthEqualsOneWhenMixed()
    {
        $result = Helper::extractKanji($this->mixCharacters, 1);
        $this->assertEquals(array('今', '日', '学', '校'), $result);
    }

    public function testExtractKanjiWithLengthEqualsNWhenKanjiOnly()
    {
        $result = Helper::extractKanji($this->kanjiCharacters, 2);
        $this->assertEquals(array('漢字'), $result);
    }

    public function testExtractKanjiWithLengthEqualsNWhenMixed()
    {
        $result = Helper::extractKanji($this->mixCharacters, 2);
        $this->assertEquals(array('今日', '学校'), $result);
    }

    public function testExtractHiraganaWhenHiraganaOnly()
    {
        $result = Helper::extractHiragana($this->hiraganaCharacters);
        $this->assertSame(array('ひらがな'), $result);
    }

    public function testExtractHiraganaWhenNoHiragana()
    {
        $result = Helper::extractHiragana($this->katakanaCharacters);
        $this->assertSame(array(), $result);
    }

    public function testExtractHiraganaWhenMixedCharacters()
    {
        $result = Helper::extractHiragana($this->mixCharacters);
        $this->assertSame(array('は','にいます'), $result);
    }

    public function testExtractHiraganaWithLengthEqualsOneWhenHiraganaOnly()
    {
        $result = Helper::extractHiragana($this->hiraganaCharacters, 1);
        $this->assertEquals(array('ひ', 'ら', 'が', 'な'), $result);
    }

    public function testExtractHiraganaWithLengthEqualsOneWhenMixed()
    {
        $result = Helper::extractHiragana($this->mixCharacters, 1);
        $this->assertSame(array('は', 'に', 'い', 'ま', 'す'), $result);
    }

    public function testExtractHiraganaWithLengthEqualsOneAndYoonTrue()
    {
        $result = Helper::extractHiragana('じゃ、行きましょう', 1, true);
        $this->assertSame(array('じゃ', 'き', 'ま', 'しょ', 'う'), $result);
    }

    public function testExtractHiraganaWithLengthEqualsNWhenHiraganaOnly()
    {
        $result = Helper::extractHiragana($this->hiraganaCharacters, 2);
        $this->assertEquals(array('ひら', 'がな'), $result);
    }

    public function testExtractHiraganaWithLengthEqualsNWhenMixed()
    {
        $result = Helper::extractHiragana($this->mixCharacters, 2);
        $this->assertSame(array('はに', 'いま', 'す'), $result);
    }

    public function testExtractHiraganaWithLengthEqualsNAndYoonTrue()
    {
        $result = Helper::extractHiragana('じゃ、行きましょう', 3, true);
        $this->assertSame(array('じゃきま', 'しょう'), $result);
    }

    public function testExtractKatakanaWhenKatakanaOnly()
    {
        $result = Helper::extractKatakana($this->katakanaCharacters);
        $this->assertSame(array('カタカナ'), $result);
    }

    public function testExtractKatakanaWhenNoKatakana()
    {
        $result = Helper::extractKatakana($this->hiraganaCharacters);
        $this->assertSame(array(), $result);
    }

    public function testExtractKatakanaWhenMixedCharacters()
    {
        $result = Helper::extractKatakana($this->mixCharacters);
        $this->assertSame(array('ジョオ'), $result);
    }

    public function testExtractKatakanaWithLengthEqualsOneWhenKatakanaOnly()
    {
        $result = Helper::extractKatakana($this->katakanaCharacters, 1);
        $this->assertEquals(array('カ', 'タ', 'カ', 'ナ'), $result);
    }

    public function testExtractKatakanaWithLengthEqualsOneWhenMixed()
    {
        $result = Helper::extractKatakana($this->mixCharacters, 1);
        $this->assertSame(array('ジ', 'ョ', 'オ'), $result);
    }

    public function testExtractKatakanaWithLengthEqualsOneAndYoonTrue()
    {
        $result = Helper::extractKatakana('ジョオと申します', 1, true);
        $this->assertSame(array('ジョ', 'オ'), $result);
    }

    public function testExtractKatakanaWithLengthEqualsNWhenKatakanaOnly()
    {
        $result = Helper::extractKatakana($this->katakanaCharacters, 2);
        $this->assertEquals(array('カタ', 'カナ'), $result);
    }

    public function testExtractKatakanaWithLengthEqualsNWhenMixed()
    {
        $result = Helper::extractKatakana($this->mixCharacters, 2);
        $this->assertSame(array('ジョ', 'オ'), $result);
    }

    public function testExtractKatakanaWithLengthEqualsNAndYoonTrue()
    {
        $result = Helper::extractKatakana('ジョオと申します', 2, true);
        $this->assertSame(array('ジョオ'), $result);
    }

    public function testExtractKatakanaIssue24()
    {
        $result = Helper::extractKatakana('カタカナ|ヒラガナ');
        $this->assertSame(array('カタカナ', 'ヒラガナ'), $result);
    }

    public function testExtractKanaWhenKanaOnly()
    {
        $result = Helper::extractKana($this->hiraganaCharacters . $this->katakanaCharacters);
        $this->assertSame(array('ひらがなカタカナ'), $result);
    }

    public function testExtractKanaWhenNoKana()
    {
        $result = Helper::extractKana($this->kanjiCharacters);
        $this->assertSame(array(), $result);
    }

    public function testExtractKanaWhenMixedCharacters()
    {
        $result = Helper::extractKana($this->mixCharacters);
        $this->assertSame(array('ジョオ', 'は', 'にいます'), $result);
    }

    public function testExtractKanaWithLengthEqualsOneWhenKanaOnly()
    {
        $result = Helper::extractKana($this->hiraganaCharacters . $this->katakanaCharacters, 1);
        $this->assertEquals(array('ひ', 'ら', 'が', 'な', 'カ', 'タ', 'カ', 'ナ'), $result);
    }

    public function testExtractKanaWithLengthEqualsOneWhenMixed()
    {
        $result = Helper::extractKana($this->mixCharacters, 1);
        $this->assertSame(array('ジ', 'ョ', 'オ', 'は', 'に', 'い', 'ま', 'す'), $result);
    }

    public function testExtractKanaWithLengthEqualsOneAndYoonTrue()
    {
        $result = Helper::extractKana('ジョオと行きましょう', 1, true);
        $this->assertSame(array('ジョ', 'オ', 'と', 'き', 'ま', 'しょ', 'う'), $result);
    }

    public function testExtractKanaWithLengthEqualsNWhenKanaOnly()
    {
        $result = Helper::extractKana($this->hiraganaCharacters . $this->katakanaCharacters, 4);
        $this->assertEquals(array('ひらがな', 'カタカナ'), $result);
    }

    public function testExtractKanaWithLengthEqualsNWhenMixed()
    {
        $result = Helper::extractKana($this->mixCharacters, 2);
        $this->assertSame(array('ジョ', 'オは', 'にい', 'ます'), $result);
    }

    public function testextractKanaWithLengthEqualsNAndYoonTrue()
    {
        $result = Helper::extractKana('ジョオと行きましょう', 3, true);
        $this->assertSame(array('ジョオと', 'きましょ', 'う'), $result);
    }

    public function testTrim()
    {
        $result = Helper::trim("Kyōto\xe2\x80\x8e");
        $this->assertEquals("Kyōto", $result);
    }

    public function testRemoveMacronsFromMixedCharacters()
    {
        $result = Helper::removeMacrons($this->mixCharacters);
        $this->assertEquals($this->mixCharacters, $result);
    }

    public function testRemoveMacronsFromAnyMacrons()
    {
        $result = Helper::removeMacrons('ŌōŪūĀāĪīôÔûÛâÂîÎêÊ');
        $this->assertEquals('OoUuAaIioOuUaAiIeE', $result);
    }

    public function testConvertHiraganaToKatakanaWhenEmptyString()
    {
        $result = Helper::convertHiraganaToKatakana('');
        $this->assertEquals('', $result);
    }

    public function testConvertHiraganaToKatakanaWhenHiragana()
    {
        $result = Helper::convertHiraganaToKatakana($this->hiraganaCharacters);
        $this->assertEquals('ヒラガナ', $result);
    }

    public function testConvertHiraganaToKatakanaWhenNoHiragana()
    {
        $result = Helper::convertHiraganaToKatakana($this->katakanaCharacters);
        $this->assertEquals($this->katakanaCharacters, $result);
    }

    public function testConvertHiraganaToKatakanaWhenMixCharacters()
    {
        $result = Helper::convertHiraganaToKatakana($this->mixCharacters);
        $this->assertEquals('今日、Joo「ジョオ」ハ学校ニイマス。', $result);
    }

    public function testConvertKatakanaToHiraganaWhenEmptyString()
    {
        $result = Helper::convertKatakanaToHiragana('');
        $this->assertEquals('', $result);
    }

    public function testConvertKatakanaToHiraganaWhenKatakana()
    {
        $result = Helper::convertKatakanaToHiragana($this->katakanaCharacters);
        $this->assertEquals('かたかな', $result);
    }

    public function testConvertKatakanaToHiraganaWhenNoKatakana()
    {
        $result = Helper::convertKatakanaToHiragana($this->hiraganaCharacters);
        $this->assertEquals($this->hiraganaCharacters, $result);
    }

    public function testConvertKatakanaToHiraganaWhenMixCharacters()
    {
        $result = Helper::convertKatakanaToHiragana($this->mixCharacters);
        $this->assertEquals('今日、Joo「じょお」は学校にいます。', $result);
    }
}
