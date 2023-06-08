<?php

class UsersRepo {
    /**
     * メールアドレスからユーザーを取得
     *
     * @param string $email メールアドレス
     * @return UsersDTO ユーザー情報
     */
    public static function getUserByEmail(string $email): UsersDTO {
        $db = PDOFactory::getPDOInstance();
        $usersDao = new UsersDAO($db);

        return $usersDao->getUserByEmail($email);
    }

    /**
     * ユーザーIDからユーザーを取得
     *
     * @param string $id ユーザーID
     * @return UsersDTO ユーザー情報
     */
    public static function getUserById(string $id): UsersDTO {
        $db = PDOFactory::getPDOInstance();
        $usersDao = new UsersDAO($db);

        return $usersDao->getUserById($id);
    }
}
