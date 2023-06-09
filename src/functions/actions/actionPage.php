<?php

class ActionPage {
    private array $actionMethods;

    /**
     * アクションページを作成
     *
     * @param boolean $isCheckCsrfToken CSRFトークンをチェックするかどうか
     */
    function __construct() {
        PageController::sessionStart();
        $this->actionMethods = [];
    }

    /**
     * CSRFトークンをチェック (Session使用)
     *
     * @return void
     */
    private function checkCsrfToken(string $prefix) {
        $CsrfNameWithPrefix = $prefix .'_'. CSRF_NAME;

        // CSRFトークン有無チェック
        if (!isset($_SESSION[$CsrfNameWithPrefix]) || !isset($_REQUEST[$CsrfNameWithPrefix])) {
            throw new Exception('CSRFトークンが設定されていません。');
        }
        // CSRFトークン一致チェック
        if ($_SESSION[$CsrfNameWithPrefix] !== $_REQUEST[$CsrfNameWithPrefix]) {
            throw new Exception('CSRFトークンが一致しません。');
        }

        // CSRFトークンを破棄
        unset($_SESSION[$CsrfNameWithPrefix]);
        unset($_REQUEST[$CsrfNameWithPrefix]);
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
                throw new Exception('必須パラメーターが存在しません。'. $key);
            }
            elseif (gettype($params[$key]) !== $type) {
                // 必須パラメーターが型が一致しなければエラーをスロー
                throw new Exception('必須パラメーターの型('. $type .')が一致しません: ' . $key .'('. gettype($params[$key]) .')');
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
        try {
            // HTTPメソッドを取得
            $method = $_SERVER['REQUEST_METHOD'];
            if (isset($_REQUEST[METHOD_NAME]) && in_array(strtoupper($_REQUEST[METHOD_NAME]), ['PUT', 'DELETE'], true)) {
                $method = strtoupper($_REQUEST[METHOD_NAME]);
            }

            // HTTPメソッドが存在するか
            if (!isset($this->actionMethods[$method])) {
                throw new Exception('許可されていないメソッドです。');
            }

            // HTTPメソッドに対するクロージャー・パラメーター取得
            $actionMethod = $this->actionMethods[$method];

            // CSRFトークンをチェック
            $this->checkCsrfToken($actionMethod->csrfPrefix);

            // 必須パラメーターが存在するか
            self::checkKeyTypes($_REQUEST, $actionMethod->requireParams);

            // クロージャーを実行
            $response = ($actionMethod->action)($_REQUEST);

            // リダイレクト
            PageController::redirectWithStatus($response->location, $response->status, $response->message, $response->data);
        }
        catch (Exception $error) {
            PageController::redirectWithStatus('/error.php', 'error', $error->getMessage());
            return;
        }
    }

    /**
     * GETメソッドのアクションを設定
     *
     * @param Closure $getAction GETメソッドのアクション
     * @param array $requireParams 必須パラメーター ['key' => 'keyType', ...]
     * @return void
     */
    public function get(Closure $getAction, string $csrfPrefix, array $requireParams = []) {
        $this->actionMethods['GET'] = new ActionMethod('GET', $getAction, $csrfPrefix, $requireParams);
    }

    /**
     * POSTメソッドのクロージャーを設定
     *
     * @param Closure $postAction POSTメソッドのクロージャー
     * @param array $requireParams 必須パラメーター ['key' => 'keyType', ...]
     * @return void
     */
    public function post(Closure $postAction, string $csrfPrefix, array $requireParams = []) {
        $this->actionMethods['POST'] = new ActionMethod('POST', $postAction, $csrfPrefix, $requireParams);
    }

    /**
     * DELETEメソッドのクロージャーを設定
     *
     * @param Closure $deleteAction DELETEメソッドのクロージャー
     * @param array $requireParams 必須パラメーター ['key' => 'keyType', ...]
     * @return void
     */
    public function delete(Closure $deleteAction, string $csrfPrefix, array $requireParams = []) {
        $this->actionMethods['DELETE'] = new ActionMethod('DELETE', $deleteAction, $csrfPrefix, $requireParams);
    }

    /**
     * PUTメソッドのクロージャーを設定
     *
     * @param Closure $patchAction PUTメソッドのクロージャー
     * @param array $requireParams 必須パラメーター ['key' => 'keyType', ...]
     * @return void
     */
    public function put(Closure $putAction, string $csrfPrefix, array $requireParams = []) {
        $this->actionMethods['PUT'] = new ActionMethod('PUT', $putAction, $csrfPrefix, $requireParams);
    }
}
