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
}
