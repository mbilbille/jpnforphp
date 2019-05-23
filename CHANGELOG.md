# CHANGELOG

This changelog references the relevant changes (bug and security fixes) done

* 0.8.1 (2019-05-23)
  * 774f7100f8c76198b03de998be7daaaeebcb5b0b Bug fix #71
  * e6853c1043107606f4671da88b6d8641f9dbcd0b Drop support of PHP version < 7.1
  * d7823d456c7412892ef476e5dd74171d37e5ef9b Upgrade to PHPUnit 7.5

* 0.8.0 (2017-07-26)
  * b61aed35f99d1508414ffc02a66f42233bae7800 `Inflector` refactoring
  * d202abcab072ed799937ce073c7b4468d6073d18 2c49a53f571bc429b15685e9729c720f87a158ae 8db78f3d60112ce455328afa995e6ad7e8386a79 Bug fix #67
  * d202abcab072ed799937ce073c7b4468d6073d18 2c49a53f571bc429b15685e9729c720f87a158ae 8db78f3d60112ce455328afa995e6ad7e8386a79 Bug fix #66
  * 29f84bc0379011404362acecef8caa49971d08ee Bug fix #65
  * 29f84bc0379011404362acecef8caa49971d08ee Bug fix #64

* 0.7.0 (2017-05-25)
  * 2fca1f7 Drop support of PHP 5.3
  * 3a4364f `Transliterator` refactoring
  * 403eb84 Bug fix #62
  * 8fe5d6b Bug fix #59

* 0.6.2 (2017-05-10)
  * 7b943f9 `Converter`: Fix toWesternYear on Windows
  * 3dcbee8 3ddfc86 `Converter`: support large integer
  * d457d15 PR #63 `Transliterator`: Flush latin characters buffer
  * 0666fe0 Bug fix #58

* 0.6.1 (2016-02-06)
  * 144807a Bug fix #57
  * c4568a2 Bug fix #46

* 0.6.0 (2015-08-18)
  * bd2b872 cff3de7 Bug fix #41
  * a09fd39 Bug fix #42
  * a754e6d Bug fix #43
  * f2a879b Add helper method `countSubString()`
  * cde9ec7 Add component `Converter`
  * 804b8e7 Add component `Inflector`

* 0.5.3 (2015-03-05)
  * 8a2f4f9 Bug fix #38

* 0.5.2 (2014-04-18)
  * de3d50a Bug fix #36
  * 507f8b7 Add hiragana to katakana convertor and vice versa
  * 547bdaa Revise split and extract methods

* 0.5.1 (2013-11-03)
  * f0bd7ec Fix mapping error on フォ

* 0.5.0 (2013-11-03)
  * 20e5c3b Move transliteration workflow definiton into Yaml file
  * 669b893 Bug fix #24
  * e1657fe Add Wapuro romanization system
  * dc1ce62 Bug fix #20
  * 07e0c24 Bug fix #19
  * b100fe8 Support for PHPUnit
  * 359a366 Support for Travis

* 0.4.1 (2013-03-08)
  * 9970077 Bug fix #14

* 0.4.0 (2012-11-14)
  * 1fb1cad Support for Composer
  * cc58295 Add Nihon romanization system
  * 9d5dbb3 Add Kunrei romanization system
  * 0585db0 Finalize Hepburn transliterator
  * b794ba4 Completely rewrite the tests system
  * cea751f Complete refactoring
