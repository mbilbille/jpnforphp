<?php

/*
 * This file is part of the JpnForPhp package.
 *
 * (c) Matthieu Bilbille
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JpnForPhp\Converter;

use Exception;
use JpnForPhp\Analyzer\Analyzer;
use JpnForPhp\Helper\Helper;

/**
 * Provides useful methods for Japanese units conversion.
 *
 * @author Matthieu Bilbille (@mbibille)
 * @author Axel Bodart (@akeru)
 */
class Converter
{

    /**
     * Numeral conversion type
     */
    const NUMERAL_KANJI = 0;
    const NUMERAL_KANJI_LEGAL = 1;
    const NUMERAL_READING = 2;

    /**
     * Year conversion type
     */
    const YEAR_KANJI = 0;
    const YEAR_ROMAJI = 1;
    const YEAR_KANA = 2;

    // Mapping between digits and kanjis
    private static $mapDigitsKanji = array(
        1 => '一',
        2 => '二',
        3 => '三',
        4 => '四',
        5 => '五',
        6 => '六',
        7 => '七',
        8 => '八',
        9 => '九'
    );

    // Mapping between digits and legal use kanjis
    private static $mapDigitsKanjiLegal = array(
        1 => '壱',
        2 => '弐',
        3 => '参',
        4 => '四',
        5 => '五',
        6 => '六',
        7 => '七',
        8 => '八',
        9 => '九'
    );

    // Mapping between digits and readings
    private static $mapDigitsReading = array(
        1 => 'ichi',
        2 => 'ni',
        3 => 'san',
        4 => 'yon',
        5 => 'go',
        6 => 'roku',
        7 => 'nana',
        8 => 'hachi',
        9 => 'kyū'
    );

    // Mapping powers of ten and kanjis
    private static $mapPowersOfTenKanji = array(
        1 => '十',
        2 => '百',
        3 => '千',
        4 => '万',
        8 => '億',
        12 => '兆',
        16 => '京'
    );

    // Mapping powers of ten and legal use kanjis
    private static $mapPowersOfTenKanjiLegal = array(
        1 => '拾',
        2 => '百',
        3 => '千',
        4 => '万',
        8 => '億',
        12 => '兆',
        16 => '京'
    );

    // Mapping powers of ten and readings
    private static $mapPowersOfTenReading = array(
        1 => 'jū',
        2 => 'hyaku',
        3 => 'sen',
        4 => 'man',
        8 => 'oku',
        12 => 'chō',
        16 => 'kei'
    );

    // Mapping numeral and their exceptions
    private static $readingExceptions = array(
        300 => 'sanbyaku',
        600 => 'roppyaku',
        800 => 'happyaku',
        1000 => 'issen',
        3000 => 'sanzen',
        8000 => 'hassen',
        1000000000000 => 'ichō',
        8000000000000 => 'hatchō'
    );

