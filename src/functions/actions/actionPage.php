<?php

class ActionPage {
    private array $actionMethods;

    /**
     * アクションページを作成
     *
     * @param boolean $isCheckCsrfToken CSRFトークンをチェックするかどうか
     */
    function __construct(bool $isCheckCsrfToken = true) {
        PageController::sessionStart();
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
            PageController::redirect('/error.php', ['message' => 'CSRFトークンが設定されていません。']);
        }
        // CSRFトークン一致チェック
        if ($_SESSION[CSRF_NAME] !== $_REQUEST[CSRF_NAME]) {
            PageController::redirect('/error.php', ['message' => 'CSRFトークンが一致しません。']);
        }

        // CSRFトークンを破棄
        unset($_SESSION[CSRF_NAME]);
        unset($_REQUEST[CSRF_NAME]);
    }

    /**
     * キーとその型をチェック
     *
     * @param array $params チェックしたい配列
     * @param array $requirePropKeys チェックするキーとその型
     * @return void
     */
    private function checkKeyTypes(array $params, array $requirePropKeys): void {
        foreach ($requirePropKeys as $key => $type) {
            if (!array_key_exists($key, $params)) {
                // 必須パラメーターが存在しなかった場合はエラーをスロー
                throw new Exception('Required parameter key not found: ' . $key);
            }
            elseif (gettype($params[$key]) !== $type) {
                // 必須パラメーターが型が一致しなければエラーをスロー
                throw new Exception('Required parameter type('. $type .') not match: ' . $key .'('. gettype($params[$key]) .')');
            }
        }
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
            PageController::redirect('/error.php', ['message' => '許可されていないメソッドです。']);
        }
        
        // HTTPメソッドに対するクロージャー・パラメーター取得
        $actionMethod = $this->actionMethods[$method];

        // 必須パラメーターが存在するか
        self::checkKeyTypes($_REQUEST, $actionMethod->requireParams);

        // クロージャーを実行
        $response = ($actionMethod->action)($_REQUEST);

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
    public function put(Closure $putAction, array $requireParams = []) {
        $this->actionMethods['PUT'] = new ActionMethod('PUT', $putAction, $requireParams);
    }
}
