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

        // foreach ($verbalForms as $verbalForm => $languageForms) {
        //     $this->assertArrayHasKey($verbalForm, $actual);
        //
        //     foreach ($languageForms as $languageForm => $inflection) {
        //       $this->assertArrayHasKey($languageForm, $actual[$verbalForm]);
        //       $this->assertEquals($inflection,$actual[$verbalForm])
        //     }
        //
        //     $parts = explode(',', trim($line));
        //
        //     $kanji = $results[$parts[0]]['kanji'];
        //     $kana = $results[$parts[0]]['kana'];
        //     $this->assertEquals($parts[1], $kanji);
        //     $this->assertEquals($parts[2], $kana);
        // }
    }

    public function testInflect()
    {
      $this->assertInflectionFromFile('読む', 'yomu.yml');
    }
}