    public static $mapEras = array(
        array('year' => 645, 'romaji' => "Taika", 'kanji' => '大化', 'kana' => 'たいか'),
        array('year' => 650, 'romaji' => "Hakuchi", 'kanji' => '白雉', 'kana' => 'はくち'),
        array('year' => 686, 'romaji' => "Shuchō", 'kanji' => '朱鳥', 'kana' => 'しゅちょう'),
        array('year' => 701, 'romaji' => "Taihō", 'kanji' => '大宝', 'kana' => 'たいほう'),
        array('year' => 704, 'romaji' => "Keiun", 'kanji' => '慶雲', 'kana' => 'けいうん'),
        array('year' => 708, 'romaji' => "Wadō", 'kanji' => '和銅', 'kana' => 'わどう'),
        array('year' => 715, 'romaji' => "Reiki", 'kanji' => '霊亀', 'kana' => 'れいき'),
        array('year' => 717, 'romaji' => "Yōrō", 'kanji' => '養老', 'kana' => 'ようろう'),
        array('year' => 724, 'romaji' => "Jinki", 'kanji' => '神亀', 'kana' => 'じんき'),
        array('year' => 729, 'romaji' => "Tenpyō", 'kanji' => '天平', 'kana' => 'てんぴょう'),
        array('year' => 749, 'romaji' => "Tenpyō-kanpō", 'kanji' => '天平感宝', 'kana' => 'てんぴょうかんぽう'),
        array('year' => 749, 'romaji' => "Tenpyō-shōhō", 'kanji' => '天平勝宝', 'kana' => 'てんぴょうしょうほう'),
        array('year' => 757, 'romaji' => "Tenpyō-jōji", 'kanji' => '天平宝字', 'kana' => 'てんぴょうじょうじ'),
        array('year' => 765, 'romaji' => "Tenpyō-jingo", 'kanji' => '天平神護', 'kana' => 'てんぴょうじんご'),
        array('year' => 767, 'romaji' => "Jingo-keiun", 'kanji' => '神護景雲', 'kana' => 'じんごけいうん'),
        array('year' => 770, 'romaji' => "Hōki", 'kanji' => '宝亀', 'kana' => 'ほうき'),
        array('year' => 781, 'romaji' => "Ten'ō", 'kanji' => '天応', 'kana' => 'てんおう'),
        array('year' => 782, 'romaji' => "Enryaku", 'kanji' => '延暦', 'kana' => 'えんりゃく'),
        array('year' => 806, 'romaji' => "Daidō", 'kanji' => '大同', 'kana' => 'だいどう'),
        array('year' => 810, 'romaji' => "Kōnin", 'kanji' => '弘仁', 'kana' => 'こうにん'),
        array('year' => 823, 'romaji' => "Tenchō", 'kanji' => '天長', 'kana' => 'てんちょう'),
        array('year' => 834, 'romaji' => "Jōwa", 'kanji' => '承和', 'kana' => 'じょうわ'),
        array('year' => 848, 'romaji' => "Kashō", 'kanji' => '嘉祥', 'kana' => 'かしょう'),
        array('year' => 851, 'romaji' => "Ninju", 'kanji' => '仁寿', 'kana' => 'にんじゅ'),
        array('year' => 855, 'romaji' => "Saikō", 'kanji' => '斉衡', 'kana' => 'さいこう'),
        array('year' => 857, 'romaji' => "Ten'an", 'kanji' => '天安', 'kana' => 'てんあん'),
        array('year' => 859, 'romaji' => "Jōgan", 'kanji' => '貞観', 'kana' => 'じょうがん'),
        array('year' => 877, 'romaji' => "Gangyō", 'kanji' => '元慶', 'kana' => 'がんぎょう'),
        array('year' => 885, 'romaji' => "Ninna", 'kanji' => '仁和', 'kana' => 'にんな'),
        array('year' => 889, 'romaji' => "Kanpyō", 'kanji' => '寛平', 'kana' => 'かんぴょう'),
        array('year' => 898, 'romaji' => "Shōtai", 'kanji' => '昌泰', 'kana' => 'しょうたい'),
        array('year' => 901, 'romaji' => "Engi", 'kanji' => '延喜', 'kana' => 'えんぎ'),
        array('year' => 923, 'romaji' => "Enchō", 'kanji' => '延長', 'kana' => 'えんちょう'),
        array('year' => 931, 'romaji' => "Jōhei", 'kanji' => '承平', 'kana' => 'じょうへい'),
        array('year' => 938, 'romaji' => "Tengyō", 'kanji' => '天慶', 'kana' => 'てんぎょう'),
        array('year' => 947, 'romaji' => "Tenryaku", 'kanji' => '天暦', 'kana' => 'てんりゃく'),
        array('year' => 957, 'romaji' => "Tentoku", 'kanji' => '天徳', 'kana' => 'てんとく'),
        array('year' => 961, 'romaji' => "Ōwa", 'kanji' => '応和', 'kana' => 'おうわ'),
        array('year' => 964, 'romaji' => "Kōhō", 'kanji' => '康保', 'kana' => 'こうほう'),
        array('year' => 968, 'romaji' => "Anna", 'kanji' => '安和', 'kana' => 'あんな'),
        array('year' => 970, 'romaji' => "Tenroku", 'kanji' => '天禄', 'kana' => 'てんろく'),
        array('year' => 974, 'romaji' => "Ten'en", 'kanji' => '天延', 'kana' => 'てんえん'),
        array('year' => 976, 'romaji' => "Jōgen", 'kanji' => '貞元', 'kana' => 'じょうげん'),
        array('year' => 979, 'romaji' => "Tengen", 'kanji' => '天元', 'kana' => 'てんげん'),
        array('year' => 983, 'romaji' => "Eikan", 'kanji' => '永観', 'kana' => 'えいかん'),
        array('year' => 985, 'romaji' => "Kanna", 'kanji' => '寛和', 'kana' => 'かんな'),
        array('year' => 987, 'romaji' => "Eien", 'kanji' => '永延', 'kana' => 'えいえん'),
        array('year' => 989, 'romaji' => "Eiso", 'kanji' => '永祚', 'kana' => 'えいそ'),
        array('year' => 990, 'romaji' => "Shōryaku", 'kanji' => '正暦', 'kana' => 'しょうりゃく'),
        array('year' => 995, 'romaji' => "Chōtoku", 'kanji' => '長徳', 'kana' => 'ちょうとく'),
        array('year' => 999, 'romaji' => "Chōhō", 'kanji' => '長保', 'kana' => 'ちょうほう'),
        array('year' => 1004, 'romaji' => "Kankō", 'kanji' => '寛弘', 'kana' => 'かんこう'),
        array('year' => 1013, 'romaji' => "Chōwa", 'kanji' => '長和', 'kana' => 'ちょうわ'),
        array('year' => 1017, 'romaji' => "Kannin", 'kanji' => '寛仁', 'kana' => 'かんにん'),
        array('year' => 1021, 'romaji' => "Jian", 'kanji' => '治安', 'kana' => 'じあん'),
        array('year' => 1024, 'romaji' => "Manju", 'kanji' => '万寿', 'kana' => 'まんじゅ'),
        array('year' => 1028, 'romaji' => "Chōgen", 'kanji' => '長元', 'kana' => 'ちょうげん'),
        array('year' => 1037, 'romaji' => "Chōryaku", 'kanji' => '長暦', 'kana' => 'ちょうりゃく'),
        array('year' => 1040, 'romaji' => "Chōkyū", 'kanji' => '長久', 'kana' => 'ちょうきゅう'),
        array('year' => 1045, 'romaji' => "Kantoku", 'kanji' => '寛徳', 'kana' => 'かんとく'),
        array('year' => 1046, 'romaji' => "Eishō", 'kanji' => '永承', 'kana' => 'えいしょう'),
        array('year' => 1053, 'romaji' => "Tengi", 'kanji' => '天喜', 'kana' => 'てんぎ'),
        array('year' => 1058, 'romaji' => "Kōhei", 'kanji' => '康平', 'kana' => 'こうへい'),
        array('year' => 1065, 'romaji' => "Jiryaku", 'kanji' => '治暦', 'kana' => 'じりゃく'),
        array('year' => 1069, 'romaji' => "Enkyū", 'kanji' => '延久', 'kana' => 'えんきゅう'),
        array('year' => 1074, 'romaji' => "Jōhō", 'kanji' => '承保', 'kana' => 'じょうほう'),
        array('year' => 1078, 'romaji' => "Jōryaku", 'kanji' => '承暦', 'kana' => 'じょうりゃく'),
        array('year' => 1081, 'romaji' => "Eihō", 'kanji' => '永保', 'kana' => 'えいほう'),
        array('year' => 1084, 'romaji' => "Ōtoku", 'kanji' => '応徳', 'kana' => 'おうとく'),
        array('year' => 1087, 'romaji' => "Kanji", 'kanji' => '寛治', 'kana' => 'かんじ'),
        array('year' => 1095, 'romaji' => "Kahō", 'kanji' => '嘉保', 'kana' => 'かほう'),
        array('year' => 1097, 'romaji' => "Eichō", 'kanji' => '永長', 'kana' => 'えいちょう'),
        array('year' => 1098, 'romaji' => "Jōtoku", 'kanji' => '承徳', 'kana' => 'じょうとく'),
        array('year' => 1099, 'romaji' => "Kōwa", 'kanji' => '康和', 'kana' => 'こうわ'),
        array('year' => 1104, 'romaji' => "Chōji", 'kanji' => '長治', 'kana' => 'ちょうじ'),
        array('year' => 1106, 'romaji' => "Kajō", 'kanji' => '嘉承', 'kana' => 'かじょう'),
        array('year' => 1108, 'romaji' => "Tennin", 'kanji' => '天仁', 'kana' => 'てんにん'),
        array('year' => 1110, 'romaji' => "Tennei", 'kanji' => '天永', 'kana' => 'てんねい'),
        array('year' => 1113, 'romaji' => "Eikyū", 'kanji' => '永久', 'kana' => 'えいきゅう'),
        array('year' => 1118, 'romaji' => "Gen'ei", 'kanji' => '元永', 'kana' => 'げんえい'),
        array('year' => 1120, 'romaji' => "Hōan", 'kanji' => '保安', 'kana' => 'ほうあん'),
        array('year' => 1124, 'romaji' => "Tenji", 'kanji' => '天治', 'kana' => 'てんじ'),
        array('year' => 1126, 'romaji' => "Daiji", 'kanji' => '大治', 'kana' => 'だいじ'),
        array('year' => 1131, 'romaji' => "Tenshō", 'kanji' => '天承', 'kana' => 'てんしょう'),
        array('year' => 1132, 'romaji' => "Chōshō", 'kanji' => '長承', 'kana' => 'ちょうしょう'),
        array('year' => 1135, 'romaji' => "Hōen", 'kanji' => '保延', 'kana' => 'ほうえん'),
        array('year' => 1141, 'romaji' => "Eiji", 'kanji' => '永治', 'kana' => 'えいじ'),
        array('year' => 1142, 'romaji' => "Kōji", 'kanji' => '康治', 'kana' => 'こうじ'),
        array('year' => 1144, 'romaji' => "Ten'yō", 'kanji' => '天養', 'kana' => 'てんよう'),
        array('year' => 1145, 'romaji' => "Kyūan", 'kanji' => '久安', 'kana' => 'きゅうあん'),
        array('year' => 1151, 'romaji' => "Ninpei", 'kanji' => '仁平', 'kana' => 'にんぺい'),
        array('year' => 1154, 'romaji' => "Kyūju", 'kanji' => '久寿', 'kana' => 'きゅうじゅ'),
        array('year' => 1156, 'romaji' => "Hōgen", 'kanji' => '保元', 'kana' => 'ほうげん'),
        array('year' => 1159, 'romaji' => "Heiji", 'kanji' => '平治', 'kana' => 'へいじ'),
        array('year' => 1160, 'romaji' => "Eiryaku", 'kanji' => '永暦', 'kana' => 'えいりゃく'),
        array('year' => 1161, 'romaji' => "Ōhō", 'kanji' => '応保', 'kana' => 'おうほう'),
        array('year' => 1163, 'romaji' => "Chōkan", 'kanji' => '長寛', 'kana' => 'ちょうかん'),
        array('year' => 1165, 'romaji' => "Eiman", 'kanji' => '永万', 'kana' => 'えいまん'),
        array('year' => 1166, 'romaji' => "Nin'an", 'kanji' => '仁安', 'kana' => 'にんあん'),
        array('year' => 1169, 'romaji' => "Kaō", 'kanji' => '嘉応', 'kana' => 'かおう'),
        array('year' => 1171, 'romaji' => "Shōan", 'kanji' => '承安', 'kana' => 'しょうあん'),
        array('year' => 1175, 'romaji' => "Angen", 'kanji' => '安元', 'kana' => 'あんげん'),
        array('year' => 1177, 'romaji' => "Jishō", 'kanji' => '治承', 'kana' => 'じしょう'),
        array('year' => 1181, 'romaji' => "Yōwa", 'kanji' => '養和', 'kana' => 'ようわ'),
        array('year' => 1182, 'romaji' => "Juei", 'kanji' => '寿永', 'kana' => 'じゅえい'),
        array('year' => 1184, 'romaji' => "Genryaku", 'kanji' => '元暦', 'kana' => 'げんりゃく'),
        array('year' => 1185, 'romaji' => "Bunji", 'kanji' => '文治', 'kana' => 'ぶんじ'),
        array('year' => 1190, 'romaji' => "Kenkyū", 'kanji' => '建久', 'kana' => 'けんきゅう'),
        array('year' => 1199, 'romaji' => "Shōji", 'kanji' => '正治', 'kana' => 'しょうじ'),
        array('year' => 1201, 'romaji' => "Kennin", 'kanji' => '建仁', 'kana' => 'けんにん'),
        array('year' => 1204, 'romaji' => "Genkyū", 'kanji' => '元久', 'kana' => 'げんきゅう'),
        array('year' => 1206, 'romaji' => "Ken'ei", 'kanji' => '建永', 'kana' => 'けんえい'),
        array('year' => 1207, 'romaji' => "Jōgen", 'kanji' => '承元', 'kana' => 'じょうげん'),
        array('year' => 1211, 'romaji' => "Kenryaku", 'kanji' => '建暦', 'kana' => 'けんりゃく'),
        array('year' => 1214, 'romaji' => "Kenpō", 'kanji' => '建保', 'kana' => 'けんぽう'),
        array('year' => 1219, 'romaji' => "Jōkyū", 'kanji' => '承久', 'kana' => 'じょうきゅう'),
        array('year' => 1222, 'romaji' => "Jōō", 'kanji' => '貞応', 'kana' => 'じょうおう'),
        array('year' => 1225, 'romaji' => "Gennin", 'kanji' => '元仁', 'kana' => 'げんにん'),
        array('year' => 1225, 'romaji' => "Karoku", 'kanji' => '嘉禄', 'kana' => 'かろく'),
        array('year' => 1228, 'romaji' => "Antei", 'kanji' => '安貞', 'kana' => 'あんてい'),
        array('year' => 1229, 'romaji' => "Kanki", 'kanji' => '寛喜', 'kana' => 'かんき'),
        array('year' => 1232, 'romaji' => "Jōei", 'kanji' => '貞永', 'kana' => 'じょうえい'),
        array('year' => 1233, 'romaji' => "Tenpuku", 'kanji' => '天福', 'kana' => 'てんぷく'),
        array('year' => 1235, 'romaji' => "Bunryaku", 'kanji' => '文暦', 'kana' => 'ぶんりゃく'),
        array('year' => 1235, 'romaji' => "Katei", 'kanji' => '嘉禎', 'kana' => 'かてい'),
        array('year' => 1238, 'romaji' => "Ryakunin", 'kanji' => '暦仁', 'kana' => 'りゃくにん'),
        array('year' => 1239, 'romaji' => "En'ō", 'kanji' => '延応', 'kana' => 'えんおう'),
        array('year' => 1240, 'romaji' => "Ninji", 'kanji' => '仁治', 'kana' => 'にんじ'),
        array('year' => 1243, 'romaji' => "Kangen", 'kanji' => '寛元', 'kana' => 'かんげん'),
        array('year' => 1247, 'romaji' => "Hōji", 'kanji' => '宝治', 'kana' => 'ほうじ'),
        array('year' => 1249, 'romaji' => "Kenchō", 'kanji' => '建長', 'kana' => 'けんちょう'),
        array('year' => 1256, 'romaji' => "Kōgen", 'kanji' => '康元', 'kana' => 'こうげん'),
        array('year' => 1257, 'romaji' => "Shōka", 'kanji' => '正嘉', 'kana' => 'しょうか'),
        array('year' => 1259, 'romaji' => "Shōgen", 'kanji' => '正元', 'kana' => 'しょうげん'),
        array('year' => 1260, 'romaji' => "Bun'ō", 'kanji' => '文応', 'kana' => 'ぶんおう'),
        array('year' => 1261, 'romaji' => "Kōchō", 'kanji' => '弘長', 'kana' => 'こうちょう'),
        array('year' => 1264, 'romaji' => "Bun'ei", 'kanji' => '文永', 'kana' => 'ぶんえい'),
        array('year' => 1275, 'romaji' => "Kenji", 'kanji' => '健治', 'kana' => 'けんじ'),
        array('year' => 1278, 'romaji' => "Kōan", 'kanji' => '弘安', 'kana' => 'こうあん'),
        array('year' => 1288, 'romaji' => "Shōō", 'kanji' => '正応', 'kana' => 'しょうおう'),
        array('year' => 1293, 'romaji' => "Einin", 'kanji' => '永仁', 'kana' => 'えいにん'),
        array('year' => 1299, 'romaji' => "Shōan", 'kanji' => '正安', 'kana' => 'しょうあん'),
        array('year' => 1302, 'romaji' => "Kengen", 'kanji' => '乾元', 'kana' => 'けんげん'),
        array('year' => 1303, 'romaji' => "Kagen", 'kanji' => '嘉元', 'kana' => 'かげん'),
        array('year' => 1307, 'romaji' => "Tokuji", 'kanji' => '徳治', 'kana' => 'とくじ'),
        array('year' => 1308, 'romaji' => "Enkyō", 'kanji' => '延慶', 'kana' => 'えんきょう'),
        array('year' => 1311, 'romaji' => "Ōchō", 'kanji' => '応長', 'kana' => 'おうちょう'),
        array('year' => 1312, 'romaji' => "Shōwa", 'kanji' => '正和', 'kana' => 'しょうわ'),
        array('year' => 1317, 'romaji' => "Bunpō", 'kanji' => '文保', 'kana' => 'ぶんぽう'),
        array('year' => 1319, 'romaji' => "Gen'ō", 'kanji' => '元応', 'kana' => 'げんおう'),
        array('year' => 1321, 'romaji' => "Genkō", 'kanji' => '元亨', 'kana' => 'げんこう'),
        array('year' => 1325, 'romaji' => "Shōchu", 'kanji' => '正中', 'kana' => 'しょうちゅ'),
        array('year' => 1326, 'romaji' => "Karyaku", 'kanji' => '嘉暦', 'kana' => 'かりゃく'),
        array('year' => 1329, 'romaji' => "Gentoku", 'kanji' => '元徳', 'kana' => 'げんとく'),
        array('year' => 1332, 'romaji' => "Shōkei", 'kanji' => '正慶', 'kana' => 'しょうけい'),
        array('year' => 1338, 'romaji' => "Ryakuō", 'kanji' => '暦応', 'kana' => 'りゃくおう'),
        array('year' => 1342, 'romaji' => "Kōei", 'kanji' => '康永', 'kana' => 'こうえい'),
        array('year' => 1345, 'romaji' => "Jōwa", 'kanji' => '貞和', 'kana' => 'じょうわ'),
        array('year' => 1350, 'romaji' => "Kan'ō", 'kanji' => '観応', 'kana' => 'かんおう'),
        array('year' => 1352, 'romaji' => "Bunna", 'kanji' => '文和', 'kana' => 'ぶんな'),
        array('year' => 1356, 'romaji' => "Enbun", 'kanji' => '延文', 'kana' => 'えんぶん'),
        array('year' => 1361, 'romaji' => "Kōan", 'kanji' => '康安', 'kana' => 'こうあん'),
        array('year' => 1362, 'romaji' => "Jōji", 'kanji' => '貞治', 'kana' => 'じょうじ'),
        array('year' => 1368, 'romaji' => "Ōan", 'kanji' => '応安', 'kana' => 'おうあん'),
        array('year' => 1375, 'romaji' => "Eiwa", 'kanji' => '永和', 'kana' => 'えいわ'),
        array('year' => 1379, 'romaji' => "Kōryaku", 'kanji' => '康暦', 'kana' => 'こうりゃく'),
        array('year' => 1381, 'romaji' => "Eitoku", 'kanji' => '永徳', 'kana' => 'えいとく'),
        array('year' => 1384, 'romaji' => "Shitoku", 'kanji' => '至徳', 'kana' => 'しとく'),
        array('year' => 1387, 'romaji' => "Kakei", 'kanji' => '嘉慶', 'kana' => 'かけい'),
        array('year' => 1389, 'romaji' => "Kōō", 'kanji' => '康応', 'kana' => 'こうおう'),
        array('year' => 1390, 'romaji' => "Meitoku", 'kanji' => '明徳', 'kana' => 'めいとく'),
        array('year' => 1394, 'romaji' => "Ōei", 'kanji' => '応永', 'kana' => 'おうえい'),
        array('year' => 1428, 'romaji' => "Shōchō", 'kanji' => '正長', 'kana' => 'しょうちょう'),
        array('year' => 1429, 'romaji' => "Eikyō", 'kanji' => '永享', 'kana' => 'えいきょう'),
        array('year' => 1441, 'romaji' => "Kakitsu", 'kanji' => '嘉吉', 'kana' => 'かきつ'),
        array('year' => 1444, 'romaji' => "Bun'an", 'kanji' => '文安', 'kana' => 'ぶんあん'),
        array('year' => 1449, 'romaji' => "Hōtoku", 'kanji' => '宝徳', 'kana' => 'ほうとく'),
        array('year' => 1452, 'romaji' => "Kyōtoku", 'kanji' => '享徳', 'kana' => 'きょうとく'),
        array('year' => 1455, 'romaji' => "Kōshō", 'kanji' => '康正', 'kana' => 'こうしょう'),
        array('year' => 1457, 'romaji' => "Chōroku", 'kanji' => '長禄', 'kana' => 'ちょうろく'),
        array('year' => 1461, 'romaji' => "Kanshō", 'kanji' => '寛正', 'kana' => 'かんしょう'),
        array('year' => 1466, 'romaji' => "Bunshō", 'kanji' => '文正', 'kana' => 'ぶんしょう'),
        array('year' => 1467, 'romaji' => "Ōnin", 'kanji' => '応仁', 'kana' => 'おうにん'),
        array('year' => 1469, 'romaji' => "Bunmei", 'kanji' => '文明', 'kana' => 'ぶんめい'),
        array('year' => 1487, 'romaji' => "Chōkyō", 'kanji' => '長享', 'kana' => 'ちょうきょう'),
        array('year' => 1489, 'romaji' => "Entoku", 'kanji' => '延徳', 'kana' => 'えんとく'),
        array('year' => 1492, 'romaji' => "Meiō", 'kanji' => '明応', 'kana' => 'めいおう'),
        array('year' => 1501, 'romaji' => "Bunki", 'kanji' => '文亀', 'kana' => 'ぶんき'),
        array('year' => 1504, 'romaji' => "Eishō", 'kanji' => '永正', 'kana' => 'えいしょう'),
        array('year' => 1521, 'romaji' => "Daiei", 'kanji' => '大永', 'kana' => 'だいえい'),
        array('year' => 1528, 'romaji' => "Kyōroku", 'kanji' => '享禄', 'kana' => 'きょうろく'),
        array('year' => 1532, 'romaji' => "Tenbun", 'kanji' => '天文', 'kana' => 'てんぶん'),
        array('year' => 1555, 'romaji' => "Kōji", 'kanji' => '弘治', 'kana' => 'こうじ'),
        array('year' => 1558, 'romaji' => "Eiroku", 'kanji' => '永禄', 'kana' => 'えいろく'),
        array('year' => 1570, 'romaji' => "Genki", 'kanji' => '元亀', 'kana' => 'げんき'),
        array('year' => 1573, 'romaji' => "Tenshō", 'kanji' => '天正', 'kana' => 'てんしょう'),
        array('year' => 1593, 'romaji' => "Bunroku", 'kanji' => '文禄', 'kana' => 'ぶんろく'),
        array('year' => 1596, 'romaji' => "Keichō", 'kanji' => '慶長', 'kana' => 'けいちょう'),
        array('year' => 1615, 'romaji' => "Genna", 'kanji' => '元和', 'kana' => 'げんな'),
        array('year' => 1624, 'romaji' => "Kan'ei", 'kanji' => '寛永', 'kana' => 'かんえい'),
        array('year' => 1645, 'romaji' => "Shōhō", 'kanji' => '正保', 'kana' => 'しょうほう'),
        array('year' => 1648, 'romaji' => "Keian", 'kanji' => '慶安', 'kana' => 'けいあん'),
        array('year' => 1652, 'romaji' => "Jōō", 'kanji' => '承応', 'kana' => 'じょうおう'),
        array('year' => 1655, 'romaji' => "Meireki", 'kanji' => '明暦', 'kana' => 'めいれき'),
        array('year' => 1658, 'romaji' => "Manji", 'kanji' => '万治', 'kana' => 'まんじ'),
        array('year' => 1661, 'romaji' => "Kanbun", 'kanji' => '寛文', 'kana' => 'かんぶん'),
        array('year' => 1673, 'romaji' => "Enpō", 'kanji' => '延宝', 'kana' => 'えんぽう'),
        array('year' => 1681, 'romaji' => "Tenna", 'kanji' => '天和', 'kana' => 'てんな'),
        array('year' => 1684, 'romaji' => "Jōkyō", 'kanji' => '貞享', 'kana' => 'じょうきょう'),
        array('year' => 1688, 'romaji' => "Genroku", 'kanji' => '元禄', 'kana' => 'げんろく'),
        array('year' => 1704, 'romaji' => "Hōei", 'kanji' => '宝永', 'kana' => 'ほうえい'),
        array('year' => 1711, 'romaji' => "Shōtoku", 'kanji' => '正徳', 'kana' => 'しょうとく'),
        array('year' => 1716, 'romaji' => "Kyōhō", 'kanji' => '享保', 'kana' => 'きょうほう'),
        array('year' => 1736, 'romaji' => "Genbun", 'kanji' => '元文', 'kana' => 'げんぶん'),
        array('year' => 1741, 'romaji' => "Kanpō", 'kanji' => '寛保', 'kana' => 'かんぽう'),
        array('year' => 1744, 'romaji' => "Enkyō", 'kanji' => '延享', 'kana' => 'えんきょう'),
        array('year' => 1748, 'romaji' => "Kan'en", 'kanji' => '寛延', 'kana' => 'かんえん'),
        array('year' => 1751, 'romaji' => "Hōreki", 'kanji' => '宝暦', 'kana' => 'ほうれき'),
        array('year' => 1764, 'romaji' => "Meiwa", 'kanji' => '明和', 'kana' => 'めいわ'),
        array('year' => 1773, 'romaji' => "An'ei", 'kanji' => '安永', 'kana' => 'あんえい'),
        array('year' => 1781, 'romaji' => "Tenmei", 'kanji' => '天明', 'kana' => 'てんめい'),
        array('year' => 1801, 'romaji' => "Kansei", 'kanji' => '寛政', 'kana' => 'かんせい'),
        array('year' => 1802, 'romaji' => "Kyōwa", 'kanji' => '享和', 'kana' => 'きょうわ'),
        array('year' => 1804, 'romaji' => "Bunka", 'kanji' => '文化', 'kana' => 'ぶんか'),
        array('year' => 1818, 'romaji' => "Bunsei", 'kanji' => '文政', 'kana' => 'ぶんせい'),
        array('year' => 1831, 'romaji' => "Tenpō", 'kanji' => '天保', 'kana' => 'てんぽう'),
        array('year' => 1845, 'romaji' => "Kōka", 'kanji' => '弘化', 'kana' => 'こうか'),
        array('year' => 1848, 'romaji' => "Kaei", 'kanji' => '嘉永', 'kana' => 'かえい'),
        array('year' => 1855, 'romaji' => "Ansei", 'kanji' => '安政', 'kana' => 'あんせい'),
        array('year' => 1860, 'romaji' => "Man'ei", 'kanji' => '万延', 'kana' => 'まんえい'),
        array('year' => 1861, 'romaji' => "Bunkyū", 'kanji' => '文久', 'kana' => 'ぶんきゅう'),
        array('year' => 1864, 'romaji' => "Genji", 'kanji' => '元治', 'kana' => 'げんじ'),
        array('year' => 1865, 'romaji' => "Keiō", 'kanji' => '慶応', 'kana' => 'けいおう'),
        array('year' => 1868, 'romaji' => "Meiji", 'kanji' => '明治', 'kana' => 'めいじ'),
        array('year' => 1912, 'romaji' => "Taishō", 'kanji' => '大正', 'kana' => 'たいしょう'),
        array('year' => 1926, 'romaji' => "Shōwa", 'kanji' => '昭和', 'kana' => 'しょうわ'),
        array('year' => 1989, 'romaji' => "Heisei", 'kanji' => '平成', 'kana' => 'へいせい'),
    );

