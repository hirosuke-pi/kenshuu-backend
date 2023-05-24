<?php

class ActionMethod {
    private string $method;
    private Closure $action;
    private array $requireParams;

    /**
     * 各HTTPメソッドのクロージャーを作成
     *
     * @param string $method HTTPメソッド
     * @param Closure $action アクション
     * @param array $requireParams 必須パラメーター ['key' => 'keyType', ...]
     */
    function __construct(string $method, Closure $action, array $requireParams) {
        $this->method = $method;
        $this->action = $action;
        $this->requireParams = $requireParams;
    }

    /**
     * HTTPメソッドを取得
     *
     * @return string HTTPメソッド
     */
    public function getMethod(): string {
        return $this->method;
    }

    /**
     * 必須パラメーターを取得
     *
     * @return array 必須パラメーター ['key' => 'keyType', ...]
     */
    public function getRequireParams(): array {
        return $this->requireParams;
    }

    /**
     * クロージャーを実行
     *
     * @param array $params パラメーター
     * @return ActionResponse アクションのレスポンス
     */
    public function action(array $params = []): ActionResponse {
        return ($this->action)($params);
    }
}
