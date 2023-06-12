<?php

class PostsDAO {
    public const POSTS_TABLE = 'posts';

    public function __construct(private ?PDO $db = null) {
        if (is_null($this->db)) {
            $this->db = PDOFactory::getNewPDOInstance();
        }
    }

    /**
     * 渡されたStatementを元に、複数のニュースを取得・PostsDTOに格納
     *
     * @param PDOStatement $stmt PostsテーブルのPDOStatement
     * @return array PostsDTOの配列
     */
    private function fetchAllStatement(PDOStatement $stmt): array {
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

    /**
     * ニュースを作成
     *
     * @param string $userId ユーザーID
     * @param string $title タイトル
     * @param string $body 内容
     * @return boolean トランザクションが成功したかどうか
     */
    public function createPost(string $userId, string $title, string $body): string {
        $postsTable = $this::POSTS_TABLE;
        $sql = <<<SQL
            INSERT INTO {$postsTable} 
                (id, user_id, title, body)
            VALUES 
                (:id, :user_id, :title, :body)
        SQL;

        $postId = 'post_' . uniqid(mt_rand());
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $postId, PDO::PARAM_STR);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_STR);
        $stmt->bindValue(':title', $title, PDO::PARAM_STR);
        $stmt->bindValue(':body', $body, PDO::PARAM_STR);

        $stmt->execute();
        return $postId;
    }

    /**
     * 全てのニュースを取得
     *
     * @return array PostsDTOの配列
     */
    public function getPosts(): array {
        $postsTable = $this::POSTS_TABLE;
        $sql = <<<SQL
            SELECT * FROM 
                {$postsTable} 
            WHERE 
                deleted_at IS NULL
        SQL;

        $stmt = $this->db->query($sql);
        if (!$stmt->execute()) {
            return [];
        }

        return $this->fetchAllStatement($stmt);
    }

    /**
     * 検索ワードに一致するニュースを取得
     *
     * @return array PostsDTOの配列
     */
    public function getPostsByWord(string $word): array {
        $postsTable = $this::POSTS_TABLE;
        $sql = <<<SQL
            SELECT * FROM 
                {$postsTable} 
            WHERE
                (body LIKE :word OR title LIKE :title) AND
                deleted_at IS NULL
        SQL;

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':word', '%' .$word .'%', PDO::PARAM_STR);
        $stmt->bindValue(':title', '%' .$word .'%', PDO::PARAM_STR);

        if (!$stmt->execute()) {
            return [];
        }

        return $this->fetchAllStatement($stmt);
    }

    /**
     * ユーザーIDを元にニュースを取得
     *
     * @param string $userId ユーザーID
     * @return array PostsDTOの配列
     */
    public function getPostsByUserId(string $userId): array {
        $postsTable = $this::POSTS_TABLE;
        $sql = <<<SQL
            SELECT * FROM
                {$postsTable}
            WHERE
                user_id = :user_id AND deleted_at IS NULL
        SQL;

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_STR);
        if (!$stmt->execute()) {
            return [];
        }

        return $this->fetchAllStatement($stmt);
    }

    /**
     * ユーザーIDを元にニュースの件数を取得
     *
     * @param string $userId ユーザーID
     * @return integer ニュースの件数
     */
    public function getPostsCountByUserId(string $userId): int {
        $postsTable = $this::POSTS_TABLE;
        $sql = <<<SQL
            SELECT 
                COUNT(*) as count FROM {$postsTable}
            WHERE 
                user_id = :user_id AND deleted_at IS NULL
        SQL;

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_STR);
        if (!$stmt->execute()) {
            return 0;
        }

        $count = $stmt->fetch(PDO::FETCH_ASSOC);
        return $count['count'];
    }

    /**
     * ニュースIDを元にニュースを取得
     *
     * @param string $id ニュースID
     * @return PostsDTO|null ニュースのDTO
     */
    public function getPostById(string $id): ?PostsDTO {
        $postsTable = $this::POSTS_TABLE;
        $sql = <<<SQL
            SELECT * FROM 
                {$postsTable}
            WHERE
                id = :id AND deleted_at IS NULL
        SQL;

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

    /**
     * ニュースIDを元にニュースを更新
     *
     * @param string $id ニュースID
     * @param string $title タイトル
     * @param string $body 内容
     * @return boolean 更新に成功したかどうか
     */
    public function putPostById(string $id, string $title, string $body): bool {
        $postsTable = $this::POSTS_TABLE;
        $sql = <<<SQL
            UPDATE {$postsTable} 
            SET 
                title = :title, body = :body, updated_at = :updated_at 
            WHERE
                id = :id
        SQL;

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_STR);
        $stmt->bindValue(':title', $title, PDO::PARAM_STR);
        $stmt->bindValue(':body', $body, PDO::PARAM_STR);
        $stmt->bindValue(':updated_at', (new DateTime())->format(DateTime::ATOM), PDO::PARAM_STR);

        return $stmt->execute();
    }

    /**
     * ニュースIDを元にニュースを削除
     *
     * @param string $id ニュースID
     * @return boolean 削除に成功したかどうか
     */
    public function deletePostById(string $id): bool {
        $postsTable = $this::POSTS_TABLE;
        $sql = <<<SQL
            UPDATE {$postsTable}
            SET
                deleted_at = :deleted_at
            WHERE id = :id
        SQL;

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':deleted_at', (new DateTime())->format(DateTime::ATOM), PDO::PARAM_STR);
        $stmt->bindValue(':id', $id, PDO::PARAM_STR);

        return $stmt->execute();
    }
}
