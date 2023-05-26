<?php

class PageComponent {
    /**
     * XSS対策済みのobject
     *
     * @var object
     */
    public object $values;

    /**
     * XSS対策されていない生のobject
     *
     * @var object
     */
    public object $rawValues;

    /**
     * コンポーネントを作成
     *
     * @param array $props プロパティ($_PROPS)の読み込み
     * @param Closure $mounted コンポーネント処理。戻り値は連想配列
     * @param array $requiredTypes 必須プロパティのキーと型
     */
    function __construct(array $props, Closure $mounted, array $propTypes = []) {
        $this->values = new stdClass();
        $this->rawValues = new stdClass();

        // キーとその型をチェック
        checkKeyTypes($props, $requiredTypes);

        // クロージャを実行
        $mounted($this->rawValues, $props);

        // XSS対策
        $this->values = (object)$this->convertHtmlspecialcharsArray($this->rawValues);
    }

    /**
     * 全ての配列にある文字列をXSS対策された文字列に変換
     * object型の場合はarray型にキャストし再帰的に処理する
     *
     * @param array|object $list 生の配列
     * @return array XSS対策された配列
     */
    private function convertHtmlspecialcharsArray(array|object $list): array {
        $convertedArray = [];
        foreach ($list as $key => $value) {
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
