<?php require_once "bootstrap.php";

use JpnForPhp\Transliterator\Transliterator;
use JpnForPhp\Transliterator\Hepburn;
use JpnForPhp\Transliterator\Kunrei;
use JpnForPhp\Transliterator\Nihon;

$data = array(
    'namespace' => 'JpnForPhp\\Transliterator\\Transliterator',
    'functions' => array(
        'toRomaji' => array(
            array(
                'description' => 'Default',
                'cases' => array(
                    array(
                        'input' => array(''),
                        'expected' => '',
                    ),
                    array(
                        'input' => array('くるま'),
                        'expected' => 'kuruma',
                    ),
                    array(
                        'input' => array('くるま', NULL, new Hepburn()),
                        'expected' => 'kuruma',
                    ),
                ),
            ),
            array(
                'description' => 'using Hepburn romanization system',
                'cases' => array(
                    array(
                        'input' => array('がっこう', NULL, new Hepburn()),
                        'expected' => 'gakkō',
                    ),
                    array(
                        'input' => array('おばあさん', NULL, new Hepburn()),
                        'expected' => 'obāsan',
                    ),
                                array(
                        'input' => array('まっちゃ', NULL, new Hepburn()),
                        'expected' => 'matcha',
                    ),
                    array(
                        'input' => array('けっか', NULL, new Hepburn()),
                        'expected' => 'kekka',
                    ),
                    array(
                        'input' => array('マッチャ', NULL, new Hepburn()),
                        'expected' => 'matcha',
                    ),
                    array(
                        'input' => array('ケッカ', NULL, new Hepburn()),
                        'expected' => 'kekka',
                    ),
                    array(
                        'input' => array('タクシー', NULL, new Hepburn()),
                        'expected' => 'takushī',
                    ),
                    array(
                        'input' => array('パーティー', NULL, new Hepburn()),
                        'expected' => 'pātī',
                    ),
                    array(
                        'input' => array('サッカーをやる', NULL, new Hepburn()),
                        'expected' => 'sakkāwoyaru',
                    ),
                    array(
                        'input' => array('サッカー　を　やる', NULL, new Hepburn()),
                        'expected' => 'sakkā o yaru',
                    ),
                    array(
                        'input' => array('あんない', NULL, new Hepburn()),
                        'expected' => 'annai',
                    ),
                    array(
                        'input' => array('きんえん', NULL, new Hepburn()),
                        'expected' => "kin'en",
                    ),
                    array(
                        'input' => array('ファッションショー', NULL, new Hepburn()),
                        'expected' => "fasshonshō",
                    ),
                ),
            ),
            array(
                'description' => 'using Kunrei romanization system',
                'cases' => array(
                    array(
                        'input' => array('がっこう', NULL, new Kunrei()),
                        'expected' => 'gakkô',
                    ),
                    array(
                        'input' => array('かんよう', NULL, new Kunrei()),
                        'expected' => "kan'yô",
                    ),
                    array(
                        'input' => array('かにょう', NULL, new Kunrei()),
                        'expected' => "kanyô",
                    ),
                    array(
                        'input' => array('おおきい', NULL, new Kunrei()),
                        'expected' => "ôkii",
                    ),
                    array(
                        'input' => array('「ほしい」', NULL, new Kunrei()),
                        'expected' => '"hosii"',
                    ),
                    array(
                        'input' => array('まっちゃ', NULL, new Kunrei()),
                        'expected' => 'mattya',
                    ),
                    array(
                        'input' => array('マッチャ', NULL, new Kunrei()),
                        'expected' => 'mattya',
                    ),
                    array(
                        'input' => array('ケッカ', NULL, new Kunrei()),
                        'expected' => 'kekka',
                    ),
                    array(
                        'input' => array('ローマジ', NULL, new Kunrei()),
                        'expected' => 'rômazi',
                    ),
                    array(
                        'input' => array('フライドポテト', NULL, new Kunrei()),
                        'expected' => 'huraidopoteto',
                    ),
                    array(
                        'input' => array('ファッションショー', NULL, new Kunrei()),
                        'expected' => "huァssyonsyô",
                    ),
                    array(
                        'input' => array('かなづかい', NULL, new Kunrei()),
                        'expected' => "kanazukai",
                    ),
                    array(
                        'input' => array('しごと　は　たのしい　です', NULL, new Kunrei()),
                        'expected' => "sigoto wa tanosii desu",
                    ),
                    array(
                        'input' => array('しごと　を　します', NULL, new Kunrei()),
                        'expected' => "sigoto o simasu",
                    ),
                    array(
                        'input' => array('しごと　へ　いきます', NULL, new Kunrei()),
                        'expected' => "sigoto e ikimasu",
                    ),
                ),
            ),
            array(
                'description' => 'using Nihon romanization system',
                'cases' => array(
                    array(
                        'input' => array('がっこう', NULL, new Nihon()),
                        'expected' => 'gakkô',
                    ),
                                        array(
                        'input' => array('かんよう', NULL, new Nihon()),
                        'expected' => "kan'yô",
                    ),
                    array(
                        'input' => array('かにょう', NULL, new Nihon()),
                        'expected' => "kanyô",
                    ),
                    array(
                        'input' => array('おおきい', NULL, new Nihon()),
                        'expected' => "ôkii",
                    ),
                    array(
                        'input' => array('「ほしい」', NULL, new Nihon()),
                        'expected' => '"hosii"',
                    ),
                    array(
                        'input' => array('まっちゃ', NULL, new Nihon()),
                        'expected' => 'mattya',
                    ),
                    array(
                        'input' => array('マッチャ', NULL, new Nihon()),
                        'expected' => 'mattya',
                    ),
                    array(
                        'input' => array('ケッカ', NULL, new Nihon()),
                        'expected' => 'kekka',
                    ),
                    array(
                        'input' => array('ローマジ', NULL, new Nihon()),
                        'expected' => 'rômazi',
                    ),
                    array(
                        'input' => array('フライドポテト', NULL, new Nihon()),
                        'expected' => 'huraidopoteto',
                    ),
                    array(
                        'input' => array('ファッションショー', NULL, new Nihon()),
                        'expected' => "huァssyonsyô",
                    ),
                    array(
                        'input' => array('かなづかい', NULL, new Nihon()),
                        'expected' => "kanadukai",
                    ),
                    array(
                        'input' => array('しごと　は　たのしい　です', NULL, new Nihon()),
                        'expected' => "sigoto ha tanosii desu",
                    ),
                    array(
                        'input' => array('しごと　を　します', NULL, new Nihon()),
                        'expected' => "sigoto wo simasu",
                    ),
                    array(
                        'input' => array('しごと　へ　いきます', NULL, new Nihon()),
                        'expected' => "sigoto he ikimasu",
                    ),
                ),
            ),
            array(
                'description' => 'forcing syllabary',
                'cases' => array(
                    array(
                        'input' => array('サッカー　を　やる', Transliterator::HIRAGANA),
                        'expected' => 'サッカー o yaru',
                    ),
                    array(
                        'input' => array('サッカー　を　やる', Transliterator::KATAKANA),
                        'expected' => 'sakkā を やる',
                    ),
                ),
            ),
            array(
                'description' => 'hotfix #14',
                'cases' => array(
                    array(
                        'input' => array('ヤフー　yahoo YAHOO', NULL, new Hepburn()),
                        'expected' => 'yafū yahoo YAHOO',
                    ),
                    array(
                        'input' => array('ヤフー　yahoo YAHOO', NULL, new Kunrei()),
                        'expected' => 'yahû yahoo YAHOO',
                    ),
                    array(
                        'input' => array('ヤフー　yahoo YAHOO', NULL, new Nihon()),
                        'expected' => 'yahû yahoo YAHOO',
                    ),
                ),
            ),
        ),
        'toKana' => array(
            array(
                'description' => 'Hiragana',
                'cases' => array(
                    array(
                        'input' => array('gakkou', Transliterator::HIRAGANA),
                        'expected' => 'がっこう',
                    ),
                    array(
                        'input' => array('obāsan', Transliterator::HIRAGANA),
                        'expected' => 'おばあさん',
                    ),
                    array(
                        'input' => array('gakkō ni ikimasu', Transliterator::HIRAGANA),
                        'expected' => 'がっこう　に　いきます',
                    ),
                    array(
                        'input' => array('"iie"toiimashita', Transliterator::HIRAGANA),
                        'expected' => '「いいえ」といいました',
                    ),
                ),
            ),
            array(
                'description' => 'Katakana',
                'cases' => array(
                    array(
                        'input' => array('chakku', Transliterator::KATAKANA),
                        'expected' => 'チャック',
                    ),
                    array(
                        'input' => array('sakkaa', Transliterator::KATAKANA),
                        'expected' => 'サッカー',
                    ),
                    array(
                        'input' => array('sakkā', Transliterator::KATAKANA),
                        'expected' => 'サッカー',
                    ),
                    array(
                        'input' => array('foodo', Transliterator::KATAKANA),
                        'expected' => 'フォード',
                    ),
                    array(
                        'input' => array('fōdo', Transliterator::KATAKANA),
                        'expected' => 'フォード',
                    ),
                    array(
                        'input' => array('fôdo', Transliterator::KATAKANA),
                        'expected' => 'フォード',
                    ),
                ),
            ),
        ),
    ),
);

print process($data);
