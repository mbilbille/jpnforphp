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
                'input' => array('まっちゃ'),
                'expected' => 'matcha',
            ),
            array(
                'input' => array('けっか'),
                'expected' => 'kekka',
            ),
            array(
                'input' => array('マッチャ'),
                'expected' => 'matcha',
            ),
            array(
                'input' => array('ケッカ'),
                'expected' => 'kekka',
            ),
            array(
                'input' => array('タクシー'),
                'expected' => 'takushī',
            ),
            array(
                'input' => array('パーティー'),
                'expected' => 'pātī',
            ),
            array(
                'input' => array('サッカーをやる'),
                'expected' => 'sakkāwoyaru',
            ),
            array(
                'input' => array('サッカー　を　やる'),
                'expected' => 'sakkā wo yaru',
            ),
            array(
                'input' => array('がっこう', NULL, new MyClass()),
                'expected' => 'がっこう',
            ),
            array(
                'input' => array('がっこう', NULL, new Hepburn()),
                'expected' => 'gakkō',
            ),
            array(
                'input' => array('がっこう', NULL, new Kunrei()),
                'expected' => 'gakkô',
            ),
            array(
                'input' => array('がっこう', NULL, new Nihon()),
                'expected' => 'gakkô',
            ),
            array(
                'input' => array('サッカー　を　やる', Transliterator::HIRAGANA),
                'expected' => 'サッカー wo yaru',
            ),
            array(
                'input' => array('サッカー　を　やる', Transliterator::KATAKANA),
                'expected' => 'sakkā を やる',
            ),
        ),
        'toKana' => array(
            array(
                'input' => array('gakkou', Transliterator::HIRAGANA),
                'expected' => 'がっこう',
            ),
            array(
                'input' => array('chakku', Transliterator::KATAKANA),
                'expected' => 'チャック',
            ),
        ),
    ),
);

print process($data);

class MyClass{
    function __toString(){
        return 'MyClass';
    }
}