    /**
     * Converts a number in Arabic/Western format into Japanese numeral.
     *
     * @param integer $number The input number.
     *
     * @param int $type
     * @return string The Japanese numeral.
     * @throws Exception
     */
    public static function toJapaneseNumeral($number, $type = self::NUMERAL_KANJI)
    {
        // Return fast on zero
        if ($number == 0) {
            if ($type == self::NUMERAL_READING) {
                return 'zero';
            } else {
                return '〇';
            }
        }
        $separator = '';
        switch ($type) {
            case self::NUMERAL_KANJI:
                $mapPowersOfTen = self::$mapPowersOfTenKanji;
                $mapDigits = self::$mapDigitsKanji;
                break;
            case self::NUMERAL_KANJI_LEGAL:
                $mapPowersOfTen = self::$mapPowersOfTenKanjiLegal;
                $mapDigits = self::$mapDigitsKanjiLegal;
                break;
            case self::NUMERAL_READING:
                $mapPowersOfTen = self::$mapPowersOfTenReading;
                $mapDigits = self::$mapDigitsReading;
                $separator = ' ';
                break;
            default:
                throw new Exception('Unknown type');
        }
        $exponent = strlen($number) - 1;
        if ($exponent > 4) {
            $exponentRemainder = $exponent % 4;
            $closestExponent = $exponent - $exponentRemainder;
            $power = pow(10, $closestExponent);
            $remainder = $number % $power;
            $roundPart = $number - $remainder;
            $multiplier = (int)(($number - $remainder) / $power);
            if ($type != self::NUMERAL_READING || !array_key_exists($roundPart, self::$readingExceptions)) {
                $result = self::toJapaneseNumeral($multiplier, $type) . $separator . $mapPowersOfTen[$closestExponent];
            } else {
                $result = self::$readingExceptions[$roundPart];
            }
            if ($remainder != 0) {
                $result .= rtrim($separator . self::toJapaneseNumeral($remainder, $type));
            }
            return $result;
        } else {
            $result = '';
            while ($exponent > 0) {
                $power = pow(10, $exponent);
                $remainder = $number % $power;
                $roundPart = $number - $remainder;
                $multiplier = (int)(($number - $remainder) / $power);
                if ($type != self::NUMERAL_READING || !array_key_exists($roundPart, self::$readingExceptions)) {
                    if ($multiplier != 1 || $exponent == 4) {
                        $result .= $mapDigits[$multiplier] . $separator;
                    }
                    $result .= $mapPowersOfTen[$exponent] . $separator;
                } else {
                    $result .= self::$readingExceptions[$roundPart] . $separator;
                }
                $number = $remainder;
                $exponent = strlen($number) - 1;
            }
            if ($number != 0) {
                $result .= $mapDigits[$number];
            }
            return $result;
        }
    }

