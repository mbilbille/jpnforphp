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
use PHPUnit\Framework\TestCase;

/**
 * JpnForPhp Testcase for Analyzer component
 */
class AnalyzerTest extends TestCase
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
        $this->assertEquals(4, $result);
    }

    public function testCountKanjiWhenNoKanji()
    {
        $result = Analyzer::countKanji($this->hiraganaCharacters);
        $this->assertEquals(0, $result);
    }

    public function testCountHiraganaWhenMixedCharacters()
    {
        $result = Analyzer::countHiragana($this->mixCharacters);
        $this->assertEquals(5, $result);
    }

    public function testCountHiraganaWhenNoHiragana()
    {
        $result = Analyzer::countHiragana($this->katakanaCharacters);
        $this->assertEquals(0, $result);
    }

    public function testCountHiraganaWhenSutegana()
    {
        $result = Analyzer::countHiragana('ぁぃぅぇぉ');
        $this->assertEquals(5, $result);
    }

    public function testCountKatakanaWhenMixedCharacters()
    {
        $result = Analyzer::countKatakana($this->mixCharacters);
        $this->assertEquals(3, $result);
    }

    public function testCountKatakanaWhenNoKatakana()
    {
        $result = Analyzer::countKatakana($this->hiraganaCharacters);
        $this->assertEquals(0, $result);
    }

    public function testCountKatakanaWhenSpecialKatakana()
    {
        $result = Analyzer::countKatakana('㋐㌒㌕');
        $this->assertEquals(3, $result);
    }

    public function testHasKanjiWhenMixedCharacters()
    {
        $result = Analyzer::hasKanji($this->mixCharacters);
        $this->assertEquals(TRUE, $result);
    }

    public function testHasNoKanji()
    {
        $result = Analyzer::hasKanji($this->hiraganaCharacters);
        $this->assertEquals(FALSE, $result);
    }

    public function testHasHiraganaWhenMixedCharacters()
    {
        $result = Analyzer::hasHiragana($this->mixCharacters);
        $this->assertEquals(TRUE, $result);
    }

    public function testHasNoHiragana()
    {
        $result = Analyzer::hasHiragana($this->katakanaCharacters);
        $this->assertEquals(FALSE, $result);
    }

    public function testHasKatakanaWhenMixedCharacters()
    {
        $result = Analyzer::hasKatakana($this->mixCharacters);
        $this->assertEquals(TRUE, $result);
    }

    public function testHasNoKatakana()
    {
        $result = Analyzer::hasKatakana($this->hiraganaCharacters);
        $this->assertEquals(FALSE, $result);
    }

    public function testHasKanaWhenMixedCharacters()
    {
        $result = Analyzer::hasKana($this->mixCharacters);
        $this->assertEquals(TRUE, $result);
    }

    public function testHasNoKana()
    {
        $result = Analyzer::hasKana($this->kanjiCharacters);
        $this->assertEquals(FALSE, $result);
    }

    public function testHasJapaneseLetters()
    {
        $result = Analyzer::hasJapaneseLetters($this->mixCharacters);
        $this->assertEquals(TRUE, $result);
    }

    public function testHasNotJapaneseLetters()
    {
        $result = Analyzer::hasJapaneseLetters('This is a 「test」。');
        $this->assertEquals(FALSE, $result);
    }

    public function testHasJapanesePunctuationMarks()
    {
        $result = Analyzer::hasJapanesePunctuationMarks($this->mixCharacters);
        $this->assertEquals(TRUE, $result);
    }

    public function testHasNotJapanesePunctuationMarks()
    {
        $result = Analyzer::hasJapanesePunctuationMarks($this->hiraganaCharacters);
        $this->assertEquals(FALSE, $result);
    }

    public function testHasJapaneseWritings()
    {
        $result = Analyzer::hasJapaneseWritings($this->mixCharacters);
        $this->assertEquals(TRUE, $result);
    }

    public function testHasNotJapaneseWritings()
    {
        $result = Analyzer::hasJapaneseWritings('This is a test.');
        $this->assertEquals(FALSE, $result);
    }

    public function testHasJapaneseWritingsButOnlyPunctuationMarks()
    {
        $result = Analyzer::hasJapaneseWritings('This is a test。');
        $this->assertEquals(TRUE, $result);
    }

    public function testLenghtOfMixedCharacters()
    {
        $result = Analyzer::length($this->mixCharacters);
        $this->assertEquals(19, $result);
    }

    public function testLenghtOfAnEmptyString()
    {
        $result = Analyzer::length('');
        $this->assertEquals(0, $result);
    }

    public function testInspectMixedCharacters()
    {
        $result = Analyzer::inspect($this->mixCharacters);
        $this->assertSame(array('length' => 19, 'kanji' => 4, 'hiragana' => 5, 'katakana' => 3), $result);
    }

    public function testHasJapaneseNumeral()
    {
        $result = Analyzer::hasJapaneseNumerals('五百二十八');
        $this->assertEquals(TRUE, $result);
    }

    public function testHasNotJapaneseNumeral()
    {
        $result = Analyzer::hasJapaneseNumerals($this->hiraganaCharacters);
        $this->assertEquals(FALSE, $result);
    }

    public function testHasLatin()
    {
        $result = Analyzer::hasLatinLetters('Test');
        $this->assertEquals(TRUE, $result);
    }

    public function testHasLatinFullwidth()
    {
        $result = Analyzer::hasLatinLetters('Ｔｅｓｔ');
        $this->assertEquals(TRUE, $result);
    }

    public function testHasWesternNumeral()
    {
        $result = Analyzer::hasWesternNumerals('123');
        $this->assertEquals(TRUE, $result);
    }

    public function testHasWesternNumeralFullwith()
    {
        $result = Analyzer::hasWesternNumerals('１２３');
        $this->assertEquals(TRUE, $result);
    }

    public function testCountKanjiExtended()
    {
        $result = Analyzer::countKanji('三ヶ日', TRUE);
        $this->assertEquals(3, $result);
    }

    public function testSegmenterSentence1()
    {
        $result = Analyzer::segment('万一に備えて傘を持っていった方がいいだろうな。');
        $this->assertSame(array('万一','に','備え','て','傘','を','持っ','て','いっ','た','方','が','いい','だろ','う','な','。'), $result);
    }

    public function testSegmenterSentence2()
    {
        $result = Analyzer::segment('私の名前は中野です');
        $this->assertSame(array('私','の','名前','は','中野','です'), $result);
    }

    public function testSegmenterSentence3()
    {
        $result = Analyzer::segment('彼は自分の考えを言葉にするのが得意でない');
        $this->assertSame(array('彼','は','自分','の','考え','を','言葉','に','する','の','が','得意','で','ない'), $result);
    }

}
