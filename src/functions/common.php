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
 * キーとその型をチェック
 *
 * @param array $params チェックしたい配列
 * @param array $requirePropKeys チェックするキーとその型
 * @return void
 */
function checkKeyTypes(array $params, array $requirePropKeys) {
    foreach ($requirePropKeys as $key => $type) {
        if (!array_key_exists($key, $params)) {
            // 必須パラメーターが存在しなかった場合はエラーをスロー
            throw new Exception('Required parameter key not found: ' . $key);
        }
        elseif (gettype($params[$key]) !== $type) {
            // 必須パラメーターが型が一致しなければエラーをスロー
            throw new Exception('Required parameter type('. $type .') not match: ' . $key .'('. gettype($params[$key]) .')');
        }
    }
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
