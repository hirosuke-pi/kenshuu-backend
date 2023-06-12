<?php

class UsersRepo {
    /**
     * メールアドレスからユーザーを取得
     *
     * @param string $email メールアドレス
     * @return ?UsersDTO ユーザー情報
     */
    public static function getUserByEmail(string $email): ?UsersDTO {
        $db = PDOFactory::getPDOInstance();
        $usersDao = new UsersDAO($db);

        return $usersDao->getUserByEmail($email);
    }

    /**
     * ユーザーIDからユーザーを取得
     *
     * @param string $id ユーザーID
     * @return ?UsersDTO ユーザー情報
     */
    public static function getUserById(string $id): ?UsersDTO {
        $db = PDOFactory::getPDOInstance();
        $usersDao = new UsersDAO($db);

        return $usersDao->getUserById($id);
    }

    /**
     * ユーザーを作成
     *
     * @param string $username ユーザー名
     * @param string $email メールアドレス
     * @param string $password パスワード
     * @param string $profileImagePath プロフィール画像のパス
     * @return string ユーザーID
     */
    public static function createUser(string $username, string $email, string $password, string $profileImagePath = ''): string {
        $db = PDOFactory::getPDOInstance();
        $usersDao = new UsersDAO($db);

        $userId = $usersDao->createUser($username, $email, $password, $profileImagePath);
        if (is_null($userId)) {
            throw new Exception('ユーザーの作成に失敗しました。サーバーの管理者にお問い合わせください。');
        }

        return $userId;
    }

    /**
     * ユーザーを作成
     *
     * @param string $username ユーザー名
     * @param string $email メールアドレス
     * @param string $password パスワード
     * @param ?string $profileImagePath プロフィール画像のパス
     * @return string ユーザーID
     */
    public static function updateUser(string $userId, string $username, string $email, string $password, string $profileImagePath = null): string {
        $db = PDOFactory::getPDOInstance();
        $usersDao = new UsersDAO($db);

        if (!$usersDao->updateUser($userId, $username, $email, $password, $profileImagePath)) {
            throw new Exception('ユーザーの更新に失敗しました。サーバーの管理者にお問い合わせください。');
        }

        return $userId;
    }
}
