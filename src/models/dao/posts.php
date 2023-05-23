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

    public function getPosts(): array {
        $sql = 'SELECT * FROM '. $this::POSTS_TABLE .' WHERE deleted_at IS NULL';
        $stmt = $this->db->query($sql);
        if (!$stmt->execute()) {
            return [];
        }

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

    public function getPostId(string $id): PostsDTO {
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
}
