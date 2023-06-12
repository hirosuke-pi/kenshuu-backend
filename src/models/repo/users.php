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
        if (strlen($username) < 5) {
            throw new Exception('ユーザー名は5文字以上で入力してください。');
        }
        elseif (strlen($password) < 8) {
            throw new Exception('パスワードは8文字以上で入力してください。'. strlen($password));
        }
        elseif (!preg_match('/^[a-zA-Z0-9_+-]+(.[a-zA-Z0-9_+-]+)*@([a-zA-Z0-9][a-zA-Z0-9-]*[a-zA-Z0-9]*\.)+[a-zA-Z]{2,}$/', $email)) {
            throw new Exception('不正なメールアドレス形式でです。');
        }
        
        $db = PDOFactory::getPDOInstance();
        $usersDao = new UsersDAO($db);

        $userId = $usersDao->createUser($username, $email, $password, $profileImagePath);
        if (is_null($userId)) {
            throw new Exception('ユーザーの作成に失敗しました。サーバーの管理者にお問い合わせください。');
        }

        return $userId;
    }
}
