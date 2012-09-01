<?php require_once "bootstrap.php";

$data = array(
    'namespace' => 'JpnForPhp\\Analyzer\\Analyzer',
    'functions' => array(
        'countKanji' => array(
            array(
                'input' => array('中学校'),
                'expected' => 3,
            ),
            array(
                'input' => array('車'),
                'expected' => 1,
            ),
            array(
                'input' => array('食べる'),
                'expected' => 1,
            ),
        ),
        'countHiragana' => array(
            array(
                'input' => array('がっこう'),
                'expected' => 4,
            ),
            array(
                'input' => array('でんき'),
                'expected' => 3,
            ),
            array(
                'input' => array('食べる'),
                'expected' => 2,
            ),
            array(
                'input' => array('ぁぃぅぇぉ'),
                'expected' => 5,
            ),
        ),
        'countKatakana' => array(
            array(
                'input' => array('ビール'),
                'expected' => 3,
            ),
            array(
                'input' => array('ー'),
                'expected' => 1,
            ),
            array(
                'input' => array('サッカー'),
                'expected' => 4,
            ),
            array(
                'input' => array('ｶｷｸｹｺ'),
                'expected' => 5,
            ),
            array(
                'input' => array('㋐'),
                'expected' => 1,
            ),
            array(
                'input' => array('㌒㌕'),
                'expected' => 2,
            ),
        ),
        'hasKanji' => array(
            array(
                'input' => array('学校'),
                'expected' => TRUE,
            ),
            array(
                'input' => array('がっこう ガッコウ gakkou'),
                'expected' => FALSE,
            ),
        ),
        'hasHiragana' => array(
            array(
                'input' => array('がっこう'),
                'expected' => TRUE,
            ),
            array(
                'input' => array('学校　がっこう gakkou'),
                'expected' => TRUE,
            ),
            array(
                'input' => array('学校　ガッコウ gakkou'),
                'expected' => FALSE,
            ),
        ),
        'hasKatakana' => array(
            array(
                'input' => array('ガッコウ'),
                'expected' => TRUE,
            ),
            array(
                'input' => array('学校　がっこう gakkou'),
                'expected' => FALSE,
            ),
            array(
                'input' => array('学校ガッコウgakkou'),
                'expected' => TRUE,
            ),
            array(
                'input' => array('ー'),
                'expected' => TRUE,
            ),
        ),
        'hasKana' => array(
            array(
                'input' => array('学校　がっこう gakkou'),
                'expected' => TRUE,
            ),
            array(
                'input' => array('学校'),
                'expected' => FALSE,
            ),
            array(
                'input' => array('gakkou'),
                'expected' => FALSE,
            ),
        ),
        'hasJapaneseChars' => array(
            array(
                'input' => array('学校'),
                'expected' => TRUE,
            ),
            array(
                'input' => array('がっこう'),
                'expected' => TRUE,
            ),
            array(
                'input' => array('ガッコウ'),
                'expected' => TRUE,
            ),
            array(
                'input' => array('私は学生です'),
                'expected' => TRUE,
            ),
            array(
                'input' => array('。'),
                'expected' => FALSE,
            ),
            array(
                'input' => array('gakkou'),
                'expected' => FALSE,
            ),
        ),
        'length' => array(
            array(
                'input' => array('がっこう'),
                'expected' => 4,
            ),
            array(
                'input' => array('会社にいます'),
                'expected' => 6,
            ),
        ),
        'inspect' => array(
            array(
                'input' => array('がっこう'),
                'expected' => array('length' => 4, 'kanji' => 0, 'hiragana' => 4, 'katakana' => 0),
            ),
            array(
                'input' => array('私はマテューです。'),
                'expected' => array('length' => 9, 'kanji' => 1, 'hiragana' => 3, 'katakana' => 4),
            ),
        ),
    ),
);

print process($data);