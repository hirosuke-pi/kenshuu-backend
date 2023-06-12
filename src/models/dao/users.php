<?php

class UsersDAO {
    public const USERS_TABLE = 'users';

    public function __construct(private ?PDO $db = null) {
        if (is_null($this->db)) {
            $this->db = PDOFactory::getNewPDOInstance();
        }
    }

    /**
     * ユーザーを作成
     *
     * @param string $username ユーザー名
     * @param string $email メールアドレス
     * @param string $password パスワード(未ハッシュ)
     * @param string $profileImagePath プロフィール画像のパス
     * @return ?string ユーザーID
     */
    public function createUser(string $username, string $email, string $password, string $profileImagePath = ''): ?string {
        $usersTable = $this::USERS_TABLE;
        $sql = <<<SQL
            INSERT INTO {$usersTable}
                (id, username, email, password, profile_img_path)
            VALUES
                (:id, :username, :email, :password, :profile_img_path)
        SQL;

        $userId = 'user_'.uniqid(mt_rand());
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $userId, PDO::PARAM_STR);
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':password', password_hash($password, PASSWORD_DEFAULT), PDO::PARAM_STR);
        $stmt->bindValue(':profile_img_path', $profileImagePath, PDO::PARAM_STR);
        
        if (!$stmt->execute()) {
            return null;
        }

        return $userId;
    }

    /**
     * ユーザーを更新
     *
     * @param string $userId ユーザーID
     * @param string $username ユーザー名
     * @param string $email メールアドレス
     * @param string $password パスワード(未ハッシュ)
     * @param ?string $profileImagePath プロフィール画像のパス
     * @return boolean
     */
    public function updateUser(string $userId, string $username, string $email, string $password, string $profileImagePath = null): bool {
        $usersTable = $this::USERS_TABLE;
        $profileImageQuery = is_null($profileImagePath) ? '' : ', profile_img_path = :profile_img_path';
        $sql = <<<SQL
            UPDATE {$usersTable}
            SET
                username = :username, email = :email, password = :password {$profileImageQuery}
            WHERE
                id = :id
        SQL;

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $userId, PDO::PARAM_STR);
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':password', password_hash($password, PASSWORD_DEFAULT), PDO::PARAM_STR);
        if (!is_null($profileImagePath)) {
            $stmt->bindValue(':profile_img_path', $profileImagePath, PDO::PARAM_STR);
        }
        
        return $stmt->execute();
    }

    /**
     * メールアドレスをもとに、ユーザーを取得
     *
     * @param string $email メールアドレス
     * @return UsersDTO|null ユーザーが存在しない場合はnull
     */
    public function getUserByEmail(string $email): ?UsersDTO {
        $usersTable = $this::USERS_TABLE;
        $sql = <<<SQL
            SELECT * FROM
                {$usersTable} 
            WHERE
                email = :email AND deleted_at IS NULL
        SQL;

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

    /**
     * ユーザーIDをもとに、ユーザーを取得
     *
     * @param string $id ユーザーID
     * @return UsersDTO|null ユーザーが存在しない場合はnull
     */
    public function getUserById(string $id): ?UsersDTO {
        $usersTable = $this::USERS_TABLE;
        $sql = <<<SQL
            SELECT * FROM 
                {$usersTable}
            WHERE
                id = :id AND deleted_at IS NULL
        SQL;

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
