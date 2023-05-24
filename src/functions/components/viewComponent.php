<?php

class ViewComponent {
    private string $componentPath;
    private array $props;

    /**
     * コンポーネントの読み込み
     *
     * @param string $componentName コンポーネント名
     * @param string $designName デザイン名
     * @param array $props デフォルトプロパティ
     * @param boolean $require_session セッションが必要かどうか
     */
    function __construct(string $componentName, string $designName, array $props = [], $require_session = false) {
        // Directory traversal対策
        if (!ctype_alnum($designName)) {
            throw new Exception('Invalid component name: ' . $designName);
        }
        elseif (!ctype_alnum($componentName)) {
            throw new Exception('Invalid component name: ' . $componentName);
        }

        // コンポーネントパス設定
        $this->componentPath = __DIR__ . '/../../components/'. $designName .'/' . $componentName . '.php';
        $this->props = $props;

        // セッションが必要な場合はセッションを開始
        if ($require_session && !isset($_SESSION)) {
            session_start();
        }
    }

    /**
     * コンポーネントを表示
     *
     * @param array $props 優先プロパティ
     * @return void
     */
    public function view(array $props = []) {
        if (count($props) > 0) {
            $this->props = $props;
        }

        $_PROPS = $this->props;
        require $this->componentPath;
    }

    /**
     * $flagがtrueの場合、コンポーネントを表示
     *
     * @param bool $flag フラグ
     * @param array $props 優先プロパティ
     * @return void
     */
    public function viewIf(bool $flag, array $props = []): bool {
        if (!$flag) {
            return false;
        }
        $this->view($props);
        return true;
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
     * @param array $componentNames コンポーネント名リスト
     */
    public static function importAtoms(array $componentNames = []): array {
        $viewObjects = [];
        foreach ($componentNames as $componentName) {
            $viewObjects[] = new ViewComponent($componentName, 'atoms');
        }
        return $viewObjects;
    }

    /**
     * Moleculeコンポーネントの読み込み
     *
     * @param array $componentNames コンポーネント名リスト
     */
    public static function importMolecules(array $componentNames): array {
        $viewObjects = [];
        foreach ($componentNames as $componentName) {
            $viewObjects[] = new ViewComponent($componentName, 'molecules');
        }
        return $viewObjects;
    }

    /**
     * Organismコンポーネントの読み込み
     *
     * @param array $componentNames コンポーネント名リスト
     */
    public static function importOrganisms(array $componentNames): array {
        $viewObjects = [];
        foreach ($componentNames as $componentName) {
            $viewObjects[] = new ViewComponent($componentName, 'organisms');
        }
        return $viewObjects;
    }

    /**
     * Templateコンポーネントの読み込み
     *
     * @param array $componentNames コンポーネント名リスト
     */
    public static function importTemplates(array $componentNames): array {
        $viewObjects = [];
        foreach ($componentNames as $componentName) {
            $viewObjects[] = new ViewComponent($componentName, 'templates');
        }
        return $viewObjects;
    }

    /**
     * Pageコンポーネントの読み込み
     *
     * @param string $componentName コンポーネント名
     */
    public static function importPage(string $componentName): ViewComponent {
        return new ViewComponent($componentName, 'pages');
    }
}
