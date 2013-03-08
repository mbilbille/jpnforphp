#README

##What is JpnForPHP?
A tiny PHP lib which provides nice functions & wrappers to interact with Japanese language.

##Quick links
- [Official Website](http://mbilbille.github.com/jpnforphp/)

##Features list
_Complete rewrite_ ; the library is now based on 3 components

- Helper: a set of function to help you interact with Japanese wordings (split, extract, clean, etc.).
- Analyzer: various "inspecting" functions (length, count kana, etc.).
- Transliterator: handle both transliterations roman to kana and kana to roman (support all mainstream romanization systems).

##Usage

- Helper component:

```php
<?php
  use JpnForPhp\Helper\Helper;

  Helper::split('素晴らしいです'); // array('素','晴','ら','し','い','で','す')
  Helper::subString('素晴らしいです', 2, 4); // 'らし'
  Helper::extractKanji('素晴らしいです'); // array('素晴')
  Helper::extractHiragana('素晴らしいです'); // array('らしいです')
?>
```

- Analyzer component

```php
<?php
  use JpnForPhp\Analyzer\Analyzer;

  Analyzer::length('素晴らしいです'); // 7
  Analyzer::inspect('素晴らしいです'); // array('length'=>7,'kanji'=>2,'hiragana' =>5,'katakana'=>0)
  Analyzer::countHiragana('素晴らしいです'); // 5
  Analyzer::hasKanji('素晴らしいです'); // TRUE
?>
```

- Transliterator component:

```php
<?php
  use JpnForPhp\Transliterator\Transliterator;
  use JpnForPhp\Transliterator\Hepburn;
  use JpnForPhp\Transliterator\Kunrei;
  use JpnForPhp\Transliterator\Nihon;

  Transliterator::toRomaji('ローマジ で　かいて'); // rōmaji de kaite
  Transliterator::toRomaji('ローマジ　で　かいて', Transliterator::HIRAGANA, new Hepburn()); // ローマジ de kaite
  Transliterator::toRomaji('ローマジ　で　かいて', Transliterator::KATAKANA, new Hepburn()); // rōmaji で かいて
  Transliterator::toRomaji('ローマジ　で　かいて', NULL, new Kunrei()); // rômazi de kaite
  Transliterator::toRomaji('ローマジ　で　かいて', NULL, new Nihon()); // rômazi de kaite
  Transliterator::toKana('kana de kaite', Transliterator::HIRAGANA); // かな　で　かいて
  Transliterator::toKana('kana de kaite', Transliterator::KATAKANA); // カナ　デ　カイテ
?>
```


##Upcoming

Check out the _develop_ branch to get all the latest code and change (http://github.com/mbilbille/jpnforphp/tree/develop)

## License

JpnForPHP was created by [Matthieu Bilbille](http://github.com/mbilbille) and released under the [MIT License](http://github.com/mbilbille/jpnforphp/blob/master/LICENSE).

##Integration

- **JPNlizer** integrates JpnForPhp into **Drupal** - [sandbox project](http://drupal.org/sandbox/mbilbille/1613510)

Sponsored by [Openjisho.com](http://www.openjisho.com). 