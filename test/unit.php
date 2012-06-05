<?php
include_once '../jpnforphp.php';

function unit($function, $inputs, $expected_result)
{
    $result = call_user_func_array("JpnForPhp::$function", $inputs);
    $css = ($result === $expected_result) ? "pass" : "fail";
    $output = '<tr>
    <td>' . implode(' | ', $inputs) . '</td>
    <td>' . var_export($expected_result, true) . '</td>
    <td>' . var_export($result, true) . '</td>
    <td class="' . $css . '"></td>
    </tr>';

    return $output;
}
?>
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
                <td colspan="3" class="heading">Function hasKanji()</td>
            </tr>
            <?php print unit('hasKanji', array('学校'), TRUE); ?>
            <?php print unit('hasKanji', array('がっこう ガッコウ gakkou'), FALSE); ?>
            <tr>
                <td colspan="3" class="heading">Function hasHiragana()</td>
            </tr>
            <?php print unit('hasHiragana', array('がっこう'), TRUE); ?>
            <?php print unit('hasHiragana', array('学校　ガッコウ gakkou'), FALSE); ?>
            <tr>
                <td colspan="3" class="heading">Function hasKatakana()</td>
            </tr>
            <?php print unit('hasKatakana', array('ガッコウ'), TRUE); ?>
            <?php print unit('hasKatakana', array('学校　がっこう gakkou'), FALSE); ?>
            <tr>
                <td colspan="3" class="heading">Function isJapanese()</td>
            </tr>
            <?php print unit('isJapanese', array('学校'), TRUE); ?>
            <?php print unit('isJapanese', array('がっこう'), TRUE); ?>
            <?php print unit('isJapanese', array('ガッコウ'), TRUE); ?>
            <?php print unit('isJapanese', array('私は学生です'), TRUE); ?>
            <?php print unit('isJapanese', array('gakkou'), FALSE); ?>
            <tr>
                <td colspan="3" class="heading">Function romajiToHiragana()</td>
            </tr>
            <?php print unit('romajiToHiragana', array('gakkou'), 'がっこう'); ?>
            <?php print unit('romajiToHiragana', array('watashi ha gakusei desu'), 'わたし　は　がくせい　です'); ?>
            <tr>
                <td colspan="3" class="heading">Function romajiToKatakana()</td>
            </tr>
            <?php print unit('romajiToKatakana', array('furansu'), 'フランス'); ?>
            <?php print unit('romajiToKatakana', array('watashi ha furansujin desu'), 'ワタシ　ハ　フランスジン　デス'); ?>
            <tr>
                <td colspan="3" class="heading">Function hiraganaToRomaji()</td>
            </tr>
            <?php print unit('hiraganaToRomaji', array('がっこう'), 'gakkou'); ?>
            <?php print unit('hiraganaToRomaji', array('かいしゃ　に　います'), 'kaisha ni imasu'); ?>
            <?php print unit('hiraganaToRomaji', array('会社にいます'), '会社niimasu'); ?>
            <tr>
            <tr>
                <td colspan="3" class="heading">Function katakanaToRomaji()</td>
            </tr>
            <?php print unit('katakanaToRomaji', array('ガッコウ'), 'gakkou'); ?>
            <?php print unit('katakanaToRomaji', array('カイシャニイマス'), 'kaishaniimasu'); ?>
            <tr>
                <td colspan="3" class="heading">Function split()</td>
            </tr>
            <?php print unit('split', array('がっこう'), array('が', 'っ', 'こ', 'う')); ?>
            <tr>
                <td colspan="3" class="heading">Function strlen()</td>
            </tr>
            <?php print unit('strlen', array('がっこう'), 4); ?>
            <?php print unit('strlen', array('会社にいます'), 6); ?>
            <tr>
                <td colspan="3" class="heading">Function charAt()</td>
            </tr>
            <?php print unit('charAt', array('がっこう', 2), 'こ'); ?>
            <?php print unit('charAt', array('会社にいます', 0), '会'); ?>
        </table>
    </body>
</html>
