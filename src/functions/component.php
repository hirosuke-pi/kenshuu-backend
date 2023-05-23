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
        // キーとその型をチェック
        checkKeyTypes($props, $requirePropKeys);

        // クロージャを実行
        $values = $actionComponent($props);

        // 型チェック
        if (!is_array($values)) {
            // 返り値が配列でなければエラーをスロー
            var_dump($values);
            throw new Exception('Return value type not match: ' . gettype($values));
        }
        $this->raw_values = $values;

        var_log($values);
        // 文字列だった場合、XSS対策
        // $this->values = filter_var($values, FILTER_CALLBACK, ['options' => function ($value) {
        //     var_log($value);
        //     if (gettype($value) === 'string') {
        //         return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        //     }
        //     elseif (gettype($value) === 'object') {
        //         return array_map(function ($value) {
        //             return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        //         }, $value);
        //     }
        //     return $value;
        // }]);
        // TODO: ここの処理修正

    }


    /**
     * CSRFトークンを設定
     *
     * @return void
     */
    public static function setCsrfToken(){
        $csrf_token = bin2hex(random_bytes(32));
        $_SESSION[CSRF_NAME] = $csrf_token;
        echo '<input name="'. CSRF_NAME .'" type="hidden" value="'. $csrf_token .'" />';
    }

    /**
     * DELETEメソッドを設定
     *
     * @return void
     */
    public static function setDeleteMethod() {
        echo '<input name="'. METHOD_NAME .'" type="hidden" value="DELETE" />';
    }

    /**
     * PUTメソッドを設定
     *
     * @return void
     */
    public static function setPutMethod() {
        echo '<input name="'. METHOD_NAME .'" type="hidden" value="PUT" />';
    }

    /**
     * Atomコンポーネントの読み込み
     *
     * @param string $componentName コンポーネント名
     * @param array $props デフォルトプロパティ
     */
    public static function viewAtom(string $componentName) {
        return new ViewComponent($componentName, 'atoms');
    }

    /**
     * Moleculeコンポーネントの読み込み
     *
     * @param string $componentName コンポーネント名
     */
    public static function viewMolecule(string $componentName) {
        return new ViewComponent($componentName, 'molecules');
    }

    /**
     * Organismコンポーネントの読み込み
     *
     * @param string $componentName コンポーネント名
     */
    public static function viewOrganism(string $componentName) {
        return new ViewComponent($componentName, 'organisms');
    }

    /**
     * Templateコンポーネントの読み込み
     *
     * @param string $componentName コンポーネント名
     */
    public static function viewTemplate(string $componentName) {
        return new ViewComponent($componentName, 'templates');
    }

    /**
     * Pageコンポーネントの読み込み
     *
     * @param string $componentName コンポーネント名
     */
    public static function viewPage(string $componentName) {
        return new ViewComponent($componentName, 'pages');
    }
}

class ViewComponent {
    private string $componentPath;

    /**
     * コンポーネントの読み込み
     *
     * @param string $componentName コンポーネント名
     * @param string $designName デザイン名
     */
    function __construct(string $componentName, string $designName) {
        // Directory traversal対策
        if (!ctype_alnum($designName)) {
            throw new Exception('Invalid component name: ' . $designName);
        }
        elseif (!ctype_alnum($componentName)) {
            throw new Exception('Invalid component name: ' . $componentName);
        }

        // コンポーネントパス設定
        $this->componentPath = __DIR__ . '/../components/'. $designName .'/' . $componentName . '.php';
    }

    /**
     * コンポーネントを表示
     *
     * @param array $props 優先プロパティ
     * @return void
     */
    public function view(array $props = []) {
        $_PROPS = $props;
        require $this->componentPath;
    }
}
