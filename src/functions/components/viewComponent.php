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
}
