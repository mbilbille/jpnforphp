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
        $verbs = InflectorUtils::getVerb($verb);
        $actual = Inflector::inflect($verbs[0]);

        $fileName = __DIR__ . DIRECTORY_SEPARATOR . $file;
        $this->assertFileExists($fileName);
        $expected = Yaml::parse(file_get_contents($fileName));

        $this->assertEquals($expected, $actual);
    }

    public function testInflectMiruExistsKanji()
    {
        $this->assertNotEmpty(InflectorUtils::getVerb('見る'));
    }

    public function testInflectMiruExistsKana()
    {
        $this->assertNotEmpty(InflectorUtils::getVerb('みる'));
    }

    public function testInflectMiruExistsRomaji()
    {
        $this->assertNotEmpty(InflectorUtils::getVerb('miru'));
    }

    public function testInflect5k()
    {
        $this->assertInflectionFromFile('焼く', 'yaku.yml');
    }

    public function testInflect5ks()
    {
        $this->assertInflectionFromFile('行く', 'iku.yml');
    }

    public function testInflect5g()
    {
        $this->assertInflectionFromFile('泳ぐ', 'oyogu.yml');
    }

    public function testInflect5s()
    {
        $this->assertInflectionFromFile('放す', 'hanasu.yml');
    }

    public function testInflect5t()
    {
        $this->assertInflectionFromFile('待つ', 'matsu.yml');
    }

    public function testInflect5n()
    {
        $this->assertInflectionFromFile('死ぬ', 'shinu.yml');
    }

    public function testInflect5m()
    {
      $this->assertInflectionFromFile('読む', 'yomu.yml');
    }
}
