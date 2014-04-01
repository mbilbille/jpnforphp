#JpnForPhp [![build status](https://secure.travis-ci.org/mbilbille/jpnforphp.png)](http://travis-ci.org/mbilbille/jpnforphp) [![Stories in Ready](https://badge.waffle.io/mbilbille/jpnforphp.png?label=ready)](https://waffle.io/mbilbille/jpnforphp) [![Bitdeli Badge](https://d2weczhvl823v0.cloudfront.net/mbilbille/jpnforphp/trend.png)](https://bitdeli.com/free "Bitdeli Badge")

> A tiny PHP lib which provides nice functions & wrappers to interact with Japanese language. [[Official Website](http://mbilbille.github.com/jpnforphp/)]

##Installation
```bash
composer install
```

##Features list
Provides the following components:

- Helper: a set of function to help you interact with Japanese wordings (split, extract, clean, etc.).
- Analyzer: various "inspecting" functions (length, count kana, etc.).
- Transliterator: handle both transliterations roman to kana and kana to roman (support all mainstream romanization systems).

##Usage

###Helper component:

```php
use JpnForPhp\Helper\Helper;

Helper::split('素晴らしいです'); // array('素','晴','ら','し','い','で','す')
Helper::subString('素晴らしいです', 2, 4); // 'らし'
Helper::extractKanji('素晴らしいです'); // array('素晴')
Helper::extractHiragana('素晴らしいです'); // array('らしいです')
```

###Analyzer component

```php
use JpnForPhp\Analyzer\Analyzer;

Analyzer::length('素晴らしいです'); // 7
Analyzer::inspect('素晴らしいです'); // array('length'=>7,'kanji'=>2,'hiragana' =>5,'katakana'=>0)
Analyzer::countHiragana('素晴らしいです'); // 5
Analyzer::hasKanji('素晴らしいです'); // TRUE
```

###Transliterator component:

```php
use JpnForPhp\Transliterator\Romaji;
use JpnForPhp\Transliterator\Kana;

$hepburn = new Romaji();
$kunrei = new Romaji('kunrei');
$hiragana = new Kana('hiragana');
$katakana = new Kana('katakana');

$hepburn->transliterate('ローマジ で　かいて'); // rōmaji de kaite
$kunrei->transliterate('ローマジ　で　かいて'); // rômazi de kaite
$hiragana->transliterate('kana de kaite'); // かな　で　かいて
$katakana->transliterate('kana de kaite'); // カナ　デ　カイテ
```

Starting from the version 0.5, all the transliteration workflow is defined in ```.yaml``` file.

```Romaji.php``` and ```Kana.php``` provides a wild range of functions which can be used to define your own transliteration system.
Here is a sample ```.yaml``` file

```yaml
id: mySystem
name:
    english: "My romanization system"
    japanese: "マイローマ字"
workflow:
    - function: transliterateDefaultCharacters
      parameters:
            mapping:
                あ: a
                い: i
                // [...]
                ぽ: po
                ゔ: pu
    - function: transliterateSokuon
      parameters:
            default: true
            hepburn: false
    - function: transliterateChoonpu
      parameters:
        macrons:
            a: aa
            i: ii
            u: uu
            e: ee
            o: oo
```

JpnForPhp supports the following standard transliteration system:
- [Hepburn](http://en.wikipedia.org/wiki/Hepburn_romanization)
- [Kunrei](http://en.wikipedia.org/wiki/Kunrei-shiki_romanization)
- [Nihon](http://en.wikipedia.org/wiki/Nihon-shiki_romanization)
- [Wapuro](http://en.wikipedia.org/wiki/W%C4%81puro_r%C5%8Dmaji)
- [JSL](http://en.wikipedia.org/wiki/JSL_romanization) _yet to be implemented_

```.yaml``` files for those transliteration systems are available here:
- [hepburn](src/JpnForPhp/Transliterator/Romaji/hepburn.yaml)
- [kunrei](src/JpnForPhp/Transliterator/Romaji/kunrei.yaml)
- [nihon](src/JpnForPhp/Transliterator/Romaji/nihon.yaml)
- [wapuro](src/JpnForPhp/Transliterator/Romaji/wapuro.yaml)
- [hiragana](src/JpnForPhp/Transliterator/Romaji/hiragana.yaml)
- [katakana](src/JpnForPhp/Transliterator/Romaji/katakana.yaml)


##Upcoming

Check out the _develop_ branch to get all the latest code and change (http://github.com/mbilbille/jpnforphp/tree/develop)

## License

JpnForPHP was created by [Matthieu Bilbille](http://github.com/mbilbille) and released under the [MIT License](http://github.com/mbilbille/jpnforphp/blob/master/LICENSE).

##Integration

- **JPNlizer** integrates JpnForPhp into **Drupal** - [sandbox project](http://drupal.org/sandbox/mbilbille/1613510)
- **JpnForPhpBundle**: integrates JpnForPhp as a Symfony2 Bundle - [JpnForPhpBundle](http://github.com/albertofem/JpnForPhpBundle)

Sponsored by [Openjisho.com](http://www.openjisho.com).
