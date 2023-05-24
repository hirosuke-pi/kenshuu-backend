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
            'data' => $response->data,
            'isError' => $response->isError,
        ];

        // リダイレクト
        header('Location: ' . $response->location);
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
