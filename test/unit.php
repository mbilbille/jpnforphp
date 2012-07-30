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
$time_start = microtime(true);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>JpnForPhp library - unit tests</title>
        <style>
            body {
                font-family: sans-serif;
                font-size: 12px;
                background: #f2f2f2;
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
                background: #fff;
                width: 31%;
                padding: 5px;
            }
            td.heading{
                background: #e4e4e4;
                font-weight: bold;
                padding: 10px;
                border-top-width: 3px;
            }
            td.pass,
            td.fail{
                width: 6%;
            }
            td.fail{
                background: #CF4425;
            }
            td.pass{
                background: #52964F;
            }
            p.info{
                color: #888;
                font-style: italic;
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
                <td colspan="3" class="heading">Function countKanji()</td>
            </tr>
            <?php print unit('countKanji', array('中学校'), 3); ?>
            <?php print unit('countKanji', array('車'), 1); ?>
            <?php print unit('countKanji', array('食べる'), 1); ?>
            <tr>
                <td colspan="3" class="heading">Function countHiragana()</td>
            </tr>
            <?php print unit('countHiragana', array('がっこう'), 4); ?>
            <?php print unit('countHiragana', array('でんき'), 3); ?>
			<?php print unit('countHiragana', array('食べる'), 2); ?>
			<?php print unit('countHiragana', array('ぁぃぅぇぉ'), 5); ?>
			<tr>
                <td colspan="3" class="heading">Function countKatakana()</td>
            </tr>
            <?php print unit('countKatakana', array('ビール'), 3); ?>
            <?php print unit('countKatakana', array('サッカー'), 4); ?>
			<?php print unit('countKatakana', array('ｶｷｸｹｺ'), 5); ?>
			<?php print unit('countKatakana', array('㋐'), 1); ?>
			<?php print unit('countKatakana', array('㌒㌕'), 2); ?>
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
                <td colspan="3" class="heading">Function hasJapaneseChars()</td>
            </tr>
            <?php print unit('hasJapaneseChars', array('学校'), TRUE); ?>
            <?php print unit('hasJapaneseChars', array('がっこう'), TRUE); ?>
            <?php print unit('hasJapaneseChars', array('ガッコウ'), TRUE); ?>
            <?php print unit('hasJapaneseChars', array('私は学生です'), TRUE); ?>
            <?php print unit('hasJapaneseChars', array('gakkou'), FALSE); ?>
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
                <td colspan="3" class="heading">Function length()</td>
            </tr>
            <?php print unit('length', array('がっこう'), 4); ?>
            <?php print unit('length', array('会社にいます'), 6); ?>
            <tr>
                <td colspan="3" class="heading">Function charAt()</td>
            </tr>
            <?php print unit('charAt', array('がっこう', 2), 'こ'); ?>
            <?php print unit('charAt', array('会社にいます', 0), '会'); ?>
            <tr>
                <td colspan="3" class="heading">Function subString()</td>
            </tr>
            <?php print unit('subString', array('がっこう', 2, 4), 'こう'); ?>
            <?php print unit('subString', array('会社にいます', 0, 3), '会社に'); ?>
            <tr>
                <td colspan="3" class="heading">Function inspect()</td>
            </tr>
            <?php print unit('inspect', array('がっこう'), array('length' => 4,'kanji' => 0,'hiragana' => 4,'katakana' => 0)); ?>
            <?php print unit('inspect', array('私はマテューです。'), array('length' => 9,'kanji' => 1,'hiragana' => 3,'katakana' => 4)); ?>
			<tr>
				<td colspan="3" class="heading">Function removeLTRM()</td>
			</tr>
			<?php print unit('removeLTRM', array("Kyōto\xe2\x80\x8e"), 'Kyōto'); ?>
			<tr>
				<td colspan="3" class="heading">Function removeDiacritics()</td>
			</tr>
			<?php print unit('removeDiacritics', array('Kyōto'), 'Kyoto'); ?>
			<?php print unit('removeDiacritics', array('Chūō-Sōbu'), 'Chuo-Sobu'); ?>
			<?php print unit('removeDiacritics', array('Noël, Pâques, Été, Cachaça, Háček'), 'Noel, Paques, Ete, Cachaca, Hacek'); ?>
        </table>
        <?php $time_end = microtime(true);?>
        <div style="position:absolute;top:5px;right: 15px;"><p class="info">Execution time: <?php print $time_end - $time_start;?> second(s)</p></div>
    </body>
</html>
