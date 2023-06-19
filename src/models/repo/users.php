<?php

class UsersRepo {
    /**
     * メールアドレスからユーザーを取得
     *
     * @param string $email メールアドレス
     * @param ?PDO $pdo PDOインスタンス
     * @return ?UsersDTO ユーザー情報
     */
    public static function getUserByEmail(string $email, PDO $pdo = null): ?UsersDTO {
        if (is_null($pdo)) $pdo = PDOFactory::getPDOInstance();
        $usersDao = new UsersDAO($pdo);

        return $usersDao->getUserByEmail($email);
    }

    /**
     * ユーザーIDからユーザーを取得
     *
     * @param string $id ユーザーID
     * @param ?PDO $pdo PDOインスタンス
     * @return ?UsersDTO ユーザー情報
     */
    public static function getUserById(string $id, PDO $pdo = null): ?UsersDTO {
        if (is_null($pdo)) $pdo = PDOFactory::getPDOInstance();
        $usersDao = new UsersDAO($pdo);

        return $usersDao->getUserById($id);
    }

    /**
     * ユーザーを作成
     *
     * @param string $username ユーザー名
     * @param string $email メールアドレス
     * @param string $password パスワード
     * @param string $profileImagePath プロフィール画像のパス
     * @param ?PDO $pdo PDOインスタンス
     * @return string ユーザーID
     */
    public static function createUser(string $username, string $email, string $password, string $profileImagePath = '', PDO $pdo = null): string {
        if (is_null($pdo)) $pdo = PDOFactory::getPDOInstance();
        $usersDao = new UsersDAO($pdo);

        $userId = $usersDao->createUser($username, $email, $password, $profileImagePath);
        if (is_null($userId)) {
            throw new Exception('ユーザーの作成に失敗しました。サーバーの管理者にお問い合わせください。');
        }

        return $userId;
    }
}
