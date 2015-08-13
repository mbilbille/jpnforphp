<?php

/*
 * This file is part of the JpnForPhp package.
 *
 * (c) Matthieu Bilbille
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JpnForPhp\Tests\Analyzer;

use JpnForPhp\Analyzer\Analyzer;

/**
 * JpnForPhp Testcase for Analyzer component
 */
class AnalyzerTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $this->mixCharacters = '今日、Joo「ジョオ」は学校にいます。';
        $this->kanjiCharacters = '漢字';
        $this->hiraganaCharacters = 'ひらがな';
        $this->katakanaCharacters = 'カタカナ';
        parent::setUp();
    }

    public function testCountKanjiWhenMixedCharacters()
    {
        $result = Analyzer::countKanji($this->mixCharacters);
        $this->assertEquals($result, 4);
    }

    public function testCountKanjiWhenNoKanji()
    {
        $result = Analyzer::countKanji($this->hiraganaCharacters);
        $this->assertEquals($result, 0);
    }

    public function testCountHiraganaWhenMixedCharacters()
    {
        $result = Analyzer::countHiragana($this->mixCharacters);
        $this->assertEquals($result, 5);
    }

    public function testCountHiraganaWhenNoHiragana()
    {
        $result = Analyzer::countHiragana($this->katakanaCharacters);
        $this->assertEquals($result, 0);
    }

    public function testCountHiraganaWhenSutegana()
    {
        $result = Analyzer::countHiragana('ぁぃぅぇぉ');
        $this->assertEquals($result, 5);
    }

    public function testCountKatakanaWhenMixedCharacters()
    {
        $result = Analyzer::countKatakana($this->mixCharacters);
        $this->assertEquals($result, 3);
    }

    public function testCountKatakanaWhenNoKatakana()
    {
        $result = Analyzer::countKatakana($this->hiraganaCharacters);
        $this->assertEquals($result, 0);
    }

    public function testCountKatakanaWhenSpecialKatakana()
    {
        $result = Analyzer::countKatakana('㋐㌒㌕');
        $this->assertEquals($result, 3);
    }

    public function testHasKanjiWhenMixedCharacters()
    {
        $result = Analyzer::hasKanji($this->mixCharacters);
        $this->assertEquals($result, TRUE);
    }

    public function testHasNoKanji()
    {
        $result = Analyzer::hasKanji($this->hiraganaCharacters);
        $this->assertEquals($result, FALSE);
    }

    public function testHasHiraganaWhenMixedCharacters()
    {
        $result = Analyzer::hasHiragana($this->mixCharacters);
        $this->assertEquals($result, TRUE);
    }

    public function testHasNoHiragana()
    {
        $result = Analyzer::hasHiragana($this->katakanaCharacters);
        $this->assertEquals($result, FALSE);
    }

    public function testHasKatakanaWhenMixedCharacters()
    {
        $result = Analyzer::hasKatakana($this->mixCharacters);
        $this->assertEquals($result, TRUE);
    }

    public function testHasNoKatakana()
    {
        $result = Analyzer::hasKatakana($this->hiraganaCharacters);
        $this->assertEquals($result, FALSE);
    }

    public function testHasKanaWhenMixedCharacters()
    {
        $result = Analyzer::hasKana($this->mixCharacters);
        $this->assertEquals($result, TRUE);
    }

    public function testHasNoKana()
    {
        $result = Analyzer::hasKana($this->kanjiCharacters);
        $this->assertEquals($result, FALSE);
    }

    public function testHasJapaneseLetters()
    {
        $result = Analyzer::hasJapaneseLetters($this->mixCharacters);
        $this->assertEquals($result, TRUE);
    }

    public function testHasNotJapaneseLetters()
    {
        $result = Analyzer::hasJapaneseLetters('This is a 「test」。');
        $this->assertEquals($result, FALSE);
    }

    public function testHasJapanesePunctuationMarks()
    {
        $result = Analyzer::hasJapanesePunctuationMarks($this->mixCharacters);
        $this->assertEquals($result, TRUE);
    }

    public function testHasNotJapanesePunctuationMarks()
    {
        $result = Analyzer::hasJapanesePunctuationMarks($this->hiraganaCharacters);
        $this->assertEquals($result, FALSE);
    }

    public function testHasJapaneseWritings()
    {
        $result = Analyzer::hasJapaneseWritings($this->mixCharacters);
        $this->assertEquals($result, TRUE);
    }

    public function testHasNotJapaneseWritings()
    {
        $result = Analyzer::hasJapaneseWritings('This is a test.');
        $this->assertEquals($result, FALSE);
    }

    public function testHasJapaneseWritingsButOnlyPunctuationMarks()
    {
        $result = Analyzer::hasJapaneseWritings('This is a test。');
        $this->assertEquals($result, TRUE);
    }

    public function testLenghtOfMixedCharacters()
    {
        $result = Analyzer::length($this->mixCharacters);
        $this->assertEquals($result, 19);
    }

    public function testLenghtOfAnEmptyString()
    {
        $result = Analyzer::length('');
        $this->assertEquals($result, 0);
    }

    public function testInspectMixedCharacters()
    {
        $result = Analyzer::inspect($this->mixCharacters);
        $this->assertSame($result, array('length' => 19, 'kanji' => 4, 'hiragana' => 5, 'katakana' => 3));
    }

    public function testHasJapaneseNumeral()
    {
        $result = Analyzer::hasJapaneseNumerals('五百二十八');
        $this->assertEquals($result, TRUE);
    }

    public function testHasNotJapaneseNumeral()
    {
        $result = Analyzer::hasJapaneseNumerals($this->hiraganaCharacters);
        $this->assertEquals($result, FALSE);
    }

    public function testHasLatin()
    {
        $result = Analyzer::hasLatinLetters('Test');
        $this->assertEquals($result, TRUE);
    }

    public function testHasLatinFullwidth()
    {
        $result = Analyzer::hasLatinLetters('Ｔｅｓｔ');
        $this->assertEquals($result, TRUE);
    }

    public function testHasWesternNumeral()
    {
        $result = Analyzer::hasWesternNumerals('123');
        $this->assertEquals($result, TRUE);
    }

    public function testHasWesternNumeralFullwith()
    {
        $result = Analyzer::hasWesternNumerals('１２３');
        $this->assertEquals($result, TRUE);
    }

}