    /**
     * Converts a year in Japanese format into Western format.
     *
     * @param $year : kanji or hiragana era name followed by digits, or era name in romaji, space and digit. I.e. : 明治33, めいじ33, Meiji 33
     * @return string|array : The year(s) in Western format.
     * @throws Exception
     */
    public static function toWesternYear($year)
    {
        if (Analyzer::hasKanji($year)) {
            $key = 'kanji';
            $eraName = Helper::extractKanji($year);
            $eraName = $eraName[0];
            $eraValue = (int)Helper::subString($year, Analyzer::length($eraName), Analyzer::length($year));
        } elseif (Analyzer::hasHiragana($year)) {
            $key = 'kana';
            $eraName = Helper::extractHiragana($year);
            $eraName = $eraName[0];
            $eraValue = (int)Helper::subString($year, Analyzer::length($eraName), Analyzer::length($year));
        } else {
            $key = 'romaji';
            $year = strtolower($year);
            $parts = explode(' ', $year);
            $eraName = $parts[0];
            $eraValue = (int)$parts[1];
        }
        if (empty($eraName) || empty($eraValue)) {
            throw new Exception('Invalid year ' . $year);
        }
        $max = count(self::$mapEras);
        $westernYears = array();
        for ($i = 0; $i < $max; $i++) {
            $era = self::$mapEras[$i];
            $overflown = false;
            if (strtolower($era[$key]) == $eraName) {
                $eraStart = $era['year'];
                $westernYear = $eraStart + $eraValue - 1;
                if ($i < $max - 1) {
                    $nextEra = self::$mapEras[$i + 1];
                    $nextEraYear = $nextEra['year'];
                    if ($westernYear > $nextEraYear) {
                        $overflown = true;
                    }
                }
                $westernYears[] = array('value' => $westernYear, 'overflown' => $overflown);
            }
        }
        $results = array();
        foreach ($westernYears as $westernYear) {
            if (!$westernYear['overflown']) {
                $results[] = $westernYear['value'];
            }
        }
        if (empty($results)) {
            throw new Exception('Year ' . $year . ' is invalid');
        } elseif (count($results) == 1) {
            return $results[0];
        } else {
            return $results;
        }
    }

