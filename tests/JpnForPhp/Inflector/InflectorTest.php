<?php

/*
 * This file is part of the JpnForPhp package.
 *
 * (c) Matthieu Bilbille
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JpnForPhp\Tests\Inflector;

use JpnForPhp\Inflector\Inflector;
use JpnForPhp\Inflector\InflectorUtils;
use JpnForPhp\Inflector\Verb;
use Symfony\Component\Yaml\Yaml;

/**
 * JpnForPhp Testcase for Inflector component
 */
class InflectorTest extends \PHPUnit_Framework_TestCase
{

    protected function setUp()
    {
        parent::setUp();
    }

    private function assertInflectionFromFile($verb, $file)
    {
        $entries = InflectorUtils::getEntriesFromDatabase($verb);
        $actual = Inflector::inflect($entries[0]);

        $fileName = __DIR__ . DIRECTORY_SEPARATOR . $file;
        $this->assertFileExists($fileName);
        $expected = Yaml::parse(file_get_contents($fileName));

        $this->assertEquals($expected, $actual);
    }

    public function testInflectMiruExistsKanji()
    {
        $this->assertNotEmpty(InflectorUtils::getEntriesFromDatabase('見る'));
    }

    public function testInflectMiruExistsKana()
    {
        $this->assertNotEmpty(InflectorUtils::getEntriesFromDatabase('みる'));
    }

    public function testInflectMiruExistsRomaji()
    {
        $this->assertNotEmpty(InflectorUtils::getEntriesFromDatabase('miru'));
    }

    public function testInflect_v1()
    {
        $this->assertInflectionFromFile('見る', 'miru.yml');
        $this->assertInflectionFromFile('食べる', 'taberu.yml');
    }

    public function testInflect_v5k()
    {
        $this->assertInflectionFromFile('焼く', 'yaku.yml');
    }

    public function testInflect_v5ks()
    {
        $this->assertInflectionFromFile('行く', 'iku.yml');
    }

    public function testInflect_v5g()
    {
        $this->assertInflectionFromFile('泳ぐ', 'oyogu.yml');
    }

    public function testInflect_v5s()
    {
        $this->assertInflectionFromFile('放す', 'hanasu.yml');
    }

    public function testInflect_v5t()
    {
        $this->assertInflectionFromFile('待つ', 'matsu.yml');
    }

    public function testInflect_v5n()
    {
        $this->assertInflectionFromFile('死ぬ', 'shinu.yml');
    }

    public function testInflect_v5b()
    {
        $this->assertInflectionFromFile('呼ぶ', 'yobu.yml');
    }

    public function testInflect_v5m()
    {
      $this->assertInflectionFromFile('読む', 'yomu.yml');
    }

    public function testInflect_v5r()
    {
      $this->assertInflectionFromFile('走る', 'hashiru.yml');
    }

    public function testInflect_v5aru()
    {
      $this->assertInflectionFromFile('いらっしゃる', 'irassharu.yml');
    }

    public function testInflect_v5ri()
    {
      $this->assertInflectionFromFile('有る', 'aru.yml');
    }

    public function testInflect_v5u()
    {
      $this->assertInflectionFromFile('使う', 'tsukau.yml');
    }

    public function testInflect_v5us()
    {
      $this->assertInflectionFromFile('請う', 'kou.yml');
    }

    public function testInflect_vs()
    {
      $this->assertInflectionFromFile('する', 'suru.yml');
    }

    public function testInflect_vss()
    {
      $this->assertInflectionFromFile('愛する', 'aisuru.yml');
    }
}
