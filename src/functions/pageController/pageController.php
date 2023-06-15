<?php

class PageController {
    /**
     * リダイレクト
     *
     * @param string $url リダイレクト先のURL
     * @param int $statusCode ステータスコード
     * @return void
     */
    public static function redirect(string $url, array $data = [], int $statusCode = 302): void {
        if (count($data) > 0) {
            $_SESSION[REDIRECT_INDEX] = $data;
        }
        header('Location: ' . $url, true, $statusCode);
        exit;
    }

    /**
     * リダイレクト (ステータス付き)
     *
     * @param string $url リダイレクト先のURL
     * @param string $status ステータス
     * @param string $message メッセージ
     * @return void
     */
    public static function redirectWithStatus(string $url, string $status, string $message): void {
        PageController::redirect($url, ['status' => $status, 'message' => $message]);
    }

    /**
     * セッションデータがあるかどうか
     *
     * @return boolean
     */
    public static function hasRedirectData(): bool {
        return isset($_SESSION[REDIRECT_INDEX]);
    }

    /**
     * リダイレクトデータを取得
     *
     * @return array リダイレクト時のセッションデータ
     */
    public static function getRedirectData(): ?array {
        $data = $_SESSION[REDIRECT_INDEX] ?? null;
        unset($_SESSION[REDIRECT_INDEX]);
        return $data;
    }

    /**
     * セッションを開始
     *
     * @return void
     */
    public static function sessionStart(): void {
        if (!isset($_SESSION)) {
            session_start();
        }
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
}
