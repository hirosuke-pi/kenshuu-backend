<?php

class PostsDAO {
    private PDO $db;
    public const POSTS_TABLE = 'posts';

    function __construct(PDO $db) {
        $this->db = $db;
    }

    public function createPost(string $userId, string $title, string $body): bool {
        $sql = 'INSERT INTO '. $this::POSTS_TABLE .' (id, user_id, title, body) VALUES (:id, :user_id, :title, :body)';
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', 'post_' . uniqid(mt_rand()), PDO::PARAM_STR);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_STR);
        $stmt->bindValue(':title', $title, PDO::PARAM_STR);
        $stmt->bindValue(':body', $body, PDO::PARAM_STR);

        return $stmt->execute();
    }

    private function fetchAllStatement(PDOStatement $stmt) {
        $postDtoList = [];
        $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($posts as $post) {
            $postDtoList[] = new PostsDTO(
                $post['id'],
                $post['user_id'],
                $post['title'],
                $post['body'],
                $post['created_at'],
                $post['updated_at'],
                $post['deleted_at'],
            );
        }
        return $postDtoList;
    }

    public function getPosts(): array {
        $sql = 'SELECT * FROM '. $this::POSTS_TABLE .' WHERE deleted_at IS NULL';
        $stmt = $this->db->query($sql);
        if (!$stmt->execute()) {
            return [];
        }

        return $this->fetchAllStatement($stmt);
    }

    public function getPostsByUserId(string $userId): array {
        $sql = 'SELECT * FROM '. $this::POSTS_TABLE .' WHERE user_id = :user_id AND deleted_at IS NULL';
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_STR);
        if (!$stmt->execute()) {
            return [];
        }

        return $this->fetchAllStatement($stmt);
    }

    public function getPostsCountByUserId(string $userId): int {
        $sql = 'SELECT COUNT(*) as count FROM '. $this::POSTS_TABLE .' WHERE user_id = :user_id AND deleted_at IS NULL';
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_STR);
        if (!$stmt->execute()) {
            return 0;
        }

        $count = $stmt->fetch(PDO::FETCH_ASSOC);
        return $count['count'];
    }

    public function getPostById(string $id): ?PostsDTO {
        $sql = 'SELECT * FROM '. $this::POSTS_TABLE .' WHERE id = :id AND deleted_at IS NULL';
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_STR);

        if (!$stmt->execute()) {
            return null;
        }

        $postData = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!isset($postData['id'])) {
            return null;
        }
        return new PostsDTO(
            $postData['id'],
            $postData['user_id'],
            $postData['title'],
            $postData['body'],
            $postData['created_at'],
            $postData['updated_at'],
            $postData['deleted_at'],
        );
    }

    public function putPostById(string $id, string $title, string $body): bool {
        $sql = 'UPDATE '. $this::POSTS_TABLE .' SET title = :title, body = :body, updated_at = :updated_at WHERE id = :id';
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_STR);
        $stmt->bindValue(':title', $title, PDO::PARAM_STR);
        $stmt->bindValue(':body', $body, PDO::PARAM_STR);
        $stmt->bindValue(':updated_at', (new DateTime())->format(DateTime::ATOM), PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function deletePostById(string $id): bool {
        $sql = 'UPDATE '. $this::POSTS_TABLE .' SET deleted_at = :deleted_at WHERE id = :id';
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':deleted_at', (new DateTime())->format(DateTime::ATOM), PDO::PARAM_STR);
        $stmt->bindValue(':id', $id, PDO::PARAM_STR);

        return $stmt->execute();
    }
}
