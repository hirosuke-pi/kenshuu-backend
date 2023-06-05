<?php

/**
 * var_dumpを見やすい形式に出力
 *
 * @param mixed $dump 出力したいオブジェクト
 * @return void
 */
function var_log(mixed $dump) {
    echo '<pre>';
    var_dump($dump);
    echo '</pre>';
}

/**
 * htmlspecialcharsのエイリアス
 *
 * @param string $str エスケープしたい文字列
 * @return string エスケープ済みの文字列
 */
function h(string $str): string {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

/**
 * DateTime形式の文字列を'2023/04/23 18:32:12'の形式に変換する
 *
 * @param string $datetime DateTime形式の文字列
 * @return string 変換済みの文字列
 */
function getDateTimeFormat(string $datetime): string {
    $now = new DateTime($datetime);
    return $now->format('Y/m/d H:i:s');
}

function replaceBr(string $str): string {
    return str_replace("\n", '<br/>', $str);
}
