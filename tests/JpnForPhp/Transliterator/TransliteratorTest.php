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
    protected function setUp()
    {
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
        $result = Transliterator::toRomaji('くるま', NULL, new Hepburn());
        $this->assertEquals($result, 'kuruma');
    }

    public function testToRomajiWithHepburnWhenMacron()
    {
        $result = Transliterator::toRomaji('がっこう', NULL, new Hepburn());
        $this->assertEquals($result, 'gakkō');
    }

    public function testToRomajiWithHepburnWhenSokuonInHiragana()
    {
        $result = Transliterator::toRomaji('けっか', NULL, new Hepburn());
        $this->assertEquals($result, 'kekka');
    }

    public function testToRomajiWithHepburnWhenSokuonInKatakana()
    {
        $result = Transliterator::toRomaji('サッカー', NULL, new Hepburn());
        $this->assertEquals($result, 'sakkā');
    }

    public function testToRomajiWithHepburnWhenSokuonTchInHiragana()
    {
        $result = Transliterator::toRomaji('マッチャ', NULL, new Hepburn());
        $this->assertEquals($result, 'matcha');
    }

    public function testToRomajiWithHepburnWhenParticule()
    {
        $result = Transliterator::toRomaji('サッカーをやる', NULL, new Hepburn());
        $this->assertEquals($result, 'sakkāwoyaru');
    }

    public function testToRomajiWithHepburnWhenChoonpu()
    {
        $result = Transliterator::toRomaji('パーティー', NULL, new Hepburn());
        $this->assertEquals($result, 'pātī');
    }
    
    public function testToRomajiWithHepburnWhenMixingHiraganaAndKatakana()
    {
        $result = Transliterator::toRomaji('サッカー を やる', NULL, new Hepburn());
        $this->assertEquals($result, 'sakkā o yaru');
    }

    public function testToRomajiWithHepburnWhenNFollowedByVowel()
    {
        $result = Transliterator::toRomaji('きんえん', NULL, new Hepburn());
        $this->assertEquals($result, 'kin\'en');
    }

    public function testToRomajiWithHepburnWhenNFollowedByConsonant()
    {
        $result = Transliterator::toRomaji('あんない', NULL, new Hepburn());
        $this->assertEquals($result, 'annai');
    }
}