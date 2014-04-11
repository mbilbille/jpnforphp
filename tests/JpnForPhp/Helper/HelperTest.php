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
        $this->assertSame($result, array('今', '日', '、', 'J', 'o', 'o', '「', 'ジ', 'ョ', 'オ', '」', 'は', '学', '校', 'に', 'い', 'ま', 'す', '。'));
    }

    public function testSplitSequenceOfCharacters()
    {
        $result = Helper::split($this->mixCharacters);
        $this->assertSame($result, array('今', '日', '、', 'J', 'o', 'o', '「', 'ジ', 'ョ', 'オ', '」', 'は', '学', '校', 'に', 'い', 'ま', 'す', '。'));
    }

    public function testGetCharAtMiddleOfString()
    {
        $result = Helper::charAt($this->mixCharacters, 13);
        $this->assertEquals($result, '校');
    }

    public function testGetCharAtStartOfString()
    {
        $result = Helper::charAt($this->mixCharacters, 0);
        $this->assertEquals($result, '今');
    }

    public function testGetCharAtEndOfString()
    {
        $result = Helper::charAt($this->mixCharacters, -2);
        $this->assertEquals($result, 'す');
    }

    public function testSubStringInTheMiddle()
    {
        $result = Helper::subString($this->mixCharacters, 4, 5);
        $this->assertEquals($result, 'oo「ジョ');
    }

    public function testSubStringFromTheBeginning()
    {
        $result = Helper::subString($this->mixCharacters, 0, 3);
        $this->assertEquals($result, '今日、');
    }

    public function testSubStringFromTheEnd()
    {
        $result = Helper::subString($this->mixCharacters, -3, 3);
        $this->assertEquals($result, 'ます。');
    }

    public function testExtractKanjiWhenNoKanji()
    {
        $result = Helper::extractKanji($this->hiraganaCharacters);
        $this->assertSame($result, array());
    }

    public function testExtractKanjiWhenKanjiOnly()
    {
        $result = Helper::extractKanji($this->kanjiCharacters);
        $this->assertEquals($result, array('漢字'));
    }

    public function testExtractKanjiWhenMixedCharacters()
    {
        $result = Helper::extractKanji($this->mixCharacters);
        $this->assertSame($result, array('今日','学校'));
    }

    public function testExtractKanjiWithLengthEqualsOneWhenKanjiOnly()
    {
        $result = Helper::extractKanji($this->kanjiCharacters, 1);
        $this->assertEquals($result, array('漢', '字'));
    }

    public function testExtractKanjiWithLengthEqualsOneWhenMixed()
    {
        $result = Helper::extractKanji($this->mixCharacters, 1);
        $this->assertEquals($result, array('今', '日', '学', '校'));
    }

    public function testExtractKanjiWithLengthEqualsNWhenKanjiOnly()
    {
        $result = Helper::extractKanji($this->kanjiCharacters, 2);
        $this->assertEquals($result, array('漢字'));
    }

    public function testExtractKanjiWithLengthEqualsNWhenMixed()
    {
        $result = Helper::extractKanji($this->mixCharacters, 2);
        $this->assertEquals($result, array('今日', '学校'));
    }

    public function testExtractHiraganaWhenHiraganaOnly()
    {
        $result = Helper::extractHiragana($this->hiraganaCharacters);
        $this->assertSame($result, array('ひらがな'));
    }

    public function testExtractHiraganaWhenNoHiragana()
    {
        $result = Helper::extractHiragana($this->katakanaCharacters);
        $this->assertSame($result, array());
    }

    public function testExtractHiraganaWhenMixedCharacters()
    {
        $result = Helper::extractHiragana($this->mixCharacters);
        $this->assertSame($result, array('は','にいます'));
    }

    public function testExtractHiraganaWithLengthEqualsOneWhenHiraganaOnly()
    {
        $result = Helper::extractHiragana($this->hiraganaCharacters, 1);
        $this->assertEquals($result, array('ひ', 'ら', 'が', 'な'));
    }

    public function testExtractHiraganaWithLengthEqualsOneWhenMixed()
    {
        $result = Helper::extractHiragana($this->mixCharacters, 1);
        $this->assertSame($result, array('は', 'に', 'い', 'ま', 'す'));
    }

    public function testExtractHiraganaWithLengthEqualsOneAndYoonTrue()
    {
        $result = Helper::extractHiragana('じゃ、行きましょう', 1, true);
        $this->assertSame($result, array('じゃ', 'き', 'ま', 'しょ', 'う'));
    }

    public function testExtractHiraganaWithLengthEqualsNWhenHiraganaOnly()
    {
        $result = Helper::extractHiragana($this->hiraganaCharacters, 2);
        $this->assertEquals($result, array('ひら', 'がな'));
    }

    public function testExtractHiraganaWithLengthEqualsNWhenMixed()
    {
        $result = Helper::extractHiragana($this->mixCharacters, 2);
        $this->assertSame($result, array('はに', 'いま', 'す'));
    }

    public function testExtractHiraganaWithLengthEqualsNAndYoonTrue()
    {
        $result = Helper::extractHiragana('じゃ、行きましょう', 3, true);
        $this->assertSame($result, array('じゃきま', 'しょう'));
    }

    public function testExtractKatakanaWhenKatakanaOnly()
    {
        $result = Helper::extractKatakana($this->katakanaCharacters);
        $this->assertSame($result, array('カタカナ'));
    }

    public function testExtractKatakanaWhenNoKatakana()
    {
        $result = Helper::extractKatakana($this->hiraganaCharacters);
        $this->assertSame($result, array());
    }

    public function testExtractKatakanaWhenMixedCharacters()
    {
        $result = Helper::extractKatakana($this->mixCharacters);
        $this->assertSame($result, array('ジョオ'));
    }

    public function testExtractKatakanaWithLengthEqualsOneWhenKatakanaOnly()
    {
        $result = Helper::extractKatakana($this->katakanaCharacters, 1);
        $this->assertEquals($result, array('カ', 'タ', 'カ', 'ナ'));
    }

    public function testExtractKatakanaWithLengthEqualsOneWhenMixed()
    {
        $result = Helper::extractKatakana($this->mixCharacters, 1);
        $this->assertSame($result, array('ジ', 'ョ', 'オ'));
    }

    public function testExtractKatakanaWithLengthEqualsOneAndYoonTrue()
    {
        $result = Helper::extractKatakana('ジョオと申します', 1, true);
        $this->assertSame($result, array('ジョ', 'オ'));
    }

    public function testExtractKatakanaWithLengthEqualsNWhenKatakanaOnly()
    {
        $result = Helper::extractKatakana($this->katakanaCharacters, 2);
        $this->assertEquals($result, array('カタ', 'カナ'));
    }

    public function testExtractKatakanaWithLengthEqualsNWhenMixed()
    {
        $result = Helper::extractKatakana($this->mixCharacters, 2);
        $this->assertSame($result, array('ジョ', 'オ'));
    }

    public function testExtractKatakanaWithLengthEqualsNAndYoonTrue()
    {
        $result = Helper::extractKatakana('ジョオと申します', 2, true);
        $this->assertSame($result, array('ジョオ'));
    }

    public function testExtractKatakanaIssue24()
    {
        $result = Helper::extractKatakana('カタカナ|ヒラガナ');
        $this->assertSame($result, array('カタカナ', 'ヒラガナ'));
    }

    public function testExtractKanaWhenKanaOnly()
    {
        $result = Helper::extractKana($this->hiraganaCharacters . $this->katakanaCharacters);
        $this->assertSame($result, array('ひらがなカタカナ'));
    }

    public function testExtractKanaWhenNoKana()
    {
        $result = Helper::extractKana($this->kanjiCharacters);
        $this->assertSame($result, array());
    }

    public function testExtractKanaWhenMixedCharacters()
    {
        $result = Helper::extractKana($this->mixCharacters);
        $this->assertSame($result, array('ジョオ', 'は', 'にいます'));
    }

    public function testExtractKanaWithLengthEqualsOneWhenKanaOnly()
    {
        $result = Helper::extractKana($this->hiraganaCharacters . $this->katakanaCharacters, 1);
        $this->assertEquals($result, array('ひ', 'ら', 'が', 'な', 'カ', 'タ', 'カ', 'ナ'));
    }

    public function testExtractKanaWithLengthEqualsOneWhenMixed()
    {
        $result = Helper::extractKana($this->mixCharacters, 1);
        $this->assertSame($result, array('ジ', 'ョ', 'オ', 'は', 'に', 'い', 'ま', 'す'));
    }

    public function testExtractKanaWithLengthEqualsOneAndYoonTrue()
    {
        $result = Helper::extractKana('ジョオと行きましょう', 1, true);
        $this->assertSame($result, array('ジョ', 'オ', 'と', 'き', 'ま', 'しょ', 'う'));
    }

    public function testExtractKanaWithLengthEqualsNWhenKanaOnly()
    {
        $result = Helper::extractKana($this->hiraganaCharacters . $this->katakanaCharacters, 4);
        $this->assertEquals($result, array('ひらがな', 'カタカナ'));
    }

    public function testExtractKanaWithLengthEqualsNWhenMixed()
    {
        $result = Helper::extractKana($this->mixCharacters, 2);
        $this->assertSame($result, array('ジョ', 'オは', 'にい', 'ます'));
    }

    public function testextractKanaWithLengthEqualsNAndYoonTrue()
    {
        $result = Helper::extractKana('ジョオと行きましょう', 3, true);
        $this->assertSame($result, array('ジョオと', 'きましょ', 'う'));
    }

    public function testTrim()
    {
        $result = Helper::trim("Kyōto\xe2\x80\x8e");
        $this->assertEquals($result, "Kyōto");
    }

    public function testRemoveMacronsFromMixedCharacters()
    {
        $result = Helper::removeMacrons($this->mixCharacters);
        $this->assertEquals($result, $this->mixCharacters);
    }

    public function testRemoveMacronsFromAnyMacrons()
    {
        $result = Helper::removeMacrons('ŌōŪūĀāĪīôÔûÛâÂîÎêÊ');
        $this->assertEquals($result, 'OoUuAaIioOuUaAiIeE');
    }

    public function testConvertHiraganaToKatakanaWhenEmptyString()
    {
        $result = Helper::convertHiraganaToKatakana('');
        $this->assertEquals($result, '');
    }

    public function testConvertHiraganaToKatakanaWhenHiragana()
    {
        $result = Helper::convertHiraganaToKatakana($this->hiraganaCharacters);
        $this->assertEquals($result, 'ヒラガナ');
    }

    public function testConvertHiraganaToKatakanaWhenNoHiragana()
    {
        $result = Helper::convertHiraganaToKatakana($this->katakanaCharacters);
        $this->assertEquals($result, $this->katakanaCharacters);
    }

    public function testConvertHiraganaToKatakanaWhenMixCharacters()
    {
        $result = Helper::convertHiraganaToKatakana($this->mixCharacters);
        $this->assertEquals($result, '今日、Joo「ジョオ」ハ学校ニイマス。');
    }

    public function testConvertKatakanaToHiraganaWhenEmptyString()
    {
        $result = Helper::convertKatakanaToHiragana('');
        $this->assertEquals($result, '');
    }

    public function testConvertKatakanaToHiraganaWhenKatakana()
    {
        $result = Helper::convertKatakanaToHiragana($this->katakanaCharacters);
        $this->assertEquals($result, 'かたかな');
    }

    public function testConvertKatakanaToHiraganaWhenNoKatakana()
    {
        $result = Helper::convertKatakanaToHiragana($this->hiraganaCharacters);
        $this->assertEquals($result, $this->hiraganaCharacters);
    }

    public function testConvertKatakanaToHiraganaWhenMixCharacters()
    {
        $result = Helper::convertKatakanaToHiragana($this->mixCharacters);
        $this->assertEquals($result, '今日、Joo「じょお」は学校にいます。');
    }
}
