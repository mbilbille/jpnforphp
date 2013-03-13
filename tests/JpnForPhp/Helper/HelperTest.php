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

    public function testSplit()
    {
        $result = Helper::split($this->mixCharacters);
        $this->assertSame($result, array('今', '日', '、', 'J', 'o', 'o', '「', 'ジ', 'ョ', 'オ', '」', 'は', '学', '校', 'に', 'い', 'ま', 'す', '。'));
    }

    public function testCharAt()
    {
        $result = Helper::charAt($this->mixCharacters, 13);
        $this->assertEquals($result, '校');

        $result = Helper::charAt($this->mixCharacters, 0);
        $this->assertEquals($result, '今');

        $result = Helper::charAt($this->mixCharacters, -2);
        $this->assertEquals($result, 'す');
    }

    public function testSubString()
    {
        $result = Helper::subString($this->mixCharacters, 4, 5);
        $this->assertEquals($result, 'oo「ジョ');

        $result = Helper::subString($this->mixCharacters, 0, 3);
        $this->assertEquals($result, '今日、');

        $result = Helper::subString($this->mixCharacters, -3, 3);
        $this->assertEquals($result, 'ます。');
    }

    public function testExtractKanji()
    {
        $result = Helper::extractKanji($this->kanjiCharacters);
        $this->assertSame($result, array('漢字'));

        $result = Helper::extractKanji($this->hiraganaCharacters);
        $this->assertSame($result, array());

        $result = Helper::extractKanji($this->mixCharacters);
        $this->assertSame($result, array('今日','学校'));
    }

    public function testExtractHiragana()
    {
        $result = Helper::extractHiragana($this->hiraganaCharacters);
        $this->assertSame($result, array('ひらがな'));

        $result = Helper::extractHiragana($this->katakanaCharacters);
        $this->assertSame($result, array());

        $result = Helper::extractHiragana($this->mixCharacters);
        $this->assertSame($result, array('は','にいます'));
    }
    
    public function testExtractKatakana()
    {
        $result = Helper::extractKatakana($this->katakanaCharacters);
        $this->assertSame($result, array('カタカナ'));

        $result = Helper::extractKatakana($this->hiraganaCharacters);
        $this->assertSame($result, array());

        $result = Helper::extractKatakana($this->mixCharacters);
        $this->assertSame($result, array('ジョオ'));
    }

    public function testRemoveLTRM()
    {
        $result = Helper::removeLTRM("Kyōto\xe2\x80\x8e");
        $this->assertEquals($result, "Kyōto");
    }

    public function testRemoveMacrons()
    {
        $result = Helper::removeMacrons($this->mixCharacters);
        $this->assertEquals($result, $this->mixCharacters);

        $result = Helper::removeMacrons('ŌōŪūĀāĪīôÔûÛâÂîÎêÊ');
        $this->assertEquals($result, 'OoUuAaIioOuUaAiIeE');
    }
}
