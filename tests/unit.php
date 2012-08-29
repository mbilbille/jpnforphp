<?php
use JpnForPhp\JpnForPhp;

require_once '../src/JpnForPhp.php';

global $check; $check = "pass";

function unit($function, $inputs, $expected_result)
{
    global $check;
    $fn_time_start = microtime(true);
    $result = call_user_func_array("JpnForPhp\JpnForPhp::$function", $inputs);
    if ($result === $expected_result) {
        $css = "pass";
    } else {
        $css = "fail";
        $check = $css;
    }
    $output = '<tr>
    <td>' . implode(' | ', $inputs) . '</td>
    <td>' . var_export($expected_result, true) . '</td>
    <td>' . var_export($result, true) . '</td>
    <td class="timer">' . number_format((microtime(true) - $fn_time_start), 10) . '</td>
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
                width: 90%;
                margin: 30px auto 0 auto;
                border-collapse: collapse;
                border-spacing: 0;
            }
            td, th{
                border: 1px solid #bbb;
                background: #fff;
                width: 28%;
                padding: 5px;
            }
            td.heading{
                background: #e4e4e4;
                font-weight: bold;
                padding: 10px;
                border-top-width: 3px;
            }
            td.timer{
                width: 10%;
            }
            td.pass,
            td.fail{
                width: 6%;
            }
            .fail{
                background: #FF6140;
                color: #A61D00 !important;
            }
            .pass{
                background: #A4F43D;
                color: #569700 !important;
            }
            p.info{
                font-style: italic;
                border-radius: 15px;
                padding: 7px 12px;
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
            <?php print unit('countKatakana', array('ー'), 1); ?>
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
            <?php print unit('hasHiragana', array('学校　がっこう gakkou'), TRUE); ?>
            <?php print unit('hasHiragana', array('学校　ガッコウ gakkou'), FALSE); ?>
            <tr>
                <td colspan="3" class="heading">Function hasKatakana()</td>
            </tr>
            <?php print unit('hasKatakana', array('ガッコウ'), TRUE); ?>
            <?php print unit('hasKatakana', array('学校　がっこう gakkou'), FALSE); ?>
            <?php print unit('hasKatakana', array('学校ガッコウgakkou'), TRUE); ?>
            <?php print unit('hasKatakana', array('ー'), TRUE); ?>
            <tr>
                <td colspan="3" class="heading">Function hasKana()</td>
            </tr>
            <?php print unit('hasKana', array('学校　がっこう gakkou'), TRUE); ?>
            <?php print unit('hasKana', array('学校'), FALSE); ?>
            <?php print unit('hasKana', array('gakkou'), FALSE); ?>
            <tr>
                <td colspan="3" class="heading">Function hasJapaneseChars()</td>
            </tr>
            <?php print unit('hasJapaneseChars', array('学校'), TRUE); ?>
            <?php print unit('hasJapaneseChars', array('がっこう'), TRUE); ?>
            <?php print unit('hasJapaneseChars', array('ガッコウ'), TRUE); ?>
            <?php print unit('hasJapaneseChars', array('私は学生です'), TRUE); ?>
            <?php print unit('hasJapaneseChars', array('gakkou'), FALSE); ?>
            <tr>
            <tr>
                <td colspan="3" class="heading">Function extractKanji()</td>
            </tr>
            <?php print unit('extractKanji', array('学校'), array('学校')); ?>
            <?php print unit('extractKanji', array('学校に行きます'), array('学校', '行')); ?>
            <tr>
                <td colspan="3" class="heading">Function extractHiragana()</td>
            </tr>
            <?php print unit('extractHiragana', array('学校'), array()); ?>
            <?php print unit('extractHiragana', array('学校に行きます'), array('に', 'きます')); ?>
            <tr>
                <td colspan="3" class="heading">Function extractKatakana()</td>
            </tr>
            <?php print unit('extractKatakana', array('学校'), array()); ?>
            <?php print unit('extractKatakana', array('サッカーをやる'), array('サッカー')); ?>
            <tr>
                <td colspan="3" class="heading">Function romajiToHiragana()</td>
            </tr>
            <?php print unit('romajiToHiragana', array('gakkou'), 'がっこう'); ?>
            <?php print unit('romajiToHiragana', array('matcha'), 'まっちゃ'); ?>
            <?php print unit('romajiToHiragana', array('maccha'), 'まっちゃ'); ?>
            <?php print unit('romajiToHiragana', array('kekka'), 'けっか'); ?>
            <?php print unit('romajiToHiragana', array('obāsan'), 'おばあさん'); ?>
            <?php print unit('romajiToHiragana', array('gakkō'), 'がっこう'); ?>
            <tr>
                <td colspan="3" class="heading">Function romajiToKatakana()</td>
            </tr>
            <?php print unit('romajiToKatakana', array('furansu'), 'フランス'); ?>
            <?php print unit('romajiToKatakana', array('matcha'), 'マッチャ'); ?>
            <?php print unit('romajiToKatakana', array('maccha'), 'マッチャ'); ?>
            <?php print unit('romajiToKatakana', array('kekka'), 'ケッカ'); ?>
            <tr>
                <td colspan="3" class="heading">Function toRomaji() - default</td>
            </tr>
            <?php print unit('toRomaji', array('まっちゃ'), 'matcha'); ?>
            <?php print unit('toRomaji', array('けっか'), 'kekka'); ?>
            <?php print unit('toRomaji', array('マッチャ'), 'matcha'); ?>   
            <?php print unit('toRomaji', array('ケッカ'), 'kekka'); ?> 
            <?php print unit('toRomaji', array('タクシー'), 'takushī'); ?>
            <?php print unit('toRomaji', array('パーティー'), 'pātī'); ?>
            <?php print unit('toRomaji', array('サッカーをやる'), 'sakkāwoyaru'); ?>
            <?php print unit('toRomaji', array('サッカー　を　やる'), 'sakkā wo yaru'); ?>
            <tr>
                <td colspan="3" class="heading">Function toRomaji() - set transliterator</td>
            </tr>
            <?php print unit('toRomaji', array('がっこう', 'wrong_system'), 'がっこう'); ?>
            <?php print unit('toRomaji', array('がっこう', JpnForPhp::JPNFORPHP_HEPBURN), 'gakkō'); ?>
            <?php print unit('toRomaji', array('がっこう', JpnForPhp::JPNFORPHP_KUNREISHIKI), 'gakkô'); ?>
            <?php print unit('toRomaji', array('がっこう', JpnForPhp::JPNFORPHP_NIHONSHIKI), 'gakkô'); ?>
            <tr>
                <td colspan="3" class="heading">Function toRomaji() - force syllabary</td>
            </tr>
            <?php print unit('toRomaji', array('サッカー　を　やる', JpnForPhp::JPNFORPHP_HEPBURN, JpnForPhp::JPNFORPHP_HIRAGANA), 'サッカー wo yaru'); ?>
            <?php print unit('toRomaji', array('サッカー　を　やる', JpnForPhp::JPNFORPHP_HEPBURN, JpnForPhp::JPNFORPHP_KATAKANA), 'sakkā を やる'); ?>
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
            <?php print unit('inspect', array('がっこう'), array('length' => 4, 'kanji' => 0, 'hiragana' => 4, 'katakana' => 0)); ?>
            <?php print unit('inspect', array('私はマテューです。'), array('length' => 9, 'kanji' => 1, 'hiragana' => 3, 'katakana' => 4)); ?>
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
            <?php print unit('removeDiacritics', array('ÁÀÂÄÃÅÇÉÈÊËÍÏÎÌÑÓÒÔÖÕÚÙÛÜÝŸ'), 'AAAAAACEEEEIIIINOOOOOUUUUYY'); ?>
            <?php print unit('removeDiacritics', array('áàâäãåçéèêëíìîïñóòôöõúùûüýÿ'), 'aaaaaaceeeeiiiinooooouuuuyy'); ?>
        </table>
        <?php $time_end = microtime(true); ?>
        <div style="position:absolute;top:5px;right: 15px;"><p class="info <?php print $check; ?>">Execution time: <?php print $time_end - $time_start; ?> second(s)</p></div>

    </body>
</html>
