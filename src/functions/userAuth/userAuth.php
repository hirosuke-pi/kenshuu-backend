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
     * @return string ログインユーザー
     */
    public static function getLoginUserIdWithException(): string {
        if (self::isLogin()) {
            return $_SESSION[self::SESSION_INDEX];
        } else {
            throw new Exception('ユーザーの認証が必要な項目です。ログインしてください。');
        }
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
