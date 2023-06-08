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
     * リダイレクトデータが存在するか
     *
     * @return boolean リダイレクトデータが存在するか
     */
    public static function hasRedirectData(): bool {
        return isset($_SESSION[REDIRECT_INDEX]);
    }

    /**
     * リダイレクトデータを取得
     *
     * @return array|null リダイレクト時のセッションデータ
     */
    public static function getRedirectData(): ?array {
        if (!isset($_SESSION[REDIRECT_INDEX])) {
            return null;
        }

        $data = $_SESSION[REDIRECT_INDEX];
        unset($_SESSION[REDIRECT_INDEX]);
        return $data;
    }

    /**
     * リダイレクトステータスを取得
     *
     * @return array リダイレクト時のステータス
     */
    public static function getRedirectStatus(): array {
        if (!isset($_SESSION[REDIRECT_INDEX]['status']) || !isset($_SESSION[REDIRECT_INDEX]['message'])) {
            return [null, null];
        }

        $data = $_SESSION[REDIRECT_INDEX];
        unset($_SESSION[REDIRECT_INDEX]);

        return [$data['status'], $data['message']];
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
