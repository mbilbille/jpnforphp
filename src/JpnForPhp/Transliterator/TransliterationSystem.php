<?php

/*
 * This file is part of the JpnForPhp package.
 *
 * (c) Matthieu Bilbille
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JpnForPhp\Transliterator;

use Symfony\Component\Yaml\Yaml;

/**
 * Transliteration system interface
 */
abstract class TransliterationSystem
{
    /**
     * @var array Load transliteration system configuration.
     */
    public $configuration = array();

    /**
     * Transliteration system's constructor
     */
    public function __construct($file)
    {
        $this->configuration = Yaml::parse($file);
    }

    /**
     * Transliterate a string from an alphabet into another alphabet as per  
     * the workflow specified in the configuration file.
     *
     * @param string $str The string to be converted.
     *
     * @return string Converted string.
     */
    public function transliterate($str)
    {
        foreach ($this->configuration['workflow'] as $work) {
            if(!method_exists($this, $work['function'])) {
                continue;
            }
            $params = array($str);
            if(isset($work['parameters'])) {
                $params[] = $work['parameters'];
            }
            $str = call_user_func_array(array($this, $work['function']), $params);
        }
        return $str;
    }

    /**
     * Implement magic method __toString().
     */
    abstract function __toString();
}
