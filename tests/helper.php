<?php require_once "bootstrap.php";

$data = array(
    'namespace' => 'JpnForPhp\\Helper\\Helper',
    'functions' => array(
        'split' => array(
            array(
                'input' => array('マテューは学校にいます'),
                'expected' => array('マ', 'テ', 'ュ', 'ー', 'は', '学', '校', 'に', 'い', 'ま', 'す'),
            ),
        ),
        'charAt' => array(
            array(
                'input' => array('がっこう', 2),
                'expected' => 'こ',
            ),
            array(
                'input' => array('会社にいます', 0),
                'expected' => '会',
            ),
            array(
                'input' => array('会社にいます', -1),
                'expected' => 'す',
            ),
        ),
        'subString' => array(
            array(
                'input' => array('がっこう', 2, 4),
                'expected' => 'こう',
            ),
            array(
                'input' => array('会社にいます', 0, 3),
                'expected' => '会社に',
            ),
            array(
                'input' => array('会社にいます', -3, 3),
                'expected' => 'います',
            ),
        ),
        'extractKanji' => array(
            array(
                'input' => array('学校'),
                'expected' => array('学校'),
            ),
            array(
                'input' => array('学校に行きます'),
                'expected' => array('学校', '行'),
            ),
        ),
        'extractHiragana' => array(
            array(
                'input' => array('学校'),
                'expected' => array(),
            ),
            array(
                'input' => array('学校に行きます'),
                'expected' => array('に', 'きます'),
            ),
        ),
        'extractKatakana' => array(
            array(
                'input' => array('学校'),
                'expected' => array(),
            ),
            array(
                'input' => array('サッカーをやる'),
                'expected' => array('サッカー'),
            ),
        ),
        'removeLTRM' => array(
            array(
                'input' => array("Kyōto\xe2\x80\x8e"),
                'expected' => 'Kyōto',
            ),
        ),
        'removeDiacritics' => array(
            array(
                'input' => array('Kyōto'),
                'expected' => 'Kyoto',
            ),
            array(
                'input' => array('Chūō-Sōbu'),
                'expected' => 'Chuo-Sobu',
            ),
            array(
                'input' => array('Noël, Pâques, Été, Cachaça, Háček'),
                'expected' =>  'Noel, Paques, Ete, Cachaca, Hacek',
            ),  
            array(
                'input' => array('ÁÀÂÄÃÅÇÉÈÊËÍÏÎÌÑÓÒÔÖÕÚÙÛÜÝŸ'),
                'expected' =>  'AAAAAACEEEEIIIINOOOOOUUUUYY',
            ),
            array(
                'input' => array('áàâäãåçéèêëíìîïñóòôöõúùûüýÿ'),
                'expected' =>  'aaaaaaceeeeiiiinooooouuuuyy',
            ),
        ),
    ),
);

print process($data);