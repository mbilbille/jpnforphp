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

/**
 * JpnForPhp Testcase for Inflector component
 */
class InflectorTest extends \PHPUnit_Framework_TestCase
{

    protected function setUp()
    {
        parent::setUp();
    }

    public function testInflect()
    {
      $verbs = InflectorUtils::getVerb('読む');
      $this->assertNotEmpty($verbs);

      $result = Inflector::inflect($verbs[0]);
      // @TODO
    }
}
