<?php


class Component {
    /**
     * コンポーネント読み込み
     *
     * @param array $props $_PROPSを読み込ませる
     */
    public function __construct(array $props, array $middlewares = []) {
        // キーとその型をチェック
        $this->checkKeyTypes($props, get_object_vars($this));

        // ローダー実行
        $this->init((object)$props);
    }

    private function checkKeyTypes(array $params, array $requirePropKeys) {
        foreach ($requirePropKeys as $key => $value) {
            if (!array_key_exists($key, $params)) {
                // 必須パラメーターが存在しなかった場合はエラーをスロー
                throw new Exception('Required parameter key not found: ' . $key);
            }
            elseif (gettype($params[$key]) !== gettype($value)) {
                // 必須パラメーターが型が一致しなければエラーをスロー
                throw new Exception('Required parameter type('. gettype($value) .') not match: ' . $key);
            }
        }
    }

    /**
     * コンポーネントの初期化処理
     *
     * @param array $props チェック済みプロパティ($_PROPS)
     * @return void
     */
    public function init(object $props) {}
}
