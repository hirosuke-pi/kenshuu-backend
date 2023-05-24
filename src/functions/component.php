<?php

class Component {
    public array $values;
    public array $raw_values;

    /**
     * コンポーネントを作成
     *
     * @param array $props プロパティ($_PROPS)の読み込み
     * @param Closure $actionComponent コンポーネント処理。戻り値は連想配列
     * @param array $requirePropKeys 必須プロパティのキーと型
     */
    function __construct(array $props, Closure $actionComponent, array $requirePropKeys = []) {
        foreach ($requirePropKeys as $key => $type) {
            if (!array_key_exists($key, $props)) {
                // 必須プロパティが存在しなかった場合はエラーをスロー
                throw new Exception('Prop key not found: ' . $key);
            }
            elseif (gettype($props[$key]) !== $type) {
                // 必須プロパティが型が一致しなければエラーをスロー
                throw new Exception('Prop type not match: ' . $key);
            }
        }

        // クロージャを実行
        $values = $actionComponent($props);

        // 型チェック
        if (!is_array($values)) {
            // 返り値が配列でなければエラーをスロー
            throw new Exception('Return value type not match: ' . gettype($values));
        }
        $this->raw_values = $values;

        // 文字列だった場合、XSS対策
        $this->values = filter_var($values, FILTER_CALLBACK, ['options' => function ($value) {
            if (!is_string($value)) {
                return $value;
            }
            return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        }]);
    }

    /**
     * Atomコンポーネントの読み込み
     *
     * @param string $componentName コンポーネント名
     * @param array $props デフォルトプロパティ
     * @param boolean $require_session セッションが必要かどうか
     */
    public static function viewAtom(string $componentName, array $props = [], $require_session = false) {
        return new ViewComponent($componentName, 'atoms', $props, $require_session);
    }

    /**
     * Moleculeコンポーネントの読み込み
     *
     * @param string $componentName コンポーネント名
     * @param array $props デフォルトプロパティ
     * @param boolean $require_session セッションが必要かどうか
     */
    public static function viewMolecule(string $componentName, array $props = [], $require_session = false) {
        return new ViewComponent($componentName, 'molecules', $props, $require_session);
    }

    /**
     * Organismコンポーネントの読み込み
     *
     * @param string $componentName コンポーネント名
     * @param array $props デフォルトプロパティ
     * @param boolean $require_session セッションが必要かどうか
     */
    public static function viewOrganism(string $componentName, array $props = [], $require_session = false) {
        return new ViewComponent($componentName, 'organisms', $props, $require_session);
    }

    /**
     * Templateコンポーネントの読み込み
     *
     * @param string $componentName コンポーネント名
     * @param array $props デフォルトプロパティ
     * @param boolean $require_session セッションが必要かどうか
     */
    public static function viewTemplate(string $componentName, array $props = [], $require_session = false) {
        return new ViewComponent($componentName, 'templates', $props, $require_session);
    }

    /**
     * Pageコンポーネントの読み込み
     *
     * @param string $componentName コンポーネント名
     * @param array $props デフォルトプロパティ
     * @param boolean $require_session セッションが必要かどうか
     */
    public static function viewPage(string $componentName, array $props = [], $require_session = false) {
        return new ViewComponent($componentName, 'pages', $props, $require_session);
    }
}
