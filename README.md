<p align="center">
  <img src='https://raw.githubusercontent.com/mbilbille/jpnforphp/gh-pages/images/logo.png'/>
</p>

<p align="center">
  JpnForPhp provides support and many helpers to play with Japanese language in PHP - <a href="http://jpnforphpdemos.nebuleux.be">Demo</a>.
</p>

<p align="center">
  <a href="http://travis-ci.org/mbilbille/jpnforphp"><img alt="Build Status" src="https://travis-ci.org/mbilbille/jpnforphp.svg?branch=master"></a>
</p>

---

The JpnForPhp toolbox provides over 30 functions build around various components that support both basic actions: **split, extract, etc.** as well as more specialized and powerful features: **transliteration, inflection, conversion**, and so one.


## Installation

The recommended way to install JpnForPhp is through [Composer](http://getcomposer.org/). Just create a composer.json file and run the php composer.phar install command to install it:

```json
{
    "require": {
        "mbilbille/jpnforphp": "~0.7"
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

JpnForPhp Transliterator component supports all mainstream romanization systems:

* [Hepburn](http://en.wikipedia.org/wiki/Hepburn_romanization)
* [Kunrei](http://en.wikipedia.org/wiki/Kunrei-shiki_romanization)
* [Nihon](http://en.wikipedia.org/wiki/Nihon-shiki_romanization)
* [Wapuro](http://en.wikipedia.org/wiki/W%C4%81puro_r%C5%8Dmaji)

:warning: Component `Transliterator` has been rewritten in 0.7, use it as below:
```php
  $transliterator = new Transliterator();
  $transliterator->setSystem(new Hepburn());
  $transliterator->transliterate('くるま');
```

#### Converter

* [Japanese numeral](https://github.com/mbilbille/jpnforphp/blob/master/src/JpnForPhp/Converter/Converter.php#L374) (kanji, reading)
* [Western year](https://github.com/mbilbille/jpnforphp/blob/master/src/JpnForPhp/Converter/Converter.php#L451)
* [Japanese year](https://github.com/mbilbille/jpnforphp/blob/master/src/JpnForPhp/Converter/Converter.php#L515) (kanji, kana, romaji)

*More units should complement the `Converter` component in future release*


#### Inflector

JpnForPhp Inflector component supports many verbal and language forms which are all exposed in kanji, kana and romaji.

| Verbal form             | Plain | Polite | Plain negative | Polite negative |
| ----------------------- |:-----:|:------:|:--------------:|:---------------:|
| Past                    | •     | •      | •              | •               |
| -te form                | •     | •      | •              | •               |
| Potential               | •     | •      |                |                 |
| Passive                 | •     | •      | •              | •               |
| Causative               | •     | •      | •              | •               |
| Causative alternative   | •     |        |                |                 |
| Causative passive       | •     | •      | •              | •               |
| Provisional conditional | •     |        | •              |                 |
| Conditional             | •     | •      | •              | •               |
| Imperative              | •     | •      | •              | •               |
| Command                 | •     |        | •              |                 |
| Volitional              | •     | •      |                |                 |
| Gerund                  | •     |        |                |                 |
| Optative                | •     |        | •              |                 |


:warning: Component `Inflector` has been rewritten in 0.8, use it as below:

```php
  $entries = InflectorUtils::getEntriesFromDatabase('食べる');
  Inflector::inflect($entries[0]);

  or

  $entry = new Entry();
  $entry->setKanji('食べる');
  $entry->setKana('たべる');
  $entry->setType('v1');
  Inflector::inflect($entry);

```

## Examples

See and test each features on this [demo website](http://jpnforphpdemos.nebuleux.be).
This website is maintained by @Akeru.


## Tests

To run the test suite, you need [Composer](http://getcomposer.org/):

```bash
    $ php composer.phar install
    $ ./vendor/bin/phpunit
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
