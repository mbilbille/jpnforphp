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

/**
 * JpnForPhp Testcase for Inflector component
 */
class InflectorTest extends \PHPUnit_Framework_TestCase
{

    private function inflectVerbFromFile($verb, $file)
    {
        $verbs = Inflector::getVerb($verb);
        $this->assertNotEmpty($verbs);
        $results = Inflector::conjugate($verbs[0]);
        $fileName = __DIR__ . DIRECTORY_SEPARATOR . $file . '.csv';
        $this->assertFileExists($fileName);
        $lines = file($fileName);
        $this->assertNotEmpty($lines);
        foreach ($lines as $line) {
            $parts = explode(',', trim($line));
            $this->assertArrayHasKey($parts[0], $results);
            $kanji = $results[$parts[0]]['kanji'];
            $kana = $results[$parts[0]]['kana'];
            $this->assertEquals($parts[1], $kanji);
            $this->assertEquals($parts[2], $kana);
        }
    }

    protected function setUp()
    {
        parent::setUp();
    }

    public function testInflectMiruExistsKanji()
    {
        $this->assertNotEmpty(Inflector::getVerb('見る'));
    }

    public function testInflectMiruExistsKana()
    {
        $this->assertNotEmpty(Inflector::getVerb('みる'));
    }

    public function testInflectMiruExistsRomaji()
    {
        $this->assertNotEmpty(Inflector::getVerb('miru'));
    }

    public function testInflectMiruType()
    {
        $verbs = Inflector::getVerb('見る');
        $this->assertEquals($verbs[0]['type'], '1');
    }

    public function testInflectHanasuType()
    {
        $verbs = Inflector::getVerb('hanasu');
        $this->assertEquals($verbs[0]['type'], '5s');
    }

    public function testInflectMiruNonPastPoliteKana()
    {
        $verbs = Inflector::getVerb('見る');
        $results = Inflector::conjugate($verbs[0]);
        $this->assertEquals($results[Inflector::NON_PAST_POLITE]['kana'], 'みます');
    }

    public function testInflectMiruPastKana()
    {
        $verbs = Inflector::getVerb('見る');
        $results = Inflector::conjugate($verbs[0]);
        $this->assertEquals($results[Inflector::PAST]['kana'], 'みた');
    }

    public function testInflectHanasuNonPastPoliteKanji()
    {
        $verbs = Inflector::getVerb('はなす');
        $results = Inflector::conjugate($verbs[0]);
        $this->assertEquals($results[Inflector::NON_PAST_POLITE]['kanji'], '放します');
    }

    public function testInflect1()
    {
        $this->inflectVerbFromFile('見る', 'miru');
    }

    public function testInflect5s()
    {
        $this->inflectVerbFromFile('放す', 'hanasu');
    }

    public function testInflect5k()
    {
        $this->inflectVerbFromFile('焼く', 'yaku');
    }

    public function testInflect5ks()
    {
        $this->inflectVerbFromFile('行く', 'iku');
    }

    public function testInflect5g()
    {
        $this->inflectVerbFromFile('泳ぐ', 'oyogu');
    }

    public function testInflect5r()
    {
        $this->inflectVerbFromFile('走る', 'hashiru');
    }

    public function testInflect5u()
    {
        $this->inflectVerbFromFile('使う', 'tsukau');
    }

    public function testInflect5t()
    {
        $this->inflectVerbFromFile('待つ', 'matsu');
    }

    public function testInflect5aru()
    {
        $this->inflectVerbFromFile('いらっしゃる', 'irassharu');
    }

    public function testInflect5m()
    {
        $this->inflectVerbFromFile('読む', 'yomu');
    }

    public function testInflect5b()
    {
        $this->inflectVerbFromFile('呼ぶ', 'yobu');
    }

    public function testInflect5n()
    {
        $this->inflectVerbFromFile('死ぬ', 'shinu');
    }

    public function testInflectK()
    {
        $this->inflectVerbFromFile('来る', 'kuru');
    }

    public function testInflectSI()
    {
        $this->inflectVerbFromFile('する', 'suru');
    }

}