    /**
     * Converts a year in Western format into Japanese format.
     *
     * @param $year
     * @param int $yearType : era name output format (kanji, kana, romaji)
     * @param int $numeralType : the numeral type used
     * @return string The Japanese year.
     * @throws Exception
     */
    public static function toJapaneseYear($year, $yearType = self::YEAR_KANJI, $numeralType = null)
    {
        if ($year < self::$mapEras[0]['year']) {
            throw new Exception('The year ' . $year . ' is before any of the known Japanese eras. The first era started in ' . self::$mapEras[0]['year'] . '.');
        }
        $max = count(self::$mapEras);
        $era = self::$mapEras[$max - 1];
        for ($i = 1; $i < $max; $i++) {
            $currentEra = self::$mapEras[$i];
            $startYear = $currentEra['year'];
            if ($startYear > $year) {
                $era = self::$mapEras[$i - 1];
                break;
            }
        }
        $eraValue = $year - $era['year'] + 1;
        if ($numeralType !== null) {
            $eraValue = self::toJapaneseNumeral($eraValue, $numeralType);
        }
        switch ($yearType) {
            case self::YEAR_KANJI:
                $eraName = $era['kanji'];
                $eraValue .= '年';
                break;
            case self::YEAR_ROMAJI:
                $eraName = $era['romaji'] . ' ';
                break;
            case self::YEAR_KANA:
                $eraName = $era['kana'];
                $eraValue .= 'ねん';
                break;
            default:
                throw new Exception('Unknown year type');
        }
        return $eraName . $eraValue;
    }
}
