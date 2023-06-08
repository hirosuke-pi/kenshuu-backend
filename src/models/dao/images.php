<?php

class ImagesDAO {
    public const IMAGES_TABLE = 'images';

    function __construct(private ?PDO $db = null) {
        if (is_null($this->db)) {
            $this->db = PDOFactory::getNewPDOInstance();
        }
    }

    /**
     * 画像を作成
     *
     * @param string $postId 投稿ID
     * @param bool $thumbnailFlag サムネイルフラグ
     * @param string $filePath ファイルパス
     * @return boolean トランザクションが成功したかどうか
     */
    public function createImage(string $imageId, string $postId, bool $thumbnailFlag, string $filePath): string {
        $imagesTable= $this::IMAGES_TABLE;
        $sql = <<<SQL
            INSERT INTO {$imagesTable} 
                (id, post_id, thumbnail_flag, file_path) 
            VALUES 
                (:id, :post_id, :thumbnail_flag, :file_path)
        SQL;

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $imageId, PDO::PARAM_STR);
        $stmt->bindValue(':post_id', $postId, PDO::PARAM_STR);
        $stmt->bindValue(':thumbnail_flag', $thumbnailFlag, PDO::PARAM_BOOL);
        $stmt->bindValue(':file_path', $filePath, PDO::PARAM_STR);

        $stmt->execute();
        return $imageId;
    }

    /**
     * 投稿IDを元に画像を取得
     *
     * @param string $postId
     * @return array
     */
    public function getImagesByPostId(string $postId): array {
        $imagesTable = $this::IMAGES_TABLE;
        $sql = <<<SQL
            SELECT * FROM 
                {$imagesTable}
            WHERE 
                post_id = :post_id AND thumbnail_flag = FALSE
        SQL;

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':post_id', $postId, PDO::PARAM_STR);

        if (!$stmt->execute()) {
            return [];
        }

        $imagesDtoList = [];
        $images = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($images as $image) {
            $imagesDtoList[] = new ImagesDTO(
                $image['id'],
                $image['post_id'],
                $image['thumbnail_flag'],
                $image['file_path'],
            );
        }
        return $imagesDtoList;
    }

    /**
     * 投稿IDを元に画像を取得
     *
     * @param string $postId 投稿ID
     * @return ?ImagesDTO 画像DTO
     */
    public function getThumbnailByPostId(string $postId): ?ImagesDTO {
        $imagesTable = $this::IMAGES_TABLE;
        $sql = <<<SQL
            SELECT * FROM 
                {$imagesTable}
            WHERE
                post_id = :post_id AND thumbnail_flag = TRUE
        SQL;
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':post_id', $postId, PDO::PARAM_STR);

        if (!$stmt->execute()) {
            return [];
        }

        $image = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$image) {
            return null;
        }

        return new ImagesDTO(
            $image['id'],
            $image['post_id'],
            $image['thumbnail_flag'],
            $image['file_path'],
        );
    }
}
