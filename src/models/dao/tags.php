<?php

class TagsDAO {
    public const TAGS_TABLE = 'tags';

    function __construct(private ?PDO $db = null) {
        if (is_null($this->db)) {
            $this->db = PDOFactory::getNewPDOInstance();
        }
    }

    public function getTags(): array {
        $sql = 'SELECT * FROM '. $this::TAGS_TABLE;
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
