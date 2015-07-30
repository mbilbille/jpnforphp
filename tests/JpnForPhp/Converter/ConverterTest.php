<?php

/*
 * This file is part of the JpnForPhp package.
 *
 * (c) Matthieu Bilbille
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JpnForPhp\Tests\Converter;

use JpnForPhp\Converter\Converter;

/**
 * JpnForPhp Testcase for Converter component
 */
class ConverterTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        parent::setUp();
    }

    public function testConversionToJapaneseNumeralWithDigit()
    {
        $result = Converter::toJapaneseNumeral(2);
        $this->assertEquals('二', $result);
    }
    
    public function testConversionToJapaneseNumeralWithNumberSupToTen()
    {
        $result = Converter::toJapaneseNumeral(13);
        $this->assertEquals('十三', $result);
    }
    
    public function testConversionToJapaneseNumeralWithNumberSupToHundred()
    {
        $result = Converter::toJapaneseNumeral(528);
        $this->assertEquals('五百二十八', $result);
    }  
    
    public function testConversionToJapaneseNumeralWithNumberSupToThousand()
    {
        $result = Converter::toJapaneseNumeral(2444);
        $this->assertEquals('二千四百四十四', $result);
    }
    
    public function testConversionToJapaneseNumeralWithNumberSupToTenThousand()
    {
        $result = Converter::toJapaneseNumeral(45287);
        $this->assertEquals('四万五千二百八十七', $result);
    }
    
    public function testConversionToJapaneseNumeralWithNumberSupToHundredMillion()
    {
        $result = Converter::toJapaneseNumeral(123456789);
        $this->assertEquals('一億二千三百四十五万六千七百八十九', $result);
    }

    public function testConversionToJapaneseNumeral1001()
    {
        $result = Converter::toJapaneseNumeral(1001);
        $this->assertEquals('千一', $result);
    }

    public function testConversionToJapaneseNumeral10000()
    {
        $result = Converter::toJapaneseNumeral(10000);
        $this->assertEquals('一万', $result);
    }

    public function testConversionToJapaneseNumeral1000000000000()
    {
        $result = Converter::toJapaneseNumeral(1000000000000);
        $this->assertEquals('一兆', $result);
    }

    public function testConversionToJapaneseNumeral1050919092985()
    {
        $result = Converter::toJapaneseNumeral(1050919092985);
        $this->assertEquals('一兆五百九億千九百九万二千九百八十五', $result);
    }

    public function testConversionToJapaneseNumeral10100100100101()
    {
        $result = Converter::toJapaneseNumeral(10100100100101);
        $this->assertEquals('十兆千一億十万百一', $result);
    }

    public function testConversionToJapaneseNumeralLegal13()
    {
        $result = Converter::toJapaneseNumeral(23, Converter::NUMERAL_KANJI_LEGAL);
        $this->assertEquals('弐拾参', $result);
    }

    public function testConversionToJapaneseNumeralReading13()
    {
        $result = Converter::toJapaneseNumeral(23, Converter::NUMERAL_READING);
        $this->assertEquals('ni jū san', $result);
    }

    public function testConversionToJapaneseNumeralReading302()
    {
        $result = Converter::toJapaneseNumeral(302, Converter::NUMERAL_READING);
        $this->assertEquals('sanbyaku ni', $result);
    }

    public function testConversionToJapaneseNumeralReading654()
    {
        $result = Converter::toJapaneseNumeral(654, Converter::NUMERAL_READING);
        $this->assertEquals('roppyaku go jū yon', $result);
    }

    public function testConversionToJapaneseNumeralReading10000000()
    {
        $result = Converter::toJapaneseNumeral(10000000, Converter::NUMERAL_READING);
        $this->assertEquals('issen  man', $result);
    }

    public function testConversionToJapaneseNumeralReading1000000000000()
    {
        $result = Converter::toJapaneseNumeral(1000000010000, Converter::NUMERAL_READING);
        $this->assertEquals('ichō ichi man', $result);
    }

    public function testConversionToJapaneseNumeralReading1050919092985()
    {
        $result = Converter::toJapaneseNumeral(1050919092985, Converter::NUMERAL_READING);
        $this->assertEquals('ichō go hyaku kyū oku issen kyū hyaku kyū man ni sen kyū hyaku hachi jū go', $result);
    }

}
