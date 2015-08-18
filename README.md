![Logo](https://raw.githubusercontent.com/mbilbille/jpnforphp/gh-pages/images/logo.png)

JpnForPhp is a library for PHP that provides support and many helpers to play with Japanese language ([DEMO](http://jpnforphpdemos.nebuleux.be)).

[![build status](https://travis-ci.org/mbilbille/jpnforphp.svg)](http://travis-ci.org/mbilbille/jpnforphp)

The JpnForPhp toolbox provides over 30 functions build around various components that support both basic actions: **split, extract, etc.** as well as more specialized and powerful features: **transliteration, inflection, conversion**, and so one. 


## Installation

The recommended way to install JpnForPhp is through [Composer](http://getcomposer.org/). Just create a composer.json file and run the php composer.phar install command to install it:

```json
{
    "require": {
        "mbilbille/jpnforphp": "~0.6"
    }
}
```


## Components

![Components](https://raw.github.com/mbilbille/jpnforphp/gh-pages/images/components_schema.png)

* [Helper](https://github.com/mbilbille/jpnforphp/tree/master/src/JpnForPhp/Helper)
* [Analyzer](https://github.com/mbilbille/jpnforphp/tree/master/src/JpnForPhp/Analyzer)
* [Transliterator](https://github.com/mbilbille/jpnforphp/tree/master/src/JpnForPhp/Transliterator)
* [Converter](https://github.com/mbilbille/jpnforphp/tree/master/src/JpnForPhp/Converter)
* [Inflector](https://github.com/mbilbille/jpnforphp/tree/master/src/JpnForPhp/Inflector)

#### Transliterator

JpnForPhp supports all mainstream romanization systems:

* [Hepburn](http://en.wikipedia.org/wiki/Hepburn_romanization)
* [Kunrei](http://en.wikipedia.org/wiki/Kunrei-shiki_romanization)
* [Nihon](http://en.wikipedia.org/wiki/Nihon-shiki_romanization)
* [Wapuro](http://en.wikipedia.org/wiki/W%C4%81puro_r%C5%8Dmaji)

*Starting from the version 0.5, all the transliteration workflow is defined in ```.yaml``` file.*


#### Converter

* [Japanese numeral](https://github.com/mbilbille/jpnforphp/blob/master/src/JpnForPhp/Converter/Converter.php#L374) (kanji, reading)
* [Western year](https://github.com/mbilbille/jpnforphp/blob/master/src/JpnForPhp/Converter/Converter.php#L451)
* [Japanese year](https://github.com/mbilbille/jpnforphp/blob/master/src/JpnForPhp/Converter/Converter.php#L515) (kanji, kana, romaji)

*More units should complement the `Converter` component in future release*


#### Inflector

JpnForPhp supports many verbal form.  
[List of all verbal forms](https://github.com/mbilbille/jpnforphp/blob/develop/src/JpnForPhp/Inflector/Inflector.php#L28)


## Examples

See and test each features on this [demo website](http://jpnforphpdemos.nebuleux.be).
This website is maintained by @Akeru.


## Tests

To run the test suite, you need [Composer](http://getcomposer.org/):

```bash
    $ php composer.phar install
    $ vendor/bin/phpunit
```

## Want to help?
Want to file a bug, contribute some code, or improve documentation? Excellent! Read up on our guidelines for [contributing](https://github.com/mbilbille/jpnforphp/tree/master/CONTRIBUTING.md) and then check out one of our [issues](https://github.com/mbilbille/jpnforphp/issues).

[List of all contributors](https://github.com/mbilbille/jpnforphp/graphs/contributors)


## Upcoming

Check out the _develop_ branch to get all the latest code and change (http://github.com/mbilbille/jpnforphp/tree/develop)

## License

JpnForPhp was created by [Matthieu Bilbille](http://github.com/mbilbille) and released under the [MIT License](http://github.com/mbilbille/jpnforphp/blob/master/LICENSE).

## Integration

- **JPNlizer** integrates JpnForPhp into Drupal - [sandbox project](http://drupal.org/sandbox/mbilbille/1613510) [Deprecated]
- **JpnForPhpBundle**: integrates JpnForPhp as a Symfony2 Bundle - [JpnForPhpBundle](http://github.com/albertofem/JpnForPhpBundle) (by @albertofem)
