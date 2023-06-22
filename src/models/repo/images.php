<?php

class ImagesRepo {
    /**
     * サムネイルの画像パスを取得
     *
     * @param string $postId 投稿ID
     * @param ?PDO $pdo PDOインスタンス
     * @return string 画像パス
     */
    public static function getThumbnailSrcByPostId(string $postId, PDO $pdo = null): string {
        if (is_null($pdo)) $pdo = PDOFactory::getPDOInstance();

        $imagesDao = new ImagesDAO($pdo);
        $imagesDto = $imagesDao->getThumbnailByPostId($postId);

        if (is_null($imagesDto)) {
            return DEFAULT_THUMBNAIL;
        } 

        return '/img/news/'. $postId .'/'. $imagesDto->filePath;
    }

    /**
     * 投稿IDを元に画像パスリストを取得
     *
     * @param string $postId 投稿ID
     * @param ?PDO $pdo PDOインスタンス
     * @return array 画像パスリスト
     */
    public static function getImagesSrcByPostId(string $postId, PDO $pdo = null): array {
        if (is_null($pdo)) $pdo = PDOFactory::getPDOInstance();

        $imagesDao = new ImagesDAO($pdo);
        $imagesDtoList = $imagesDao->getImagesByPostId($postId);

        $imagesSrcList = [];
        foreach($imagesDtoList as $imagesDto) {
            $imagesSrcList[] = '/img/news/'. $postId .'/'. $imagesDto->filePath;
        }

        return $imagesSrcList;
    }

    /**
     * 画像データをテーブルに挿入
     *
     * @param string $postId 投稿ID
     * @param boolean $thumbnailFlag サムネイルかどうか
     * @param string $fileExt ファイル拡張子
     * @param ?PDO $pdo PDOインスタンス
     * @return string 画像ファイル名
     */
    public static function createImageFile(string $postId, bool $thumbnailFlag, string $fileExt, PDO $pdo = null): string {
        if (is_null($pdo)) $pdo = PDOFactory::getPDOInstance();
        $imagesDao = new ImagesDAO($pdo);

        $imageId = 'image_' . uniqid(mt_rand());
        $filename = $imageId .'.'. convertSpecialCharsToHtmlEntities($fileExt);
        $imagesDao->createImage($imageId, $postId, $thumbnailFlag, $filename);

        return $filename;
    }
}
