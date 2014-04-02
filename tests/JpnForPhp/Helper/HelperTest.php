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

    public function testExtractKanjiWhenKanjiOnly()
    {
        $result = Helper::extractKanji($this->kanjiCharacters);
        $this->assertSame($result, array('漢字'));
    }

    public function testExtractKanjiWhenNoKanji()
    {
        $result = Helper::extractKanji($this->hiraganaCharacters);
        $this->assertSame($result, array());
    }

    public function testExtractKanjiWhenMixedCharacters()
    {
        $result = Helper::extractKanji($this->mixCharacters);
        $this->assertSame($result, array('今日','学校'));
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

    public function testExtractKatakanaIssue24()
    {
        $result = Helper::extractKatakana('カタカナ|ヒラガナ');
        $this->assertSame($result, array('カタカナ', 'ヒラガナ'));
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

    public function testExtractKanjiLiteralsWhenKanjiOnly()
    {
        $result = Helper::extractKanjiCharacters($this->kanjiCharacters);
        $this->assertEquals($result, array('漢', '字'));
    }

    public function testExtractKanjiLiteralsWhenMixed()
    {
        $result = Helper::extractKanjiCharacters($this->mixCharacters);
        $this->assertEquals($result, array('今', '日', '学', '校'));
    }

    public function testExtractKanjiWhenNoKanjis()
    {
        $result = Helper::extractKanjiCharacters($this->hiraganaCharacters);
        $this->assertEquals($result, array());
    }
}
