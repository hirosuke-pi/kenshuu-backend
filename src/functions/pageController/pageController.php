<?php

class PageController {
    /**
     * リダイレクト
     *
     * @param string $url リダイレクト先のURL
     * @param int $statusCode ステータスコード
     * @return void
     */
    public static function redirect(string $url, array $data = [], int $statusCode = 303): void {
        if (count($data) > 0) {
            $_SESSION[REDIRECT_INDEX] = $data;
        }
        header('Location: ' . $url, true, $statusCode);
        exit;
    }

    /**
     * リダイレクトデータを取得
     *
     * @return array リダイレクト時のセッションデータ
     */
    public static function getRedirectData(): array {
        $data = $_SESSION[REDIRECT_INDEX] ?? [];
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
}
