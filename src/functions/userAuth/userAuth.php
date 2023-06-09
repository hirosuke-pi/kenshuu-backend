<?php

class UserAuth {
    private const SESSION_INDEX = 'login_user_id';

    /**
     * ログインしているか
     *
     * @return boolean ログインしているか
     */
    public static function isLogin(): bool {
        return isset($_SESSION[self::SESSION_INDEX]);
    }

    /**
     * ログイン
     *
     * @param string $user ログインしたいユーザー
     * @return void
     */
    public static function login(string $userId): void {
        $_SESSION[self::SESSION_INDEX] = $userId;
    }

    /**
     * ログアウト
     *
     * @return void
     */
    public static function logout(): void {
        unset($_SESSION[self::SESSION_INDEX]);
    }

    /**
     * ログインユーザーを取得
     *
     * @return ?string ログインユーザー
     */
    public static function getLoginUserId(): ?string {
        return $_SESSION[self::SESSION_INDEX] ?? null;
    }

    /**
     * ログインユーザーを取得
     *
     * @throws Exception ログインユーザーがいない場合スローする
     * @return string ログインユーザー
     */
    public static function getLoginUserIdWithException(string $userId = null): string {
        if (!self::isLogin()) {
            throw new Exception('ユーザーの認証が必要な項目です。ログインしてください。');
        }
        elseif (!is_null($userId) && $_SESSION[self::SESSION_INDEX] !== $userId) {
            throw new Exception('ユーザーIDが一致しません。ユーザー認証をしてください。');
        }
        return $_SESSION[self::SESSION_INDEX];
    }

    /**
     * ログインユーザーが指定したユーザーか
     *
     * @param string $userId 指定したいユーザー
     * @return boolean 指定したユーザーか
     */
    public static function isLoginUser(string $userId): bool {
        return self::isLogin() && self::getLoginUserId() === $userId;
    }
}
