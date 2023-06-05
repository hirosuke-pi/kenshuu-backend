<?php

class TagsDAO {
    private PDO $db;
    public const POSTS_TABLE = 'posts';

    function __construct(PDO $db) {
        $this->db = $db;
    }

    public function getTags(): array {
        $sql = 'SELECT * FROM '. $this::POSTS_TABLE;
        $stmt = $this->db->query($sql);
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
}
