<?php

class ActionPage {
    private array $actionMethods;

    /**
     * アクションページを作成
     *
     * @param boolean $isCheckCsrfToken CSRFトークンをチェックするかどうか
     */
    function __construct(bool $isCheckCsrfToken = true) {
        session_start();
        $this->actionMethods = [];

        // CSRFトークンをチェック
        if ($isCheckCsrfToken) {
            $this->checkCsrfToken();
        }
    }

    /**
     * CSRFトークンをチェック (Session使用)
     *
     * @return void
     */
    private function checkCsrfToken () {
        // CSRFトークン有無チェック
        if (!isset($_SESSION[CSRF_NAME]) || !isset($_REQUEST[CSRF_NAME])) {
            throw new Exception('CSRF token is not set');
        }
        // CSRFトークン一致チェック
        if ($_SESSION[CSRF_NAME] !== $_REQUEST[CSRF_NAME]) {
            throw new Exception('CSRF token is invalid');
        }

        // CSRFトークンを破棄
        unset($_SESSION[CSRF_NAME]);
        unset($_REQUEST[CSRF_NAME]);
    }

    /**
     * GET, POST, PUT, DELETEを判定してアクションを実行
     * 実行後は、設定したアクションのレスポンスをセッションに保存してリダイレクトする
     *
     * @return void
     */
    public function dispatch() {
        // HTTPメソッドを取得
        $method = $_SERVER['REQUEST_METHOD'];
        if (isset($_REQUEST[METHOD_NAME]) && in_array(strtoupper($_REQUEST[METHOD_NAME]), ['PUT', 'DELETE'])) {
            $method = strtoupper($_REQUEST[METHOD_NAME]);
        }

        // HTTPメソッドが存在するか
        if (!isset($this->actionMethods[$method])) {
            throw new Exception('Invalid method: ' . $method);
        }
        
        // HTTPメソッドに対するクロージャー・パラメーター取得
        $actionMethod = $this->actionMethods[$method];
        $requireParams = $actionMethod->getRequireParams();

        // 必須パラメーターが存在するか
        checkKeyTypes($_REQUEST, $requireParams);

        // クロージャーを実行
        $response = $actionMethod->action($_REQUEST);

        // セッションにレスポンスを保存
        $_SESSION['action_response'] = [
            'data' => $response->getData(),
            'isError' => $response->getError(),
        ];

        // リダイレクト
        header('Location: ' . $response->getLocation());
    }

    /**
     * GETメソッドのアクションを設定
     *
     * @param Closure $getAction GETメソッドのアクション
     * @param array $requireParams 必須パラメーター ['key' => 'keyType', ...]
     * @return void
     */
    public function get(Closure $getAction, array $requireParams = []) {
        $this->actionMethods['GET'] = new ActionMethod('GET', $getAction, $requireParams);
    }

    /**
     * POSTメソッドのクロージャーを設定
     *
     * @param Closure $postAction POSTメソッドのクロージャー
     * @param array $requireParams 必須パラメーター ['key' => 'keyType', ...]
     * @return void
     */
    public function post(Closure $postAction, array $requireParams = []) {
        $this->actionMethods['POST'] = new ActionMethod('POST', $postAction, $requireParams);
    }

    /**
     * DELETEメソッドのクロージャーを設定
     *
     * @param Closure $deleteAction DELETEメソッドのクロージャー
     * @param array $requireParams 必須パラメーター ['key' => 'keyType', ...]
     * @return void
     */
    public function delete(Closure $deleteAction, array $requireParams = []) {
        $this->actionMethods['DELETE'] = new ActionMethod('DELETE', $deleteAction, $requireParams);
    }

    /**
     * PUTメソッドのクロージャーを設定
     *
     * @param Closure $patchAction PUTメソッドのクロージャー
     * @param array $requireParams 必須パラメーター ['key' => 'keyType', ...]
     * @return void
     */
    public function put(Closure $patchAction, array $requireParams = []) {
        $this->actionMethods['PUT'] = new ActionMethod('PUT', $patchAction, $requireParams);
    }
}

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

class ActionResponse {
    private string $location;
    private bool $isError;
    private array $data;

    /**
     * アクションのレスポンスを作成
     *
     * @param string $location リダイレクト先パス
     * @param array $data $_SESSIONに格納するデータ
     * @param boolean $isError エラーかどうか
     */
    function __construct(string $location, array $data = [], bool $isError = false) {
        $this->location = $location;
        $this->data = $data;
        $this->isError = $isError;
    }

    /**
     * リダイレクト先を取得
     *
     * @return string リダイレクト先パス
     */
    public function getLocation(): string {
        return $this->location;
    }

    /**
     * $_SESSIONに格納するデータを取得
     *
     * @return array $_SESSIONに格納するデータ
     */
    public function getData(): array {
        return $this->data;
    }

    /**
     * エラーかどうかを取得
     *
     * @return boolean エラーかどうか
     */
    public function getError(): bool {
        return $this->isError;
    }
}
