<?php

class Component {
    public array $values;

    function __construct(Closure $actionComponent, array $propKeys = []) {
        foreach ($propKeys as $key => $type) {
            if (!array_key_exists($key, PROPS)) {
                // 必須プロパティが存在しなかった場合はエラーをスロー
                throw new Exception('Prop key not found: ' . $key);
            }
            elseif (gettype(PROPS[$key]) !== $type) {
                // 必須プロパティが型が一致しなければエラーをスロー
                throw new Exception('Prop type not match: ' . $key);
            }
        }

        $values = $actionComponent(PROPS);
        // 安全な形式にする
        $this->values = $values;
    }

    public static function viewAtom(string $componentName, array $props = []) {
        return new ViewComponent($componentName, 'atoms', $props);
    }

    public static function viewMolecule(string $componentName, array $props = []) {
        return new ViewComponent($componentName, 'molecules', $props);
    }

    public static function viewOrganism(string $componentName, array $props = []) {
        return new ViewComponent($componentName, 'organism', $props);
    }

    public static function viewTemplate(string $componentName, array $props = []) {
        return new ViewComponent($componentName, 'template', $props);
    }

    public static function viewPage(string $componentName, array $props = []) {
        return new ViewComponent($componentName, 'page', $props);
    }
}

class ViewComponent {
    private string $componentPath;

    function __construct(string $componentName, string $designName, array $props) {
        $this->componentPath = __DIR__ . '/../components/'. $designName .'/' . $componentName . '.php';
        define('PROPS', $props);
    }

    public function view() {
        require $this->componentPath;
    }
}
