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
        $this->assertEquals('億二千三百四十五万六千七百八十九', $result);
    }
}
