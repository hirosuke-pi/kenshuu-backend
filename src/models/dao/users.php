<?php

class UsersDAO {
    private PDO $db;
    public const USERS_TABLE = 'users';

    function __construct(PDO $db) {
        $this->db = $db;
    }

    public function createUser(string $username, string $email, string $password, string $profileImagePath = ''): bool {
        $sql = 'INSERT INTO '. $this::USERS_TABLE .' (id, username, email, password, profile_img_path) VALUES (:id, :username, :email, :password, :profile_img_path)';
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', 'user_'.uniqid(mt_rand()), PDO::PARAM_STR);
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':password', password_hash($password, PASSWORD_DEFAULT), PDO::PARAM_STR);
        $stmt->bindValue(':profile_img_path', $profileImagePath, PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function getUserByEmail(string $email): ?UsersDTO {
        $sql = 'SELECT * FROM '. $this::USERS_TABLE .' WHERE email = :email AND deleted_at IS NULL';
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!isset($user['id'])) {
            return null;
        }

        return new UsersDTO(
            $user['id'],
            $user['username'],
            $user['email'],
            $user['password'],
            $user['profile_img_path'],
            $user['created_at'],
            $user['deleted_at'],
        );
    }

    public function getUserById(string $id): ?UsersDTO {
        $sql = 'SELECT * FROM '. $this::USERS_TABLE .' WHERE id = :id AND deleted_at IS NULL';
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!isset($user['id'])) {
            return null;
        }

        return new UsersDTO(
            $user['id'],
            $user['username'],
            $user['email'],
            $user['password'],
            $user['profile_img_path'],
            $user['created_at'],
            $user['deleted_at'],
        );
    }
}
