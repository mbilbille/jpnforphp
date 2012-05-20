<?php include_once '../jpnforphp.php'; ?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>JpnForPhp library - unit tests</title>
        <style>
            body {
                font-family: sans-serif;
                font-size: 12px;
            }
            table {
                border: 1px solid #bbb;
                width: 600px;
                margin: 30px auto 0 auto;
                border-collapse: collapse;
                border-spacing: 0;
            }
            td, th{
                border: 1px solid #bbb;
                width: 33%;
            }
            td.heading{
                background: #e4e4e4;
                font-weight: bold;
                padding: 10px;
            }
            td.fail{
                background: #CF4425;
            }
            td.pass{
                background: #52964F;
            }
        </style>
    </head>
    <body>
        <h1>JpnForPhp library - Unit tests</h1>
        <table>
            <tr>
                <th>Inputs</th>
                <th>Expected results</th>
                <th>Results</th>
            </tr>
            <tr>
                <td colspan="3" class="heading">Function has_kanji()</td>
            </tr>
            <?php print unit('has_kanji', '学校', TRUE); ?>
            <?php print unit('has_kanji', 'がっこう ガッコウ gakkou', FALSE); ?>
            <tr>
                <td colspan="3" class="heading">Function has_hiragana()</td>
            </tr>
            <?php print unit('has_hiragana', 'がっこう', TRUE); ?>
            <?php print unit('has_hiragana', '学校　ガッコウ gakkou', FALSE); ?>
            <tr>
                <td colspan="3" class="heading">Function has_katakana()</td>
            </tr>
            <?php print unit('has_katakana', 'ガッコウ', TRUE); ?>
            <?php print unit('has_katakana', '学校　がっこう gakkou', FALSE); ?>
            <tr>
                <td colspan="3" class="heading">Function is_japanese()</td>
            </tr>
            <?php print unit('is_japanese', '学校', TRUE); ?>
            <?php print unit('is_japanese', 'がっこう', TRUE); ?>
            <?php print unit('is_japanese', 'ガッコウ', TRUE); ?>
            <?php print unit('is_japanese', '私は学生です', TRUE); ?>
            <?php print unit('is_japanese', 'gakkou', FALSE); ?>
            <tr>
                <td colspan="3" class="heading">Function romaji_to_hiragana()</td>
            </tr>
            <?php print unit('romaji_to_hiragana', 'gakkou', 'がっこう'); ?>
            <?php print unit('romaji_to_hiragana', 'watashi ha gakusei desu', 'わたし　は　がくせい　です'); ?>
            <tr>
                <td colspan="3" class="heading">Function romaji_to_katakana()</td>
            </tr>
            <?php print unit('romaji_to_katakana', 'furansu', 'フランス'); ?>
            <?php print unit('romaji_to_katakana', 'watashi ha furansujin desu', 'ワタシ　ハ　フランスジン　デス'); ?>
            <tr>
                <td colspan="3" class="heading">Function hiragana_romaji()</td>
            </tr>
            <?php print unit('hiragana_to_romaji', 'がっこう', 'gakkou'); ?>
            <?php print unit('hiragana_to_romaji', 'かいしゃ　に　います', 'kaisha ni imasu'); ?>
            <?php print unit('hiragana_to_romaji', '会社にいます', '会社niimasu'); ?>
            <tr>
            <tr>
                <td colspan="3" class="heading">Function katakana_romaji()</td>
            </tr>
            <?php print unit('katakana_to_romaji', 'ガッコウ', 'gakkou'); ?>
            <?php print unit('katakana_to_romaji', 'カイシャニイマス', 'kaishaniimasu'); ?>
            <tr>
                <td colspan="3" class="heading">Function split()</td>
            </tr>
            <?php print unit('split', 'がっこう', array('が','っ','こ','う')); ?>
        </table>
    </body>
</html>
<?php

function unit($function, $input, $expected_result) {

    $result = JpnForPhp::$function($input);
    $css = ($result === $expected_result) ? "pass" : "fail";
    $output = '<tr>
    <td>' . $input . '</td>
    <td>' . var_export($expected_result, true) . '</td>
    <td>' . var_export($result, true) . '</td>
    <td class="' . $css . '"></td>
    </tr>';
    return $output;
}