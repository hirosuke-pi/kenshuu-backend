<?php

class UsersRepo {
    public static function getUserByEmail(string $email): UsersDTO {
        $db = PDOFactory::getPDOInstance();
        $usersDao = new UsersDAO($db);

        return $usersDao->getUserByEmail($email);
    }

    public static function getUserById(string $id): UsersDTO {
        $db = PDOFactory::getPDOInstance();
        $usersDao = new UsersDAO($db);

        return $usersDao->getUserById($id);
    }
}
