<?php

class TagsDAO {
    public const TAGS_TABLE = 'tags';
    public const RELATION_TAGS_POSTS_TABLE = 'posts_tags';

    function __construct(private ?PDO $db = null) {
        if (is_null($this->db)) {
            $this->db = PDOFactory::getNewPDOInstance();
        }
    }

    /**
     * 渡されたStatementを元に、複数のタグを取得・TagsDTOに格納
     *
     * @param PDOStatement $stmt TagsテーブルのPDOStatement
     * @return array TagsDTOの配列
     */
    private function fetchAllStatement(PDOStatement $stmt): array {
        if (!$stmt->execute()) {
            return [];
        }

        $tagsDtoList = [];
        $tags = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($tags as $tag) {
            $tagsDtoList[] = new TagsDTO(
                $tag['id'],
                $tag['tag_name'],
            );
        }
        return $tagsDtoList;
    }

    /**
     * 全てのタグを取得
     *
     * @return array TagsDTOの配列
     */
    public function getTags(): array {
        $sql = 'SELECT * FROM '. $this::TAGS_TABLE;
        $stmt = $this->db->query($sql);
        
        return $this->fetchAllStatement($stmt);
    }

    /**
     * ニュースに付与されたタグを取得
     *
     * @param string $postId ニュースID
     * @return array TagsDTOの配列
     */
    public function getTagsByPostId(string $postId): array {
        $tagTable = $this::TAGS_TABLE;
        $relationTable = $this::RELATION_TAGS_POSTS_TABLE;

        $sql = <<<SQL
            SELECT id, tag_name
                FROM {$tagTable}
            INNER JOIN {$relationTable}
                ON {$tagTable}.id = {$relationTable}.tag_id
            WHERE post_id = :post_id
        SQL;
    
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':post_id', $postId, PDO::PARAM_STR);

        return $this->fetchAllStatement($stmt);
    }

    /**
     * ニュースにタグを付与
     *
     * @param string $tagId タグID
     * @param string $postId ニュースID
     * @return bool トランザクションが成功したかどうか
     */
    public function addTagByPostId(string $tagId, string $postId): bool {
        $relationTable = $this::RELATION_TAGS_POSTS_TABLE;

        $sql = <<<SQL
            INSERT INTO {$relationTable} (tag_id, post_id)
                VALUES (:tag_id, :post_id)
        SQL;
    
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':tag_id', $tagId, PDO::PARAM_STR);
        $stmt->bindValue(':post_id', $postId, PDO::PARAM_STR);

        return $stmt->execute();
    }
}
