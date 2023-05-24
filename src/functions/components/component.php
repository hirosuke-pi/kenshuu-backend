<?php

class Component {
    /**
     * XSS対策済みのarray
     *
     * @var array
     */
    public array $values;

    /**
     * XSS対策されていない生のarray
     *
     * @var array
     */
    public array $rawValues;

    /**
     * コンポーネントを作成
     *
     * @param array $props プロパティ($_PROPS)の読み込み
     * @param Closure $actionComponent コンポーネント処理。戻り値は連想配列
     * @param array $requirePropKeys 必須プロパティのキーと型
     */
    function __construct(array $props, Closure $actionComponent, array $requirePropKeys = []) {
        // キーとその型をチェック
        checkKeyTypes($props, $requirePropKeys);

        // クロージャを実行
        $values = $actionComponent($props);

        // 型チェック
        if (!is_array($values)) {
            // 返り値が配列でなければエラーをスロー
            throw new Exception('Return value type not match: ' . gettype($values));
        }
        $this->rawValues = $values;
        $this->values = $this->convertHtmlspecialcharsArray($values);
    }

    /**
     * 全ての配列にある文字列をXSS対策された文字列に変換
     * object型の場合はarray型にキャストし再帰的に処理する
     *
     * @param array $array 生の配列
     * @return array XSS対策された配列
     */
    private function convertHtmlspecialcharsArray(array $array): array {
        $convertedArray = [];
        foreach ($array as $key => $value) {
            if (is_object($value) || is_array($value)) {
                $convertedArray[$key] = $this->convertHtmlspecialcharsArray((array)$value);
            }
            elseif (is_string($value)) {
                $convertedArray[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
            }
            else {
                $convertedArray[$key] = $value;
            }
        }
        return $convertedArray;
    }
}
